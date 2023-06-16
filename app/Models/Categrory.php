<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categrory extends Model
{
    use HasFactory;

    protected $table = 'categrories';

    protected $fillable =
    [
        'name',
        'slug',
        'description',
        'status',
        'populer',
        'image',
        'meta_title',
        'meta_descrip',
        'meta_keywords',
    ];
}
