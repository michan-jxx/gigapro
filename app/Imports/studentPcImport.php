<?php

namespace App\Imports;

use App\Models\StudentPc;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class studentPcImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        return new StudentPc([
            //dd($row)
            'school_id' => $row['学校ID'],
            'grade' => $row['学年'],
            'class' => $row['クラス'],
            'name' => $row['名前']
        ]);
    }

    public function rules():array
    {
        return[
            '学校ID' => 'required',
            '学年' => 'required',
            'クラス' => 'required',
            '名前' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return[
            '学校ID.required' => '学校IDがありません',
            '学年.required' => '学年がありません',
            'クラス.required' => 'クラスがありません',
            '名前.required' => '名前がありません',
        ];
    }
}
