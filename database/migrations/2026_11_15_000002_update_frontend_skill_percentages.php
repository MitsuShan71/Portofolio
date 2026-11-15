<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['HTML' => 53, 'CSS' => 57, 'JavaScript' => 40] as $name => $percentage) {
            DB::table('skills')
                ->where('category', 'hard')
                ->where('name', $name)
                ->update(['percentage' => $percentage, 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        foreach (['HTML' => 65, 'CSS' => 60, 'JavaScript' => 50] as $name => $percentage) {
            DB::table('skills')
                ->where('category', 'hard')
                ->where('name', $name)
                ->update(['percentage' => $percentage, 'updated_at' => now()]);
        }
    }
};
