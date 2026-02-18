<x-mail::message>
# ❌ Booking Konsultasi Ditolak

Halo **{{ $booking->nama_mahasiswa }}**,

Mohon maaf, booking konsultasi Anda dengan {{ $dosen->name }} tidak dapat disetujui.

## 📋 Detail Booking

<x-mail::panel>
**Dosen:** {{ $dosen->name }}  
**Tanggal:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->translatedFormat('l, d F Y') }}  
**Waktu:** {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }} WITA
</x-mail::panel>

## 📝 Alasan Penolakan

<x-mail::panel>
{{ $booking->alasan_reject ?? 'Tidak ada catatan.' }}
</x-mail::panel>

## 🔄 Langkah Selanjutnya

Anda dapat:

1. **Ajukan booking ulang** dengan jadwal berbeda
2. **Hubungi dosen** untuk diskusi jadwal alternatif
3. **Pilih dosen lain** yang tersedia

<x-mail::button :url="$url" color="primary">
Booking Ulang
</x-mail::button>

<x-mail::button :url="'mailto:' . $dosen->email" color="secondary">
Hubungi Dosen
</x-mail::button>

---

**Butuh penjelasan lebih lanjut?** Balas email ini untuk menghubungi {{ $dosen->name }}.

Terima kasih atas pengertiannya,<br>
**{{ config('app.name') }}**<br>
Lab WICIDA - Universitas Mulawarman
</x-mail::message>
