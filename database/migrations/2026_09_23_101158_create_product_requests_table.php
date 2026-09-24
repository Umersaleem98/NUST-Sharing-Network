<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_requests', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Beneficiary
            |--------------------------------------------------------------------------
            */

            $table->foreignId('beneficiary_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Donor
            |--------------------------------------------------------------------------
            |
            | Nullable because an Admin may also create a product.
            |
            */

            $table->foreignId('donor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Beneficiary Message
            |--------------------------------------------------------------------------
            */

            $table->text('beneficiary_message')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Admin Review
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'admin_status',
                [
                    'pending',
                    'approved',
                    'rejected',
                ]
            )->default('pending');


            $table->text('admin_message')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Donor Review
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'donor_status',
                [
                    'pending',
                    'accepted',
                    'rejected',
                ]
            )->default('pending');


            $table->text('donor_message')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Requests
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'product_id',
                'beneficiary_id',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Useful Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('admin_status');

            $table->index('donor_status');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'product_requests'
        );
    }
};