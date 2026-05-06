<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('পণ্য', function (Blueprint $table) { // Products table in Bengali
            $table->id();
            $table->string('নাম');
            $table->text('বর্ণনা')->nullable();
            $table->decimal('মূল্য', 10, 2);
            $table->integer('পরিমাণ')->default(0);
            $table->string('এককরণ'); // Unit: kg, piece, etc.
            $table->unsignedBigInteger('কৃষক_আইডি');
            $table->enum('অবস্থা', ['অপেক্ষমান', 'অনুমোদিত', 'নিরস্ত করা'])->default('অপেক্ষমান');
            $table->string('ছবি')->nullable();
            $table->enum('বিভাগ', ['শাকসবজি', 'ফল', 'শস্য', 'দুগ্ধ', 'মাছ', 'অন্যান্য']); // Category
            $table->unsignedBigInteger('প্রশাসক_আইডি')->nullable();
            $table->text('প্রত্যাখ্যানের_কারণ')->nullable();
            $table->timestamps();
            
            $table->foreign('কৃষক_আইডি')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('প্রশাসক_আইডি')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('পণ্য');
    }
};
