<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->string('short_desc')->nullable();
            $table->text('desc')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('slug')->nullable();
            $table->enum('lang', ['en', 'id'])->default('en');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
