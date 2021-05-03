<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
class UserImportController extends Controller
{
    //
    public function show(){

    }

    public function store(Request $request){
        $file = $request->file('file')->store('import');
        // Excel::import(new UsersImport, $file);
        // (new UsersImport)->import($file);
        $import = new UsersImport;
        $import->import($file);
        return true;
    }
}
