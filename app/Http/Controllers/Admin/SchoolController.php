<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\School;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
 public function exeSchool()
 {
    $schools = School::all();

        return view('admin.pc_title',[
            'schools' => $schools,
        ]);
 }
}
