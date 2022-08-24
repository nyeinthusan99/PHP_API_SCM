<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostsImport implements  ToCollection,WithValidation,WithHeadingRow
{

    public function  __construct($userid)
    {
        $this->user_id = $userid;
    }

   public function collection(Collection $rows)
    {
         foreach ($rows as $row) {
               Post::create([
                'title' => $row['title'],
                'description' => $row['description'],
                'user_id' => $this->user_id,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.title' => ['required','max:50',Rule::unique("posts","title")],
            '*.description' => 'required',
        ];
    }

}


