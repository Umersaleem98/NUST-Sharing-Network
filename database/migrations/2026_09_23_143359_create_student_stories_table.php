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
        Schema::create('student_stories', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Student Information
            |--------------------------------------------------------------------------
            */

            $table->string('student_name');

            $table->string('program')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Story Classification
            |--------------------------------------------------------------------------
            */

            $table->string('story_type')
                ->nullable();

            $table->string('support_type')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Story Content
            |--------------------------------------------------------------------------
            */

            $table->longText('story');


            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */

            $table->string('image')
                ->nullable();

            $table->string('image_alt')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Display Settings
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->unsignedInteger('display_order')
                ->default(0);


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

            $table->index('is_active');

            $table->index('is_featured');

            $table->index('display_order');

            $table->index('story_type');

            $table->index('support_type');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'student_stories'
        );
    }
};