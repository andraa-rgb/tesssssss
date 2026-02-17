<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Status;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@lab-wicida.ac.id',
            'password' => Hash::make('admin123'),
            'nip' => null,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $admin->id,
            'status' => 'Ada',
            'updated_at_iot' => now(),
        ]);

        // 2. Create Dosen 1 - Kepala Lab
        $budi = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@lab-wicida.ac.id',
            'password' => Hash::make('password'),
            'nip' => '198501151990031001',
            'role' => 'kepala_lab',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $budi->id,
            'status' => 'Ada',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Budi
        $jadwalBudi = [
            ['hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab A101', 'keterangan' => 'Praktikum Algoritma'],
            ['hari' => 'Senin', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 201', 'keterangan' => 'Konsultasi TA/Skripsi'],
            ['hari' => 'Selasa', 'jam_mulai' => '09:00', 'jam_selesai' => '11:00', 'kegiatan' => 'Rapat', 'ruangan' => 'Ruang Rapat Lt.3', 'keterangan' => 'Rapat Koordinasi Lab'],
            ['hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab A102', 'keterangan' => 'Struktur Data'],
            ['hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '16:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 201', 'keterangan' => 'Office Hours'],
            ['hari' => 'Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab A101', 'keterangan' => 'Basis Data'],
        ];

        foreach ($jadwalBudi as $j) {
            Jadwal::create(array_merge($j, ['user_id' => $budi->id]));
        }

        // 3. Create Dosen 2 - Staf
        $siti = User::create([
            'name' => 'Ir. Siti Nurhayati',
            'email' => 'siti@lab-wicida.ac.id',
            'password' => Hash::make('password'),
            'nip' => '198703202015032004',
            'role' => 'staf',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $siti->id,
            'status' => 'Mengajar',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Siti
        $jadwalSiti = [
            ['hari' => 'Senin', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab B201', 'keterangan' => 'Pemrograman Web'],
            ['hari' => 'Selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab B202', 'keterangan' => 'Mobile Programming'],
            ['hari' => 'Selasa', 'jam_mulai' => '14:00', 'jam_selesai' => '16:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 203', 'keterangan' => 'Bimbingan PKL'],
            ['hari' => 'Rabu', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab B201', 'keterangan' => 'Framework Laravel'],
            ['hari' => 'Kamis', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 203', 'keterangan' => 'Konsultasi Proyek'],
        ];

        foreach ($jadwalSiti as $j) {
            Jadwal::create(array_merge($j, ['user_id' => $siti->id]));
        }

        // 4. Create Dosen 3 - Staf
        $andriana = User::create([
            'name' => 'Andriana Kusuma, S.Kom., M.T.',
            'email' => 'andriana@lab-wicida.ac.id',
            'password' => Hash::make('password'),
            'nip' => '199005152018032002',
            'role' => 'staf',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $andriana->id,
            'status' => 'Konsultasi',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Andriana
        $jadwalAndriana = [
            ['hari' => 'Senin', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab C301', 'keterangan' => 'Machine Learning'],
            ['hari' => 'Selasa', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 204', 'keterangan' => 'Konsultasi Riset'],
            ['hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Mengajar', 'ruangan' => 'Lab C301', 'keterangan' => 'Data Mining'],
            ['hari' => 'Rabu', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 204', 'keterangan' => 'Bimbingan Tesis'],
            ['hari' => 'Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kegiatan' => 'Rapat', 'ruangan' => 'Ruang Rapat Lt.2', 'keterangan' => 'Rapat Program Studi'],
            ['hari' => 'Jumat', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kegiatan' => 'Konsultasi', 'ruangan' => 'Ruang Dosen 204', 'keterangan' => 'Office Hours'],
        ];

        foreach ($jadwalAndriana as $j) {
            Jadwal::create(array_merge($j, ['user_id' => $andriana->id]));
        }

        // 5. Create dummy bookings
        $bookings = [
            [
                'user_id' => $budi->id,
                'nama_mahasiswa' => 'Ahmad Fauzi',
                'email_mahasiswa' => 'ahmad.fauzi@student.ac.id',
                'nim_mahasiswa' => '20210101001',
                'tanggal_booking' => now()->addDays(2)->format('Y-m-d'),
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:00',
                'keperluan' => 'Konsultasi proposal skripsi tentang sistem informasi',
                'status' => 'pending',
            ],
            [
                'user_id' => $siti->id,
                'nama_mahasiswa' => 'Siti Aisyah',
                'email_mahasiswa' => 'siti.aisyah@student.ac.id',
                'nim_mahasiswa' => '20210101002',
                'tanggal_booking' => now()->addDays(3)->format('Y-m-d'),
                'jam_mulai' => '14:00',
                'jam_selesai' => '15:00',
                'keperluan' => 'Bimbingan PKL - masalah implementasi Laravel',
                'status' => 'approved',
            ],
            [
                'user_id' => $andriana->id,
                'nama_mahasiswa' => 'Budi Hartono',
                'email_mahasiswa' => 'budi.hartono@student.ac.id',
                'nim_mahasiswa' => '20210101003',
                'tanggal_booking' => now()->addDays(1)->format('Y-m-d'),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'keperluan' => 'Diskusi dataset untuk tugas akhir tentang prediksi',
                'status' => 'pending',
            ],
            [
                'user_id' => $budi->id,
                'nama_mahasiswa' => 'Dewi Lestari',
                'email_mahasiswa' => 'dewi.lestari@student.ac.id',
                'nim_mahasiswa' => '20210101004',
                'tanggal_booking' => now()->subDays(2)->format('Y-m-d'),
                'jam_mulai' => '13:00',
                'jam_selesai' => '14:00',
                'keperluan' => 'Konsultasi progress BAB 3',
                'status' => 'rejected',
                'alasan_reject' => 'Jadwal bentrok dengan rapat penting. Silakan reschedule.',
            ],
        ];

        foreach ($bookings as $b) {
            Booking::create($b);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👨‍💼 Admin:');
        $this->command->info('   Email: admin@lab-wicida.ac.id');
        $this->command->info('   Password: admin123');
        $this->command->info('');
        $this->command->info('👨‍🏫 Dosen 1 (Kepala Lab):');
        $this->command->info('   Email: budi@lab-wicida.ac.id');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👨‍🏫 Dosen 2 (Staf):');
        $this->command->info('   Email: siti@lab-wicida.ac.id');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('👨‍🏫 Dosen 3 (Staf):');
        $this->command->info('   Email: andriana@lab-wicida.ac.id');
        $this->command->info('   Password: password');
    }
}
