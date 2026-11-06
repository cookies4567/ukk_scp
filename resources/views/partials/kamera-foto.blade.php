{{--
    Komponen kamera real-time.

    Pemakaian: tambahkan atribut `data-kamera` pada <input type="file">,
    lalu sertakan partial ini satu kali di halaman.

    Atribut opsional pada input:
      data-kamera-max-mb="2"        batas ukuran foto hasil kamera (MB)
      data-kamera-target="#id"      tombol kamera disisipkan sebelum elemen ini
      data-kamera-class="kelas-css" kelas CSS untuk tombol kamera

    Catatan: kamera browser hanya jalan di HTTPS atau http://localhost.
--}}
@once
<style>
    .kamera-btn-buka,
    .kamera-btn-inline {
        font-family: inherit;
    }

    .kamera-btn-buka {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 14px;
        border: 1px solid #1f3a5f;
        border-radius: 7px;
        background: #ffffff;
        color: #1f3a5f;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .kamera-btn-buka:hover {
        background: #e6edf5;
    }

    .kamera-btn-inline {
        margin-left: 8px;
    }

    .kamera-thumb {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        padding: 8px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        max-width: 420px;
    }

    .kamera-thumb img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .kamera-thumb span {
        flex: 1;
        min-width: 0;
        font-size: 13px;
        color: #475569;
        overflow-wrap: anywhere;
    }

    .kamera-thumb button {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #b91c1c;
        padding: 5px 10px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .kamera-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(15, 23, 42, .75);
    }

    .kamera-box {
        width: 100%;
        max-width: 560px;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .35);
    }

    .kamera-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        color: #1f2f45;
        font-size: 15px;
    }

    .kamera-head button {
        border: none;
        background: transparent;
        color: #475569;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
    }

    .kamera-stage {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 220px;
        background: #000000;
    }

    .kamera-stage video,
    .kamera-stage img {
        display: block;
        width: 100%;
        max-height: 60vh;
        object-fit: contain;
    }

    .kamera-pesan {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #ffffff;
        font-size: 14px;
        line-height: 1.6;
        text-align: center;
        background: rgba(0, 0, 0, .6);
    }

    .kamera-aksi {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
        padding: 12px 16px;
    }

    .kamera-aksi button {
        padding: 9px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #ffffff;
        color: #334155;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .kamera-aksi button.kamera-utama {
        border-color: #1f3a5f;
        background: #1f3a5f;
        color: #ffffff;
    }

    .kamera-aksi button:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .kamera-modal[hidden],
    .kamera-modal [hidden],
    .kamera-thumb[hidden] {
        display: none !important;
    }
</style>

