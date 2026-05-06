<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('নাম'); // Name in Bengali
            $table->string('ইমেইল')->unique();
            $table->string('ফোন')->nullable();
            $table->string('ঠিকানা')->nullable();
            $table->enum('ভূমিকা', ['প্রশাসক', 'কৃষক', 'ক্রেতা', 'বিশেষজ্ঞ']); // Roles: Admin, Farmer, Buyer, Expert
            $table->text('পাসওয়ার্ড');
            $table->boolean('অনুমোদিত')->default(false);
            $table->string('প্রোফাইল_ছবি')->nullable();
            $table->text('বায়ো')->nullable();
            $table->string('ব্যবসার_নাম')->nullable();
            $table->timestamp('ইমেইল_যাচাই_করা_এ')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('ইমেইল')->primary();
            $table->string('টোকেন');
            $table->timestamp('তৈরি');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
