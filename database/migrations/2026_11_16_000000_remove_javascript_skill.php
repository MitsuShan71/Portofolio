<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('skills')
            ->where('name', 'JavaScript')
            ->where('category', 'hard')
            ->delete();
    }

    public function down(): void
    {
        $exists = DB::table('skills')
            ->where('name', 'JavaScript')
            ->where('category', 'hard')
            ->exists();

        if (! $exists) {
            DB::table('skills')->insert([
                'name' => 'JavaScript',
                'percentage' => 50,
                'icon' => 'JS.png',
                'category' => 'hard',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
