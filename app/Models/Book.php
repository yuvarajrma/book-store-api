<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Book.
 *
 * @OA\Schema(
 *     description="Book model",
 *     title="Book model",
 *     required={"title", "isbn"},
 *     @OA\Xml(
 *         name="Book"
 *     )
 * )
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'isbn'
    ];
}
