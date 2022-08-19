<?php

namespace App\Exports;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection,WithHeadings,WithMapping
{
    //private $user;
    public function  __construct($posts)
    {
       $this->posts = $posts;
    }
    public function collection()
    {
        return $this->posts;
    }

    public function map($posts): array
    {
        return[
            $posts->title,
            $posts->description
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
        ];
    }
}



