<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create book",
     *     description="Create a book.",
     *     operationId="store",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *              type="object",
     *               required={"title","isbn"},
     *                  @OA\Property(property="title", type="string", example="Laravel Fundamentals"),
     *                  @OA\Property(property="author", type="string", example="Yuvaraj"),
     *                  @OA\Property(property="publication_year", type="integer", example=2023),
     *                  @OA\Property(property="isbn", type="string", example="978-0-321-75104-1"),
     *              )
     *          )
     *      )
     * )
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return response(BookResource::make($book));
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update book by id",
     *     description="Update book by id",
     *     operationId="update",
     *     deprecated=false,
     * @OA\Parameter(
     *      name="id",
     *      description="ID of Book",
     *      in="path",
     *      required=true,
     *      example=1,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *              type="object",
     *               required={"title","isbn"},
     *                  @OA\Property(property="title", type="string", example="Laravel Fundamentals"),
     *                  @OA\Property(property="author", type="string", example="Yuvaraj"),
     *                  @OA\Property(property="publication_year", type="integer", example=2023),
     *                  @OA\Property(property="isbn", type="string", example="978-0-321-75104-1"),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response(BookResource::make($book));
    }

    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Get all books",
     *     description="Get all books",
     *     operationId="index",
     *     deprecated=false,
     * @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      example=1,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="per_page",
     *      in="query",
     *      required=false,
     *      example=10,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function index(Request $request)
    {
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

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Get book by id",
     *     description="Get book by id",
     *     operationId="getBookById",
     *     deprecated=false,
     * @OA\Parameter(
     *      name="id",
     *      description="ID of Book",
     *      in="path",
     *      required=true,
     *      example=1,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function getBookById(Request $request, Book $book)
    {
        return response(BookResource::make($book));
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete book by id",
     *     description="Delete book by id",
     *     operationId="destroy",
     *     deprecated=false,
     * @OA\Parameter(
     *      name="id",
     *      description="ID of Book",
     *      in="path",
     *      required=true,
     *      example=1,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="failure operation"
     *     )
     * )
     */
    public function destroy(Request $request, Book $book)
    {
        $book->delete();
        return response(BookResource::make($book));
    }
}
