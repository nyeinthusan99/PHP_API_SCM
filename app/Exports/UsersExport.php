<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class UsersExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  __construct($user)
    {
       $this->user = $user;
    }

    public function collection()
    {
        // $user = User::select('name','email','type','phone','address','dob')->get();


        // return $user;
            $user =$this->user;

             for($i=0;$i<count($user);$i++){
                if($user[$i]->type == 0){
                    $user[$i]->type = 'Admin';
                }else{
                    $user[$i]->type = 'User';
                }
            }

            for($j=0;$j<count($user);$j++){
             if($user[$j]->dob){
                $user[$j]->dob =  Carbon::parse($user[$j]->dob)->format('Y/m/d');
             };
            }
        
            \Log::info($user);

        return $user;
    }

    public function map($user): array
    {
        return[
            $user->name,
            $user->email,
            $user->type,
            $user->phone,
            $user->address,
            $user->dob,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Type',
            'Phone',
            'address',
            'dob',
        ];
    }
}
