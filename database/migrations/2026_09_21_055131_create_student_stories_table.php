<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            | Story Type
            |--------------------------------------------------------------------------
            |
            | text       = Only text story
            | image      = Only image story
            | image_text = Image + text story
            |
            */
            $table->enum('story_type', [
                'text',
                'image',
                'image_text',
            ])->default('image_text');

            /*
            |--------------------------------------------------------------------------
            | Story Content
            |--------------------------------------------------------------------------
            */
            $table->string('support_type')
                ->nullable();

            $table->longText('story')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Story Image
            |--------------------------------------------------------------------------
            */
            $table->string('image')
                ->nullable();

            $table->string('image_alt')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Story Settings
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Display Order
            |--------------------------------------------------------------------------
            */
            $table->unsignedInteger('display_order')
                ->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('story_type');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_stories');
    }
};