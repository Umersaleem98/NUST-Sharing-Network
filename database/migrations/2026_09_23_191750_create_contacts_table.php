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


            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            $table->string('name', 150);

            $table->string('email');

            $table->string('phone', 30)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | User Type
            |--------------------------------------------------------------------------
            */

            $table->enum('user_type', [
                'donor',
                'beneficiary',
                'visitor',
                'other',
            ])
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Inquiry Information
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Message
            |--------------------------------------------------------------------------
            */

            $table->text('message');


            /*
            |--------------------------------------------------------------------------
            | Privacy Consent
            |--------------------------------------------------------------------------
            */

            $table->boolean('privacy')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | Admin Management
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'new',
                'read',
                'resolved',
            ])
                ->default('new');

            $table->timestamp('read_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('email');

            $table->index('user_type');

            $table->index('inquiry_type');

            $table->index('status');

            $table->index('created_at');
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