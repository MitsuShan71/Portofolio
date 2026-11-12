<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $skills = [
            ['name' => 'Figma', 'percentage' => 90, 'icon' => 'Figma.png', 'sort_order' => 1],
            ['name' => 'HTML', 'percentage' => 65, 'icon' => 'HTML.png', 'sort_order' => 2],
            ['name' => 'CSS', 'percentage' => 60, 'icon' => 'CSS.png', 'sort_order' => 3],
            ['name' => 'JavaScript', 'percentage' => 50, 'icon' => 'JS.png', 'sort_order' => 4],
            ['name' => 'MySQL', 'percentage' => 75, 'icon' => 'MySQL.png', 'sort_order' => 5],
        ];

        foreach ($skills as $skill) {
            $exists = DB::table('skills')
                ->where('name', $skill['name'])
                ->where('category', 'hard')
                ->exists();

            if (! $exists) {
                DB::table('skills')->insert($skill + [
                    'category' => 'hard',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        foreach ([
            ['name' => 'Figma', 'percentage' => 90],
            ['name' => 'HTML', 'percentage' => 65],
            ['name' => 'CSS', 'percentage' => 60],
            ['name' => 'JavaScript', 'percentage' => 50],
            ['name' => 'MySQL', 'percentage' => 75],
        ] as $skill) {
            DB::table('skills')
                ->where('name', $skill['name'])
                ->where('category', 'hard')
                ->where('percentage', $skill['percentage'])
                ->delete();
        }
    }
};
