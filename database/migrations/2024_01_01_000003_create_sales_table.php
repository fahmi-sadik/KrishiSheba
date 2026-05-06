<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('বিক্রয়', function (Blueprint $table) { // Sales table in Bengali
            $table->id();
            $table->unsignedBigInteger('পণ্য_আইডি');
            $table->unsignedBigInteger('ক্রেতা_আইডি');
            $table->unsignedBigInteger('বিক্রেতা_আইডি');
            $table->integer('পরিমাণ');
            $table->decimal('মোট_মূল্য', 10, 2);
            $table->enum('অবস্থা', ['অর্ডার_রাখা', 'নিশ্চিত', 'ডেলিভার_করা', 'বাতিল'])->default('অর্ডার_রাখা');
            $table->timestamp('বিক্রয়_তারিখ')->useCurrent();
            $table->text('ডেলিভারি_ঠিকানা')->nullable();
            $table->timestamps();
            
            $table->foreign('পণ্য_আইডি')->references('id')->on('পণ্য')->onDelete('cascade');
            $table->foreign('ক্রেতা_আইডি')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('বিক্রেতা_আইডি')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('বিক্রয়');
    }
};
