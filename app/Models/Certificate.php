<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'documentation',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
