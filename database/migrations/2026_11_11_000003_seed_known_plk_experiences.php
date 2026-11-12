<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $entries = [
            ['title' => 'PLK — Periode 1', 'organization' => 'Jl. Dahlia No. 38', 'role' => 'UI/UX Designer', 'start_date' => '2025-09-22', 'end_date' => '2025-11-20'],
            ['title' => 'PLK — Periode 2', 'organization' => 'Jl. Dahlia No. 38', 'role' => 'UI/UX Designer', 'start_date' => '2026-07-27', 'end_date' => '2026-09-20'],
        ];

        foreach ($entries as $entry) {
            DB::table('experiences')->updateOrInsert(
                ['category' => 'plk', 'start_date' => $entry['start_date']],
                $entry + ['category' => 'plk', 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('experiences')
            ->where('category', 'plk')
            ->whereIn('start_date', ['2025-09-22', '2026-07-27'])
            ->where('organization', 'Jl. Dahlia No. 38')
            ->delete();
    }
};
