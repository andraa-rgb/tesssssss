<x-mail::message>
# 📅 Booking Konsultasi Diterima

Halo **{{ $booking->nama_mahasiswa }}**,

Terima kasih telah melakukan booking konsultasi. Permintaan Anda telah diterima dan sedang menunggu persetujuan dari dosen.

## 📋 Detail Booking

<x-mail::panel>
**Dosen:** {{ $dosen->name }}  
**Email Dosen:** {{ $dosen->email }}  
**Tanggal:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->translatedFormat('l, d F Y') }}  
**Waktu:** {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }} WITA  
**Keperluan:** {{ $booking->keperluan }}
</x-mail::panel>

## ⏳ Status Saat Ini

**Menunggu Persetujuan Dosen**

Anda akan menerima email notifikasi ketika dosen telah merespons booking ini.

<x-mail::button :url="$url" color="primary">
Lihat Detail Booking
</x-mail::button>

---

**Pertanyaan?** Balas email ini untuk menghubungi {{ $dosen->name }} langsung.

Terima kasih,<br>
**{{ config('app.name') }}**<br>
Lab WICIDA - STMIK Wicida
</x-mail::message>
