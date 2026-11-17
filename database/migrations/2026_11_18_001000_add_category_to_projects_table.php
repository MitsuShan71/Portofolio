<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('category', 100)->nullable()->after('title');
        });

        DB::table('projects')
            ->where('title', 'UI/UX Infografis')
            ->whereNull('category')
            ->update(['category' => 'Infografis']);

        DB::table('projects')
            ->where('title', 'Portofolio')
            ->whereNull('category')
            ->update(['category' => 'Website']);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
