<?php

namespace App\Exports;

use App\Models\StudentPc;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class studentPcExport implements WithHeadings
{
    public function headings(): array
    {

        return [
            '学校ID',
            '学年',
            'クラス',
            '名前',
        ];
    }


}
