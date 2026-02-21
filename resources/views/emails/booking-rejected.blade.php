<x-mail::message>
# ❌ Booking Konsultasi Ditolak

Halo **{{ $booking->nama_mahasiswa }}**,

Mohon maaf, booking konsultasi Anda dengan {{ $dosen->name }} **ditolak**.

## 📋 Detail Booking

<x-mail::panel>
**Dosen:** {{ $dosen->name }}  
**Tanggal yang Diminta:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->translatedFormat('l, d F Y') }}  
**Waktu yang Diminta:** {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }} WITA  
**Keperluan:** {{ $booking->keperluan }}
</x-mail::panel>

## ⚠️ Alasan Penolakan

<x-mail::panel>
{{ $booking->alasan_reject }}
</x-mail::panel>

## 💡 Langkah Selanjutnya

Anda dapat:
- Booking kembali dengan jadwal yang berbeda
- Menghubungi dosen untuk koordinasi jadwal alternatif

<x-mail::button :url="route('mahasiswa.dosen.show', $dosen->id)" color="error">
Booking Ulang
</x-mail::button>

---

**Butuh bantuan?** Hubungi {{ $dosen->email }}

Terima kasih,<br>
**{{ config('app.name') }}**<br>
Lab WICIDA - Universitas Mulawarman
</x-mail::message>
