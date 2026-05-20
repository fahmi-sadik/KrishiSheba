<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['farmer', 'buyer', 'expert', 'admin'])->default('buyer');
            $table->boolean('is_approved')->default(true);
            $table->text('delivery_address')->nullable();
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('expert_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('certificate_path')->nullable();
            $table->string('paperwork_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('advice_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('expert_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('question');
            $table->longText('answer')->nullable();
            $table->enum('status', ['pending', 'answered'])->default('pending');
            $table->timestamps();
        });

        Schema::create('expert_guides', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('expert_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->longText('body');
            $table->timestamps();
        });

        Schema::create('expert_articles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('expert_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->longText('body');
            $table->timestamps();
        });

        Schema::create('advertisements', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('target_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('payouts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('expert_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('advice_request_id')->constrained('advice_requests')->cascadeOnDelete();
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('expert_articles');
        Schema::dropIfExists('expert_guides');
        Schema::dropIfExists('advice_requests');
        Schema::dropIfExists('expert_documents');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('users');
    }
};
