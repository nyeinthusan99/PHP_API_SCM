<?php

namespace App\Http\Controllers\Api;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserImportRequest;

class UsersController extends Controller
{

    //import
    public function import(UserImportRequest $request)
    {
        $request->validated();

        Excel::import(new UsersImport, $request->file('file'));
        return response()->json([
        'result' => 1,
        'message' => 'Import successfully'
       ],200);
    }

    //export
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}



