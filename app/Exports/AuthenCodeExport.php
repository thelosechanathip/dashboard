<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use DB;

class AuthenCodeExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'HN',
            'CID',
            'คำนำหน้า',
            'ชื่อ - สกุล',
            'สิทธิ์การรักษา',
            'สาเหตุ'
        ];
    }
}
