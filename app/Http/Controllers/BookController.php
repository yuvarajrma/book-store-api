<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;

class BookController extends Controller
{
    // get all books with pagination
    public function index(Request $request) {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        
        $booksQuery = Book::offset(($page - 1) * $per_page)
            ->limit($per_page);

        $books = $booksQuery->get();
        $count = $booksQuery->count();

        $res = [
            'pagination' => Helper::pagination($page, $count, $per_page),
            'data' => BookResource::collection($books),
        ];

        return response($res);
    }

    // store the book information
    public function store(StoreBookRequest $request) {
        $book = Book::create($request->validated());

        return response(BookResource::make($book));
    }


}
