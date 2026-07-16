<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method bool delete()
 */
class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
    ];
}
