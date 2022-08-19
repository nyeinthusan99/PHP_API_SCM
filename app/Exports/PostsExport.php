<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsExport implements FromCollection,WithHeadings
{
    //private $user;
    public function  __construct($posts)
    {
       $this->posts = $posts;
    }
    public function collection()
    {
        return $this->posts;
        //return $this->posts;
    }

    // public function map($posts): array
    // {
    //     return[
    //         $posts->title,
    //         $posts->description
    //     ];
    // }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
        ];
    }
}



