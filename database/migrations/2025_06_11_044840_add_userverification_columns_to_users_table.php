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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_verified')->default(false);
            $table->boolean('number_verified')->default(false);
            $table->boolean('user_verified')->default(false);
            $table->string('email_otp')->nullable();
            $table->string('number_otp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_verified',
                'number_verified',
                'user_verified',
                'email_otp',
                'number_otp',
            ]);
        });
    }
};
