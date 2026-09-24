<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SelectedUsersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected Collection $users;


    public function __construct(Collection $users)
    {
        $this->users =
            $users;
    }


    public function collection(): Collection
    {
        return $this->users;
    }


    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Qalam ID',
            'Role',
            'Profile Status',
            'Email Verification',
            'Verified At',
            'Created At',
        ];
    }


    public function map($user): array
    {
        return [

            $user->id,

            $user->name,

            $user->email,

            $user->qalam_id ?? '',

            ucfirst(
                $user->role
            ),

            ucfirst(
                $user->profile_status
            ),

            $user->email_verified_at
                ? 'Verified'
                : 'Pending',

            $user->email_verified_at
                ? $user->email_verified_at->format(
                    'd-m-Y h:i A'
                )
                : '',

            $user->created_at
                ? $user->created_at->format(
                    'd-m-Y h:i A'
                )
                : '',
        ];
    }
}