<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements
    ToCollection,
    WithHeadingRow,
    SkipsEmptyRows
{
    public int $importedCount = 0;

    public int $duplicateCount = 0;

    public int $failedCount = 0;

    public array $duplicateMessages = [];

    public array $failedMessages = [];


    public function collection(Collection $rows)
    {
        /*
        |--------------------------------------------------------------------------
        | Existing Emails
        |--------------------------------------------------------------------------
        */

        $emails = $rows
            ->map(function ($row) {

                return strtolower(
                    trim(
                        (string) ($row['email'] ?? '')
                    )
                );

            })
            ->filter()
            ->unique()
            ->values();


        $existingEmails = User::whereIn(
            'email',
            $emails
        )
            ->pluck('email')
            ->map(function ($email) {

                return strtolower($email);

            })
            ->flip()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Existing Qalam IDs
        |--------------------------------------------------------------------------
        */

        $qalamIds = $rows
            ->map(function ($row) {

                return trim(
                    (string) ($row['qalam_id'] ?? '')
                );

            })
            ->filter()
            ->unique()
            ->values();


        $existingQalamIds = User::whereIn(
            'qalam_id',
            $qalamIds
        )
            ->pluck('qalam_id')
            ->map(function ($qalamId) {

                return (string) $qalamId;

            })
            ->flip()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Track Excel Duplicates
        |--------------------------------------------------------------------------
        */

        $seenEmails = [];

        $seenQalamIds = [];

        $usersToInsert = [];


        foreach ($rows as $index => $row) {

            $rowNumber =
                $index + 2;


            /*
            |--------------------------------------------------------------------------
            | Normalize
            |--------------------------------------------------------------------------
            */

            $name = trim(
                (string) ($row['name'] ?? '')
            );


            $email = strtolower(
                trim(
                    (string) ($row['email'] ?? '')
                )
            );


            $qalamId = trim(
                (string) ($row['qalam_id'] ?? '')
            );


            $role = strtolower(
                trim(
                    (string) ($row['role'] ?? '')
                )
            );


            $password = trim(
                (string) ($row['password'] ?? '')
            );


            $profileStatus = strtolower(
                trim(
                    (string) ($row['profile_status'] ?? '')
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Name
            |--------------------------------------------------------------------------
            */

            if ($name === '') {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Name is required.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */

            if (
                $email === '' ||
                !filter_var(
                    $email,
                    FILTER_VALIDATE_EMAIL
                )
            ) {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Invalid email address.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Role
            |--------------------------------------------------------------------------
            */

            if (
                !in_array(
                    $role,
                    [
                        'admin',
                        'donor',
                        'beneficiary',
                    ],
                    true
                )
            ) {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Invalid role.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Profile Status
            |--------------------------------------------------------------------------
            */

            if (
                !in_array(
                    $profileStatus,
                    [
                        'active',
                        'suspended',
                        'blocked',
                    ],
                    true
                )
            ) {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Profile status must be active, suspended or blocked.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            if ($password === '') {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Password is required.";

                continue;
            }


            if (strlen($password) < 8) {

                $this->failedCount++;

                $this->failedMessages[] =
                    "Row {$rowNumber}: Password must contain at least 8 characters.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Qalam ID
            |--------------------------------------------------------------------------
            */

            if ($role === 'beneficiary') {

                if ($qalamId === '') {

                    $this->failedCount++;

                    $this->failedMessages[] =
                        "Row {$rowNumber}: Qalam ID is required for beneficiary.";

                    continue;
                }


                if (!ctype_digit($qalamId)) {

                    $this->failedCount++;

                    $this->failedMessages[] =
                        "Row {$rowNumber}: Qalam ID must contain numbers only.";

                    continue;
                }

            } else {

                $qalamId = null;
            }


            /*
            |--------------------------------------------------------------------------
            | Existing Email
            |--------------------------------------------------------------------------
            */

            if (isset($existingEmails[$email])) {

                $this->duplicateCount++;

                $this->duplicateMessages[] =
                    "Row {$rowNumber}: Email {$email} already exists.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Excel Email Duplicate
            |--------------------------------------------------------------------------
            */

            if (isset($seenEmails[$email])) {

                $this->duplicateCount++;

                $this->duplicateMessages[] =
                    "Row {$rowNumber}: Duplicate email {$email} found in Excel.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Existing Qalam
            |--------------------------------------------------------------------------
            */

            if (
                $role === 'beneficiary' &&
                isset(
                    $existingQalamIds[$qalamId]
                )
            ) {

                $this->duplicateCount++;

                $this->duplicateMessages[] =
                    "Row {$rowNumber}: Qalam ID {$qalamId} already exists.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Excel Qalam Duplicate
            |--------------------------------------------------------------------------
            */

            if (
                $role === 'beneficiary' &&
                isset(
                    $seenQalamIds[$qalamId]
                )
            ) {

                $this->duplicateCount++;

                $this->duplicateMessages[] =
                    "Row {$rowNumber}: Duplicate Qalam ID {$qalamId} found in Excel.";

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Mark Seen
            |--------------------------------------------------------------------------
            */

            $seenEmails[$email] = true;


            if ($role === 'beneficiary') {

                $seenQalamIds[$qalamId] =
                    true;
            }


            /*
            |--------------------------------------------------------------------------
            | Prepare User
            |--------------------------------------------------------------------------
            */

            $usersToInsert[] = [

                'name' =>
                    $name,

                'email' =>
                    $email,

                'qalam_id' =>
                    $qalamId,

                'password' =>
                    Hash::make(
                        $password
                    ),

                'role' =>
                    $role,

                'profile_status' =>
                    $profileStatus,

                'email_verified_at' =>
                    null,

                'email_verification_token' =>
                    null,

                'email_verification_token_expires_at' =>
                    null,

                'created_at' =>
                    now(),

                'updated_at' =>
                    now(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Insert
        |--------------------------------------------------------------------------
        */

        foreach (
            array_chunk(
                $usersToInsert,
                100
            ) as $chunk
        ) {

            DB::table('users')
                ->insert(
                    $chunk
                );
        }


        $this->importedCount =
            count($usersToInsert);
    }
}