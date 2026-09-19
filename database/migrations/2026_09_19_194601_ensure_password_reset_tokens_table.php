<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('password_reset_tokens')) {
            Schema::create(
                'password_reset_tokens',
                function (Blueprint $table) {
                    $table->string('email')
                        ->primary();

                    $table->string('token');

                    $table->timestamp('created_at')
                        ->nullable();
                }
            );
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Intentionally left blank
        |--------------------------------------------------------------------------
        |
        | Laravel's default users migration may own this table. This fallback
        | migration therefore does not drop it automatically on rollback.
        |
        */
    }
};
