<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'ruangan')) {
                $table->string('ruangan')->nullable()->after('jam_selesai');
            }

            if (!Schema::hasColumn('bookings', 'catatan_dosen')) {
                $table->text('catatan_dosen')->nullable()->after('keperluan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'ruangan')) {
                $table->dropColumn('ruangan');
            }

            if (Schema::hasColumn('bookings', 'catatan_dosen')) {
                $table->dropColumn('catatan_dosen');
            }
        });
    }
};
