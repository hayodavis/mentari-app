<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Data kosong, hanya untuk contoh baris
        return collect([
            [
                'name'     => 'Guru Contoh',
                'email'    => 'guru@example.com',
                'password' => 'password123',
                'nip'      => '1234567890',
                'phone'    => '081234567890',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'nip',
            'phone',
        ];
    }
}
