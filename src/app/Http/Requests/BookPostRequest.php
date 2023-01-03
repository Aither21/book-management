<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class BookPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'author' => 'required|string|max:30',
            'company' => 'required|string|max:10',
        ];
    }

    public function toBook(): Book
    {
        $requestBook = $this->validated();
        $book = new Book();
        $book->name = $requestBook['name'];
        $book->author = $requestBook['author'];
        $book->company = $requestBook['company'];
        return $book;
    }
}
