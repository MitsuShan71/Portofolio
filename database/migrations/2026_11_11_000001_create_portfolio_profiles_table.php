<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('full_name')->nullable();
            $table->string('class_name')->nullable();
            $table->string('competency')->nullable();
            $table->text('summary')->nullable();
            $table->longText('bio')->nullable();
            $table->longText('education')->nullable();
            $table->text('career_goal')->nullable();
            $table->string('email')->nullable();
            $table->string('github_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_profiles');
    }
};
