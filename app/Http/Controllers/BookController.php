<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // store the book information
    public function store(StoreBookRequest $request) {
        $book = Book::create($request->validated());

        return response(BookResource::make($book));
    }
}
