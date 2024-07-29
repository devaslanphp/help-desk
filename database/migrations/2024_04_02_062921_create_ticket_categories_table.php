<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('ticket_categories');
            $table->string('level'); // New column to distinguish between category, subcategory, and issue
            $table->string('text_color');
            $table->string('bg_color');
            $table->string('type')->nullable();
            $table->foreign('type')->references('slug')->on('ticket_types')->onDelete('set null');
            $table->string('slug',500);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_categories');
    }
};
