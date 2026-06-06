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
            $table->string('ktp_image')->nullable()->after('avatar');
            $table->string('ktp_status')->default('unverified')->after('ktp_image'); // unverified, pending, verified, rejected
            $table->text('ktp_rejection_reason')->nullable()->after('ktp_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ktp_image', 'ktp_status', 'ktp_rejection_reason']);
        });
    }
};