<div id="kameraModal" class="kamera-modal" hidden role="dialog" aria-modal="true" aria-labelledby="kameraJudul">
    <div class="kamera-box">
        <div class="kamera-head">
            <strong id="kameraJudul">Ambil Foto</strong>
            <button type="button" id="kameraTutup" aria-label="Tutup kamera">&times;</button>
        </div>

        <div class="kamera-stage">
            <video id="kameraVideo" autoplay playsinline muted></video>
            <img id="kameraHasil" alt="Hasil foto" hidden>
            <div id="kameraPesan" class="kamera-pesan" hidden></div>
        </div>

        <div class="kamera-aksi">
            <button type="button" id="kameraBatal">Batal</button>
            <button type="button" id="kameraGanti" hidden>Ganti Kamera</button>
            <button type="button" id="kameraAmbil" class="kamera-utama">Ambil Foto</button>
            <button type="button" id="kameraUlang" hidden>Ulangi</button>
            <button type="button" id="kameraPakai" class="kamera-utama" hidden>Gunakan Foto</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('kameraModal');
        var video = document.getElementById('kameraVideo');
        var hasil = document.getElementById('kameraHasil');
        var pesan = document.getElementById('kameraPesan');
        var btnTutup = document.getElementById('kameraTutup');
        var btnBatal = document.getElementById('kameraBatal');
        var btnGanti = document.getElementById('kameraGanti');
        var btnAmbil = document.getElementById('kameraAmbil');
        var btnUlang = document.getElementById('kameraUlang');
        var btnPakai = document.getElementById('kameraPakai');

        var stream = null;
        var inputAktif = null;
        var pemicu = null;
        var facing = 'environment';
        var blobHasil = null;
        var urlHasil = null;
        var maxMb = 2;

        function tampilPesan(teks) {
            pesan.textContent = teks || '';
            pesan.hidden = !teks;
        }

        function setMode(mode) {
            var live = mode === 'live';
            var tampilHasil = mode === 'hasil';

            video.hidden = !live;
            hasil.hidden = !tampilHasil;
            btnAmbil.hidden = !live;
            btnUlang.hidden = !tampilHasil;
            btnPakai.hidden = !tampilHasil;

            if (!live) {
                btnGanti.hidden = true;
            }
        }

        function berhenti() {
            if (stream) {
                stream.getTracks().forEach(function (t) { t.stop(); });
                stream = null;
            }
            video.srcObject = null;
        }

        function bersihkanHasil() {
            if (urlHasil) {
                URL.revokeObjectURL(urlHasil);
                urlHasil = null;
            }
            blobHasil = null;
            hasil.removeAttribute('src');
        }

        function pesanError(e) {
            if (!window.isSecureContext) {
                return 'Kamera hanya bisa dibuka lewat HTTPS atau http://localhost. ' +
                    'Buka aplikasi lewat alamat tersebut.';
            }
            switch (e && e.name) {
                case 'NotAllowedError':
                case 'SecurityError':
                    return 'Izin kamera ditolak. Aktifkan izin kamera pada browser, lalu buka kembali.';
                case 'NotFoundError':
                case 'OverconstrainedError':
                    return 'Kamera tidak ditemukan pada perangkat ini.';
                case 'NotReadableError':
                    return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi tersebut lalu coba lagi.';
                default:
                    return 'Kamera tidak dapat dibuka. Silakan pilih foto dari berkas.';
            }
        }

        function mulai() {
            berhenti();
            tampilPesan('');

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                setMode('error');
                tampilPesan(pesanError(null));
                return;
            }

            navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: facing },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            }).then(function (s) {
                // Modal sudah ditutup sebelum izin kamera selesai.
                if (modal.hidden) {
                    s.getTracks().forEach(function (t) { t.stop(); });
                    return;
                }

                stream = s;
                video.srcObject = s;
                setMode('live');

                var p = video.play();
                if (p && p.catch) { p.catch(function () {}); }

                return navigator.mediaDevices.enumerateDevices().then(function (daftar) {
                    var jumlah = daftar.filter(function (d) {
                        return d.kind === 'videoinput';
                    }).length;
                    btnGanti.hidden = jumlah < 2 || btnAmbil.hidden;
                });
            }).catch(function (e) {
                setMode('error');
                tampilPesan(pesanError(e));
            });
        }

        function buka(input, tombol) {
            inputAktif = input;
            pemicu = tombol;
            maxMb = parseFloat(input.dataset.kameraMaxMb) || 2;

            bersihkanHasil();
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
            setMode('live');
            mulai();
            btnAmbil.focus();
        }

        function tutup() {
            berhenti();
            bersihkanHasil();
            modal.hidden = true;
            document.body.style.overflow = '';
            if (pemicu) { pemicu.focus(); }
        }

        // Kompres bertahap supaya hasil foto tidak melebihi batas ukuran.
        function buatBlob(sumber, maxBytes) {
            var skala = 1;
            var kualitas = [0.9, 0.8, 0.7, 0.6];

            function coba(iterasi) {
                if (iterasi > 5) { return Promise.resolve(null); }

                var c = document.createElement('canvas');
                c.width = Math.round(sumber.width * skala);
                c.height = Math.round(sumber.height * skala);
                c.getContext('2d').drawImage(sumber, 0, 0, c.width, c.height);

                function cobaKualitas(i) {
                    if (i >= kualitas.length) {
                        skala *= 0.8;
                        return coba(iterasi + 1);
                    }
                    return new Promise(function (res) {
                        c.toBlob(res, 'image/jpeg', kualitas[i]);
                    }).then(function (b) {
                        if (b && b.size <= maxBytes) { return b; }
                        return cobaKualitas(i + 1);
                    });
                }

                return cobaKualitas(0);
            }

            return coba(0);
        }

        function ambil() {
            var vw = video.videoWidth;
            var vh = video.videoHeight;

            if (!vw || !vh) {
                tampilPesan('Kamera belum siap. Tunggu sebentar lalu coba lagi.');
                setTimeout(function () { tampilPesan(''); }, 2000);
                return;
            }

            var batasSisi = 1600;
            var skala = Math.min(1, batasSisi / Math.max(vw, vh));
            var canvas = document.createElement('canvas');
            canvas.width = Math.round(vw * skala);
            canvas.height = Math.round(vh * skala);
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            btnAmbil.disabled = true;

            buatBlob(canvas, maxMb * 1024 * 1024 * 0.95).then(function (blob) {
                btnAmbil.disabled = false;

                if (!blob) {
                    tampilPesan('Ukuran foto terlalu besar. Coba lagi dengan pencahayaan yang lebih baik.');
                    setTimeout(function () { tampilPesan(''); }, 2500);
                    return;
                }

                bersihkanHasil();
                blobHasil = blob;
                urlHasil = URL.createObjectURL(blob);
                hasil.src = urlHasil;
                setMode('hasil');
            });
        }

        function ulang() {
            bersihkanHasil();
            setMode('live');
            mulai();
        }

        function pakai() {
            if (!blobHasil || !inputAktif) { return; }

            var t = new Date();
            var dua = function (n) { return String(n).padStart(2, '0'); };
            var nama = 'foto-kamera-' + t.getFullYear() + dua(t.getMonth() + 1) +
                dua(t.getDate()) + '-' + dua(t.getHours()) + dua(t.getMinutes()) +
                dua(t.getSeconds()) + '.jpg';

            var file = new File([blobHasil], nama, {
                type: 'image/jpeg',
                lastModified: Date.now()
            });

            var dt = new DataTransfer();
            dt.items.add(file);
            inputAktif.files = dt.files;
            inputAktif.dispatchEvent(new Event('change', { bubbles: true }));

            tutup();
        }

        btnTutup.addEventListener('click', tutup);
        btnBatal.addEventListener('click', tutup);
        btnAmbil.addEventListener('click', ambil);
        btnUlang.addEventListener('click', ulang);
        btnPakai.addEventListener('click', pakai);
        btnGanti.addEventListener('click', function () {
            facing = facing === 'environment' ? 'user' : 'environment';
            mulai();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) { tutup(); }
        });

        window.addEventListener('pagehide', berhenti);

        // Pasang tombol kamera pada setiap input file yang bertanda data-kamera.
        document.querySelectorAll('input[type="file"][data-kamera]').forEach(function (input) {
            var tombol = document.createElement('button');
            tombol.type = 'button';
            tombol.className = input.dataset.kameraClass
                ? input.dataset.kameraClass + ' kamera-btn-inline'
                : 'kamera-btn-buka';
            tombol.textContent = '\uD83D\uDCF7 Ambil Foto dengan Kamera';

            var thumb = document.createElement('div');
            thumb.className = 'kamera-thumb';
            thumb.hidden = true;
            thumb.innerHTML =
                '<img alt="Pratinjau foto"><span></span>' +
                '<button type="button">Hapus</button>';

            var target = input.dataset.kameraTarget
                ? document.querySelector(input.dataset.kameraTarget)
                : null;

            if (target && target.parentNode) {
                target.parentNode.insertBefore(thumb, target);
                target.parentNode.insertBefore(tombol, thumb);
            } else {
                input.insertAdjacentElement('afterend', thumb);
                input.insertAdjacentElement('afterend', tombol);
            }

            var urlThumb = null;

            input.addEventListener('change', function () {
                if (urlThumb) {
                    URL.revokeObjectURL(urlThumb);
                    urlThumb = null;
                }

                var file = input.files && input.files[0];

                if (file && file.type.indexOf('image/') === 0) {
                    urlThumb = URL.createObjectURL(file);
                    thumb.querySelector('img').src = urlThumb;
                    thumb.querySelector('span').textContent =
                        file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
                    thumb.hidden = false;
                } else {
                    thumb.hidden = true;
                }
            });

            thumb.querySelector('button').addEventListener('click', function () {
                input.value = '';
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            tombol.addEventListener('click', function () {
                buka(input, tombol);
            });
        });
    });
</script>
@endonce
