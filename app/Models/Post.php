<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    // السماح بحفظ حقول الصورة والكاتب والمستخدم
    protected $fillable = [
        'user_id',
        'author_name',
        'title',
        'slug',
        'content',
        'tags',
        'image_url',
        'views_count',
        'comments',
    ];

    protected $casts = [
        'tags' => 'array',
        'comments' => 'array',
    ];
}