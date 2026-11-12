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
        'problem_solved',
        'objective',
        'technologies',
        'role',
        'features',
        'demo_link',
        'github_link',
        'process_documentation',
        'user_feedback',
        'details',
    ];
}
