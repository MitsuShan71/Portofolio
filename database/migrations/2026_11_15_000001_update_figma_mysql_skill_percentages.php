<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'Figma')
            ->update(['percentage' => 80, 'updated_at' => now()]);

        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'MySQL')
            ->update(['percentage' => 67, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'Figma')
            ->update(['percentage' => 90, 'updated_at' => now()]);

        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'MySQL')
            ->update(['percentage' => 75, 'updated_at' => now()]);
    }
};
