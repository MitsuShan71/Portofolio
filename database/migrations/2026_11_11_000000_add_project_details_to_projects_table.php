<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('problem_solved')->nullable();
            $table->text('objective')->nullable();
            $table->text('technologies')->nullable();
            $table->text('role')->nullable();
            $table->text('features')->nullable();
            $table->string('demo_link')->nullable();
            $table->string('github_link')->nullable();
            $table->longText('process_documentation')->nullable();
            $table->longText('user_feedback')->nullable();
            $table->longText('details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
