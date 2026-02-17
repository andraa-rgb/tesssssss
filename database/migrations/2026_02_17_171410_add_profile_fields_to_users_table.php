<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('expertise')->nullable();
            $table->text('bio')->nullable();
            $table->string('scholar_url')->nullable();
            $table->string('sinta_url')->nullable();
            $table->string('website_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'expertise',
                'bio',
                'scholar_url',
                'sinta_url',
                'website_url',
            ]);
        });
    }
};
