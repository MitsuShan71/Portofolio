<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'HTML')
            ->update(['percentage' => 63, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('skills')
            ->where('category', 'hard')
            ->where('name', 'HTML')
            ->update(['percentage' => 53, 'updated_at' => now()]);
    }
};
