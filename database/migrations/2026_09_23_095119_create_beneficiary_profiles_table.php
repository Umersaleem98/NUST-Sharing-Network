<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiary_profiles', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Personal Information
            |--------------------------------------------------------------------------
            */

            $table->string('phone', 30)
                ->nullable();

            $table->string('gender', 20)
                ->nullable();

            $table->string('profile_image')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Academic Information
            |--------------------------------------------------------------------------
            */

            $table->string('institution')
                ->nullable();

            $table->string('degree', 20)
                ->nullable();

            $table->unsignedSmallInteger('enrollment_year')
                ->nullable();

            $table->unsignedSmallInteger('graduation_year')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Family / Financial Information
            |--------------------------------------------------------------------------
            */

            $table->string('father_status', 50)
                ->nullable();

            $table->string('guardian_profession')
                ->nullable();

            $table->decimal(
                'monthly_income',
                12,
                2
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | Address
            |--------------------------------------------------------------------------
            */

            $table->string('province')
                ->nullable();

            $table->string('domicile')
                ->nullable();

            $table->text('home_address')
                ->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'beneficiary_profiles'
        );
    }
};