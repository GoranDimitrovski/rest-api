<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;


    /**
     * Table name
     * @var string
     */
    protected $table = 'article';

    /**
     * Fillable model properties
     * @var array
     */
    protected $fillable = ['title', 'description', 'author_id'];

    /**
     * Soft delete field
     * @var array
     */
    protected $dates = ['deleted_at'];
}
