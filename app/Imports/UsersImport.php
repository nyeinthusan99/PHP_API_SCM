<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class UsersImport implements ToCollection,WithHeadingRow,WithValidation
{

    public function collection(Collection $rows)
    {
         foreach ($rows as $row) {
               User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
                'image' => '',
                'type' => $row['type'],
                'phone' =>$row['phone'],
                'address' => $row['address'],
                'dob' =>$row['dob'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required',
            '*.email' => 'required|email|unique:users',
            '*.password' => 'required|min:8',
            '*.phone' => 'required|numeric|regex:/(09)[0-9]{9}/'
        ];
    }
}
