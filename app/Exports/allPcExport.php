<?php

namespace App\Exports;

use App\Models\StudentPc;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class allPcExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('studentPc')
        ->select('id','school_id','grade','class','name')
        ->orderBy('school_id')
        ->get();
    }
    public function headings():array
    {
        return [
            '端末番号',
            '学校ID',
            '学年',
            'クラス',
            '名前',
        ];
    }
}
