<x-mail::message>
# ✅ Booking Konsultasi DISETUJUI!

Halo **{{ $booking->nama_mahasiswa }}**,

Kabar baik! Booking konsultasi Anda telah **DISETUJUI** oleh {{ $dosen->name }}.

## 📋 Detail Konsultasi

<x-mail::panel>
**Dosen:** {{ $dosen->name }}  
**Email Dosen:** {{ $dosen->email }}  
@if($dosen->no_telp)
**Telepon Dosen:** {{ $dosen->no_telp }}  
@endif
**Tanggal:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->translatedFormat('l, d F Y') }}  
**Waktu:** {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }} WITA  
@if($booking->ruangan)
**Ruangan:** {{ $booking->ruangan }}  
@endif
**Keperluan:** {{ $booking->keperluan }}
</x-mail::panel>

@if($booking->catatan_dosen)
## 📝 Catatan dari Dosen

<x-mail::panel>
{{ $booking->catatan_dosen }}
</x-mail::panel>
@endif

@if(!$booking->ruangan && $dosen->ruangan)
## 📍 Lokasi Konsultasi

**{{ $dosen->ruangan }}**  
Lab WICIDA - STMIK WICIDA
@endif

## 📌 Catatan Penting

<x-mail::table>
| Persiapan | Keterangan |
|:----------|:-----------|
| ⏰ Datang Tepat Waktu | Harap datang 5 menit sebelum jadwal |
| 📄 Siapkan Dokumen | Bawa materi/dokumen yang akan dikonsultasikan |
| 📞 Konfirmasi | Jika berhalangan, hubungi dosen minimal H-1 |
</x-mail::table>

<x-mail::button :url="'mailto:' . $dosen->email" color="success">
Hubungi Dosen via Email
</x-mail::button>

---

**Ada pertanyaan?** Balas email ini untuk menghubungi {{ $dosen->name }}.

Sampai jumpa di konsultasi! 🎓

Terima kasih,<br>
**{{ config('app.name') }}**<br>
Lab WICIDA - STMIK Wicida  
</x-mail::message>
