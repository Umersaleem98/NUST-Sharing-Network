<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private int $importedCount = 0;
    private int $updatedCount = 0;
    private int $skippedCount = 0;

    private array $duplicates = [];
    private array $failures = [];

    private array $existingUsersByEmail = [];
    private array $existingQalamIds = [];

    private array $processedEmails = [];
    private array $processedQalamIds = [];

    private string $defaultPasswordHash;

    public function __construct(
        private readonly bool $updateExisting = false,
        private readonly ?int $importedBy = null
    ) {
        /*
        |--------------------------------------------------------------------------
        | Hash default password only once
        |--------------------------------------------------------------------------
        |
        | Users whose Excel password column is empty will use:
        |
        | 12345678
        |
        */

        $this->defaultPasswordHash = Hash::make('12345678');
    }

    /*
    |--------------------------------------------------------------------------
    | Import Excel rows
    |--------------------------------------------------------------------------
    */

    public function collection(Collection $rows): void
    {
        set_time_limit(300);

        /*
        |--------------------------------------------------------------------------
        | Load existing users once
        |--------------------------------------------------------------------------
        */

        $existingUsers = User::query()
            ->select([
                'id',
                'name',
                'email',
                'phone',
                'role',
                'qalam_id',
                'account_status',
            ])
            ->get();

        foreach ($existingUsers as $user) {

            if (! empty($user->email)) {
                $this->existingUsersByEmail[
                    strtolower(trim($user->email))
                ] = $user;
            }

            if (! empty($user->qalam_id)) {
                $this->existingQalamIds[
                    trim((string) $user->qalam_id)
                ] = $user->id;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare new records for bulk insertion
        |--------------------------------------------------------------------------
        */

        $newUsers = [];

        foreach ($rows as $index => $row) {

            $rowNumber = $index + 2;

            $data = $this->prepareRow($row);

            /*
            |--------------------------------------------------------------------------
            | Skip empty rows
            |--------------------------------------------------------------------------
            */

            if ($this->isCompletelyEmpty($data)) {
                $this->skippedCount++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Validate row
            |--------------------------------------------------------------------------
            */

            $validator = Validator::make(
                $data,
                $this->rules($data),
                $this->messages()
            );

            if ($validator->fails()) {

                $this->addFailure(
                    $rowNumber,
                    $data,
                    $validator->errors()->all()
                );

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Qalam ID only belongs to beneficiaries
            |--------------------------------------------------------------------------
            */

            if ($data['role'] !== 'beneficiary') {
                $data['qalam_id'] = null;
            }

            $emailKey = strtolower($data['email']);

            /*
            |--------------------------------------------------------------------------
            | Duplicate email inside uploaded Excel
            |--------------------------------------------------------------------------
            */

            if (isset($this->processedEmails[$emailKey])) {

                $this->duplicates[] = [
                    'row' => $rowNumber,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'reason' => 'Duplicate email exists in the Excel file.',
                ];

                $this->skippedCount++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Duplicate Qalam ID inside Excel
            |--------------------------------------------------------------------------
            */

            if (
                $data['role'] === 'beneficiary'
                && ! empty($data['qalam_id'])
            ) {
                $qalamKey = (string) $data['qalam_id'];

                if (isset($this->processedQalamIds[$qalamKey])) {

                    $this->duplicates[] = [
                        'row' => $rowNumber,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'reason' => 'Duplicate Qalam ID exists in the Excel file.',
                    ];

                    $this->skippedCount++;

                    continue;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Check existing database user
            |--------------------------------------------------------------------------
            */

            $existingUser =
                $this->existingUsersByEmail[$emailKey]
                ?? null;

            /*
            |--------------------------------------------------------------------------
            | Existing email
            |--------------------------------------------------------------------------
            */

            if ($existingUser && ! $this->updateExisting) {

                $this->duplicates[] = [
                    'row' => $rowNumber,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'reason' => 'A user with this email already exists.',
                ];

                $this->skippedCount++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Qalam ID database duplicate
            |--------------------------------------------------------------------------
            */

            if (
                $data['role'] === 'beneficiary'
                && ! empty($data['qalam_id'])
            ) {

                $qalamKey = (string) $data['qalam_id'];

                $ownerId =
                    $this->existingQalamIds[$qalamKey]
                    ?? null;

                if (
                    $ownerId !== null
                    && (
                        ! $existingUser
                        || $ownerId !== $existingUser->id
                    )
                ) {

                    $this->duplicates[] = [
                        'row' => $rowNumber,
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'reason' => 'Qalam ID already belongs to another user.',
                    ];

                    $this->skippedCount++;

                    continue;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update existing user
            |--------------------------------------------------------------------------
            */

            if ($existingUser) {

                try {

                    $updateData = [
                        'name' => $data['name'],
                        'phone' => $data['phone'],
                        'role' => $data['role'],
                        'qalam_id' => $data['qalam_id'],
                        'account_status' => $data['account_status'],
                        'status_reason' => $data['status_reason'],
                        'status_changed_by' => $this->importedBy,
                        'status_changed_at' =>
                            $data['account_status'] !== 'active'
                                ? now()
                                : null,
                        'updated_at' => now(),
                    ];

                    /*
                     * Only update password when Excel contains one.
                     */
                    if (! empty($data['password'])) {
                        $updateData['password'] =
                            Hash::make($data['password']);
                    }

                    DB::table('users')
                        ->where('id', $existingUser->id)
                        ->update($updateData);

                    $this->updatedCount++;

                } catch (\Throwable $exception) {

                    report($exception);

                    $this->addFailure(
                        $rowNumber,
                        $data,
                        [
                            'The existing user could not be updated.',
                        ]
                    );

                    continue;
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Password
                |--------------------------------------------------------------------------
                */

                if (! empty($data['password'])) {

                    /*
                     * Custom password supplied in Excel.
                     */
                    $passwordHash =
                        Hash::make($data['password']);

                } else {

                    /*
                     * Reuse the same already-generated hash.
                     */
                    $passwordHash =
                        $this->defaultPasswordHash;
                }

                /*
                |--------------------------------------------------------------------------
                | Add new user
                |--------------------------------------------------------------------------
                */

                $newUsers[] = [
                    'name' => $data['name'],
                    'email' => $data['email'],

                    /*
                     * Schema allows NULL.
                     */
                    'email_verified_at' => null,

                    'phone' => $data['phone'],

                    /*
                     * Already hashed.
                     */
                    'password' => $passwordHash,

                    'image' => null,

                    'role' => $data['role'],

                    'account_status' =>
                        $data['account_status'],

                    'status_reason' =>
                        $data['status_reason'],

                    'status_changed_at' =>
                        $data['account_status'] !== 'active'
                            ? now()
                            : null,

                    'status_changed_by' =>
                        $this->importedBy,

                    'qalam_id' =>
                        $data['qalam_id'],

                    'created_at' => now(),
                    'updated_at' => now(),

                    /*
                     * Schema allows NULL.
                     */
                    'remember_token' => null,
                ];

                $this->importedCount++;
            }

            /*
            |--------------------------------------------------------------------------
            | Track processed values
            |--------------------------------------------------------------------------
            */

            $this->processedEmails[$emailKey] = true;

            if (
                $data['role'] === 'beneficiary'
                && ! empty($data['qalam_id'])
            ) {
                $this->processedQalamIds[
                    (string) $data['qalam_id']
                ] = true;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Bulk insert new users
        |--------------------------------------------------------------------------
        |
        | Instead of 500 individual insert queries, insert in groups.
        |
        */

        if (! empty($newUsers)) {

            foreach (array_chunk($newUsers, 200) as $chunk) {
                DB::table('users')->insert($chunk);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Prepare row
    |--------------------------------------------------------------------------
    */

    private function prepareRow(Collection $row): array
    {
        $role = $this->nullableString(
            $row->get('role')
        );

        $accountStatus = $this->nullableString(
            $row->get('account_status')
        );

        return [
            'name' =>
                $this->nullableString(
                    $row->get('name')
                ),

            'email' =>
                $this->normalizeEmail(
                    $row->get('email')
                ),

            'phone' =>
                $this->normalizePhone(
                    $row->get('phone')
                ),

            'password' =>
                $this->nullableString(
                    $row->get('password')
                ),

            'role' =>
                $role
                    ? strtolower($role)
                    : 'beneficiary',

            'account_status' =>
                $accountStatus
                    ? strtolower($accountStatus)
                    : 'active',

            'status_reason' =>
                $this->nullableString(
                    $row->get('status_reason')
                ),

            'qalam_id' =>
                $this->nullableString(
                    $row->get('qalam_id')
                ),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validation rules
    |--------------------------------------------------------------------------
    */

    private function rules(array $data): array
    {
        $qalamRules = [
            'nullable',
            'string',
            'max:255',
        ];

        if (
            ($data['role'] ?? null)
            === 'beneficiary'
        ) {
            $qalamRules[] = 'required';
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email:rfc',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:255',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'donor',
                    'beneficiary',
                ]),
            ],

            'account_status' => [
                'required',
                Rule::in([
                    'active',
                    'suspended',
                    'blocked',
                ]),
            ],

            'status_reason' => [
                'nullable',
                'string',
            ],

            'qalam_id' =>
                $qalamRules,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validation messages
    |--------------------------------------------------------------------------
    */

    private function messages(): array
    {
        return [
            'name.required' =>
                'The user name is required.',

            'email.required' =>
                'The email address is required.',

            'email.email' =>
                'The email address is invalid.',

            'password.min' =>
                'Password must contain at least 8 characters.',

            'role.in' =>
                'Role must be admin, donor, or beneficiary.',

            'account_status.in' =>
                'Account status must be active, suspended, or blocked.',

            'qalam_id.required' =>
                'Qalam ID is required for beneficiaries.',

            'phone.regex' =>
                'The phone number contains invalid characters.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === ''
            ? null
            : $value;
    }

    private function normalizeEmail(mixed $value): ?string
    {
        $email = $this->nullableString($value);

        return $email
            ? strtolower($email)
            : null;
    }

    private function normalizePhone(mixed $value): ?string
    {
        $phone = $this->nullableString($value);

        if ($phone === null) {
            return null;
        }

        /*
         * Excel sometimes converts numbers to:
         *
         * 923001234567.0
         */
        if (preg_match('/^\d+\.0$/', $phone)) {
            $phone = strstr(
                $phone,
                '.',
                true
            );
        }

        return $phone;
    }

    private function isCompletelyEmpty(array $data): bool
    {
        return empty($data['name'])
            && empty($data['email'])
            && empty($data['phone'])
            && empty($data['password'])
            && empty($data['qalam_id'])
            && empty($data['status_reason']);
    }

    /*
    |--------------------------------------------------------------------------
    | Failure handling
    |--------------------------------------------------------------------------
    */

    private function addFailure(
        int $rowNumber,
        array $data,
        array $errors
    ): void {
        $this->failures[] = [
            'row' =>
                $rowNumber,

            'name' =>
                $data['name'] ?? null,

            'email' =>
                $data['email'] ?? null,

            'errors' =>
                $errors,
        ];

        $this->skippedCount++;
    }

    /*
    |--------------------------------------------------------------------------
    | Results
    |--------------------------------------------------------------------------
    */

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getUpdatedCount(): int
    {
        return $this->updatedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }

    public function getDuplicates(): array
    {
        return $this->duplicates;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    public function getResults(): array
    {
        return [
            'imported' => $this->importedCount,
            'updated' => $this->updatedCount,
            'skipped' => $this->skippedCount,
            'duplicates' => $this->duplicates,
            'failures' => $this->failures,
        ];
    }
}