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
        Schema::create('contacts', function (Blueprint $table) {
           $table->id();

            $table->string('name', 150);

            $table->string('email');

            $table->string('phone', 30)
                ->nullable();

            $table->enum('user_type', [
                'donor',
                'beneficiary',
                'visitor',
                'other',
            ])->nullable();

            $table->string('subject');

            $table->enum('inquiry_type', [
                'general',
                'donor_support',
                'beneficiary_support',
                'account_support',
                'technical',
                'feedback',
                'other',
            ]);

            $table->text('message');

            $table->boolean('privacy')
                ->default(false);

            $table->enum('status', [
                'new',
                'read',
                'resolved',
            ])->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
