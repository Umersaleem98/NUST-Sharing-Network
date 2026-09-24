<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersImportTemplateExport implements
    FromArray,
    WithHeadings,
    ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'name',
            'email',
            'qalam_id',
            'role',
            'password',
            'profile_status',
        ];
    }


    public function array(): array
    {
        return [

            [
                'Admin User',
                'adminuser@gmail.com',
                '',
                'admin',
                '12345678',
                'active',
            ],

            [
                'Donor User',
                'donoruser@gmail.com',
                '',
                'donor',
                '12345678',
                'suspended',
            ],

            [
                'Beneficiary User',
                'beneficiaryuser@gmail.com',
                '100001',
                'beneficiary',
                '12345678',
                'active',
            ],

        ];
    }
}