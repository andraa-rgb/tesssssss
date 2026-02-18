@extends('layouts.app')

@section('title', 'Profil Dosen - Lab WICIDA')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- SIDEBAR PROFIL SINGKAT + QR --}}
    <div class="lg:col-span-1 space-y-4">
        {{-- KARTU PROFIL --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body items-center text-center">
                <div class="avatar mb-4">
                    @if(auth()->user()->photo)
                        <div class="w-24 rounded-full ring-4 ring-primary/20 overflow-hidden">
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto profil">
                        </div>
                    @else
                        <div class="bg-primary text-primary-content rounded-full w-24 ring-4 ring-primary/20 flex items-center justify-center">
                            <span class="text-3xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <h2 class="card-title text-lg mb-1">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-base-content/70 mb-2">
                    {{ auth()->user()->nip ?? 'NIP belum diisi' }}
                </p>
                <div class="badge badge-outline capitalize mb-4">
                    {{ str_replace('_', ' ', auth()->user()->role ?? 'dosen') }}
                </div>

                <div class="w-full text-left text-sm space-y-1 mb-4">
                    <p><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                    <p><span class="font-semibold">Bergabung:</span> {{ auth()->user()->created_at?->format('d M Y') }}</p>
                </div>

                <div class="divider my-3"></div>

                <div class="w-full text-left text-xs text-base-content/60 space-y-1">
                    <p>• Profil ini tampil di halaman publik detail dosen.</p>
                    <p>• Lengkapi bio dan link riset agar mahasiswa mudah mengenali Anda.</p>
                </div>
            </div>
        </div>

        {{-- KARTU QR CODE (disamakan dengan landing page) --}}
        <div class="card bg-base-100 shadow-lg border border-base-300" id="qrcode-card">
            <div class="card-body items-center text-center">
                <h3 class="card-title text-base mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    QR Code Profil
                </h3>
                <p class="text-xs text-base-content/70 mb-4">
                    Scan untuk akses cepat ke halaman profil dan booking Anda.
                </p>

                {{-- QR Code SVG --}}
                <div class="bg-white p-6 rounded-xl shadow-lg inline-block mb-4" id="qr-display">
                    {!! $qrCodeSvg !!}
                </div>

                {{-- URL Display + copy --}}
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-xs font-semibold">Link Booking:</span>
                    </label>
                    <div class="join w-full">
                        <input type="text"
                               id="qr-url-input"
                               readonly
                               class="input input-bordered input-sm join-item flex-1 text-xs"
                               value="{{ $qrCodeUrl }}">
                        <button type="button"
                                onclick="copyQrUrl()"
                                class="btn btn-sm btn-primary join-item"
                                title="Copy Link">
                            <svg id="copy-icon-qr" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                    <label class="label">
                        <span id="copy-feedback-qr" class="label-text-alt text-success hidden">
                            ✓ Link berhasil disalin!
                        </span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-2 w-full">
                    {{-- Download PNG via canvas --}}
                    <button type="button"
                            onclick="downloadQrCode({{ auth()->id() }}, '{{ auth()->user()->name }}')"
                            class="btn btn-primary btn-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download PNG
                    </button>

                    <button type="button"
                            onclick="printQrCode()"
                            class="btn btn-outline btn-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak QR Code
                    </button>

                    <button type="button"
                            onclick="shareQrCode()"
                            class="btn btn-ghost btn-sm gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Share Link
                    </button>
                </div>

                <div class="text-[10px] text-base-content/50 mt-2 break-all">
                    {{ $qrCodeUrl }}
                </div>
            </div>
        </div>
    </div>

    {{-- FORM PROFIL & PASSWORD --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- NOTIFIKASI --}}
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success shadow-md">
                <span>Profil berhasil diperbarui.</span>
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="alert alert-success shadow-md">
                <span>Password berhasil diperbarui.</span>
            </div>
        @endif

        {{-- FORM PROFIL --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
                <h2 class="card-title mb-4">Informasi Profil & Portofolio</h2>

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      class="space-y-4"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Upload Foto --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Foto Profil</span>
                        </label>

                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            {{-- Avatar preview --}}
                            <div class="flex flex-col items-center gap-2">
                                <div class="avatar">
                                    <div class="w-24 rounded-full ring-4 ring-primary/20 overflow-hidden">
                                        <img id="avatar-preview-img"
                                             src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://via.placeholder.com/150' }}"
                                             alt="Foto profil">
                                    </div>
                                </div>

                                @if(auth()->user()->photo)
                                    <button type="submit"
                                            name="remove_photo"
                                            value="1"
                                            class="btn btn-xs btn-ghost text-error mt-2"
                                            onclick="return confirm('Hapus foto profil?')">
                                        Hapus Foto
                                    </button>
                                @endif

                                <span class="text-xs text-base-content/60 text-center max-w-[180px]">
                                    Hasil foto yang akan tampil di profil.
                                </span>
                            </div>

                            {{-- Input file + area crop --}}
                            <div class="flex-1 space-y-3">
                                <input type="file" id="photo-input"
                                       class="file-input file-input-bordered file-input-sm w-full max-w-xs @error('photo') file-input-error @enderror"
                                       accept="image/*">

                                <div id="cropper-container" class="hidden mt-2">
                                    <div class="border border-base-300 rounded-lg overflow-hidden max-w-xs">
                                        <img id="cropper-image" src="#" alt="Cropper" class="max-w-full">
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <button type="button" id="cropper-zoom-in" class="btn btn-xs btn-outline">Zoom +</button>
                                        <button type="button" id="cropper-zoom-out" class="btn btn-xs btn-outline">Zoom -</button>
                                        <button type="button" id="cropper-reset" class="btn btn-xs btn-ghost">Reset</button>
                                    </div>
                                </div>

                                <input type="hidden" name="cropped_image" id="cropped-image-input">
                            </div>
                        </div>

                        <label class="label">
                            <span class="label-text-alt text-xs text-base-content/60">
                                Pilih foto, atur posisi/zoom di area crop. Sistem menyimpan hasil crop sebagai foto profil.
                            </span>
                        </label>

                        @error('photo')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Nama Lengkap</span>
                        </label>
                        <input type="text" name="name"
                               class="input input-bordered @error('name') input-error @enderror"
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Email</span>
                        </label>
                        <input type="email" name="email"
                               class="input input-bordered @error('email') input-error @enderror"
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                        <label class="label">
                            <span class="label-text-alt text-xs text-base-content/60">
                                Jika Anda mengubah email, verifikasi ulang mungkin diperlukan.
                            </span>
                        </label>
                    </div>

                    {{-- NIP --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">NIP</span>
                        </label>
                        <input type="text" name="nip"
                               class="input input-bordered @error('nip') input-error @enderror"
                               value="{{ old('nip', auth()->user()->nip) }}"
                               placeholder="Contoh: 19801231 200501 1 001">
                        @error('nip')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Bidang Keahlian --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Bidang Keahlian</span>
                        </label>
                        <input type="text" name="expertise"
                               class="input input-bordered @error('expertise') input-error @enderror"
                               value="{{ old('expertise', auth()->user()->expertise ?? '') }}"
                               placeholder="Contoh: Machine Learning, Sistem Informasi, Jaringan Komputer">
                        @error('expertise')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Deskripsi Singkat / Bio</span>
                        </label>
                        <textarea name="bio" rows="4"
                                  class="textarea textarea-bordered @error('bio') textarea-error @enderror"
                                  placeholder="Tuliskan profil singkat, minat riset, dan pengalaman mengajar...">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                        @error('bio')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Link riset --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Google Scholar URL</span>
                            </label>
                            <input type="url" name="scholar_url"
                                   class="input input-bordered @error('scholar_url') input-error @enderror"
                                   value="{{ old('scholar_url', auth()->user()->scholar_url ?? '') }}"
                                   placeholder="https://scholar.google.com/...">
                            @error('scholar_url')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Sinta / Portal Riset</span>
                            </label>
                            <input type="url" name="sinta_url"
                                   class="input input-bordered @error('sinta_url') input-error @enderror"
                                   value="{{ old('sinta_url', auth()->user()->sinta_url ?? '') }}"
                                   placeholder="https://sinta.kemdikbud.go.id/...">
                            @error('sinta_url')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Website / Portofolio</span>
                        </label>
                        <input type="url" name="website_url"
                               class="input input-bordered @error('website_url') input-error @enderror"
                               value="{{ old('website_url', auth()->user()->website_url ?? '') }}"
                               placeholder="https://...">
                        @error('website_url')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="submit" class="btn btn-primary gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- FORM UBAH PASSWORD --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
                <h2 class="card-title mb-4">Ubah Password</h2>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Password Saat Ini</span>
                        </label>
                        <input type="password" name="current_password"
                               class="input input-bordered @error('current_password') input-error @enderror" required>
                        @error('current_password')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Password Baru</span>
                            </label>
                            <input type="password" name="password"
                                   class="input input-bordered @error('password') input-error @enderror" required>
                            @error('password')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Konfirmasi Password Baru</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="input input-bordered" required>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-secondary gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    {{-- Cropper.js --}}
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>

    <script>
        // === KODE CROPPER (SESUAI IMPLEMENTASI KAMU) ===
        let cropper;
        const photoInput = document.getElementById('photo-input');
        const cropperContainer = document.getElementById('cropper-container');
        const cropperImage = document.getElementById('cropper-image');
        const croppedImageInput = document.getElementById('cropped-image-input');
        const avatarPreviewImg = document.getElementById('avatar-preview-img');

        if (photoInput) {
            photoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function (event) {
                    cropperImage.src = event.target.result;
                    cropperContainer.classList.remove('hidden');

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        background: false,
                        zoomOnWheel: true,
                        ready() {
                            updateCroppedImage();
                        },
                        crop() {
                            updateCroppedImage();
                        }
                    });
                };
                reader.readAsDataURL(file);
            });
        }

        function updateCroppedImage() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
            });
            const dataUrl = canvas.toDataURL('image/png');
            croppedImageInput.value = dataUrl;
            avatarPreviewImg.src = dataUrl;
        }

        const zoomInBtn = document.getElementById('cropper-zoom-in');
        const zoomOutBtn = document.getElementById('cropper-zoom-out');
        const resetBtn = document.getElementById('cropper-reset');

        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', function () {
                if (cropper) cropper.zoom(0.1);
            });
        }
        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', function () {
                if (cropper) cropper.zoom(-0.1);
            });
        }
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                if (cropper) cropper.reset();
            });
        }

        // === DOWNLOAD QR: pakai SVG di halaman, convert via canvas ===
        function downloadQrCode(dosenId, dosenName) {
            const qrDisplay = document.getElementById('qr-display');
            if (!qrDisplay) {
                alert('QR Code belum tersedia');
                return;
            }

            const svg = qrDisplay.innerHTML;
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            const svgBlob = new Blob([svg], {type: 'image/svg+xml;charset=utf-8'});
            const url = URL.createObjectURL(svgBlob);

            img.onload = () => {
                const size = 500;
                canvas.width = size;
                canvas.height = size;
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, size, size);
                ctx.drawImage(img, 0, 0, size, size);

                canvas.toBlob(blob => {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `qrcode-${dosenName.replace(/\s+/g, '-')}.png`;
                    link.click();
                });
            };

            img.src = url;
        }

        // COPY URL QR
        function copyQrUrl() {
            const urlInput = document.getElementById('qr-url-input');
            const copyIcon = document.getElementById('copy-icon-qr');
            const feedback = document.getElementById('copy-feedback-qr');

            urlInput.select();
            urlInput.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(urlInput.value)
                .then(() => {
                    feedback.classList.remove('hidden');
                    copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';

                    setTimeout(() => {
                        feedback.classList.add('hidden');
                        copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />';
                    }, 2000);
                })
                .catch(err => {
                    console.error('Copy failed:', err);
                    alert('Gagal menyalin link. Silakan copy manual.');
                });
        }

        // PRINT QR
        function printQrCode() {
            const qrDisplay = document.getElementById('qr-display');
            if (!qrDisplay) {
                alert('QR Code belum tersedia');
                return;
            }

            const userName = {!! json_encode(auth()->user()->name) !!};
            const userNip = {!! json_encode(auth()->user()->nip ?? '-') !!};
            const qrUrl = {!! json_encode($qrCodeUrl) !!};

            const w = window.open('', '_blank', 'width=600,height=700');
            w.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>QR Code - ${userName}</title>
                    <style>
                        body {
                            font-family: system-ui, -apple-system, sans-serif;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            min-height: 100vh;
                            margin: 0;
                            background: white;
                        }
                        .qr-container {
                            text-align: center;
                            padding: 2rem;
                            border-radius: 1rem;
                        }
                        h2 { margin: 0 0 0.5rem; font-size: 1.5rem; }
                        p { margin: 0.25rem 0; color: #555; font-size: 0.9rem; }
                        .qr-box {
                            background: white;
                            padding: 1.5rem;
                            border-radius: 0.75rem;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            display: inline-block;
                            margin: 1rem 0;
                        }
                        .url {
                            font-size: 0.75rem;
                            color: #777;
                            word-break: break-all;
                            max-width: 400px;
                            margin: 1rem auto 0;
                        }
                        @media print {
                            body { background: white; }
                        }
                    </style>
                </head>
                <body>
                    <div class="qr-container">
                        <h2>${userName}</h2>
                        <p>NIP: ${userNip}</p>
                        <p><strong>Scan untuk booking konsultasi</strong></p>
                        <div class="qr-box">
                            ${qrDisplay.innerHTML}
                        </div>
                        <div class="url">${qrUrl}</div>
                    </div>
                </body>
                </html>
            `);
            w.document.close();
            setTimeout(() => {
                w.print();
            }, 500);
        }

        // SHARE QR URL
        function shareQrCode() {
            const qrUrl = {!! json_encode($qrCodeUrl) !!};
            const userName = {!! json_encode(auth()->user()->name) !!};

            if (navigator.share) {
                navigator.share({
                    title: 'Profil Dosen - ' + userName,
                    text: 'Booking konsultasi dengan ' + userName + ' di Lab WICIDA',
                    url: qrUrl
                }).catch(err => {
                    console.error('Share failed:', err);
                    copyQrUrl();
                });
            } else {
                copyQrUrl();
                alert('Link berhasil disalin! Bagikan melalui aplikasi favorit Anda.');
            }
        }
    </script>
@endpush
@endsection
