<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioProfile extends Model
{
    protected $table = 'portfolio_profiles';

    protected $fillable = [
        'full_name',
        'class_name',
        'competency',
        'summary',
        'bio',
        'education',
        'career_goal',
        'email',
        'github_url',
        'instagram_url',
        'profile_image',
        'resume_file',
    ];
}
