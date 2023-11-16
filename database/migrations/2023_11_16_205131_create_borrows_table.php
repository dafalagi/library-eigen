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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('book_id')->constrained();
            $table->foreignId('member_id')->constrained();
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
