<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\PhoneNumber;
use Carbon\Carbon;

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
        $dt = new Carbon();
        $before = $dt->subYears(16)->format('Y/m/d');
        return [
            '*.name' => 'required',
            '*.email' => ['required','email',Rule::unique("users","email")->whereNull('deleted_at')],
            '*.password' => 'required|min:8',
            '*.phone' => ['required','numeric',new PhoneNumber],
            '*.dob'=>'nullable|date|before:' . $before
        ];
    }

    public function customValidationMessages()
    {
        return [
            'dob.before' => "Age must be greater than 16",
        ];
    }
}
