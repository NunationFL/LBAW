<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = false;

    public $comments;
    public $movie;
    public $likes;
    public $user;

    protected $fillable = [
        'id',
        'title',
        'text',
        'date',
        'movie',
        'group',
        'author'
    ];
}
