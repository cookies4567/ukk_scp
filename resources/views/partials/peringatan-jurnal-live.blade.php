{{-- Pembungkus peringatan jurnal + pembaruan otomatis tiap 30 detik. --}}
{{-- Variabel: $peringatanJurnal --}}
<div id="peringatan-jurnal" data-url="{{ route('guru.peringatan-jurnal') }}">
    @include('partials.peringatan-jurnal', ['peringatanJurnal' => $peringatanJurnal])
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var wadah = document.getElementById('peringatan-jurnal');
    if (!wadah) return;

    function segarkan() {
        fetch(wadah.dataset.url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            },
            cache: 'no-store',
            credentials: 'same-origin'
        })
            .then(function (res) {
                // Sesi berakhir -> diarahkan ke login; jangan timpa tampilan.
                if (!res.ok || res.redirected) return null;
                return res.text();
            })
            .then(function (html) {
                if (html !== null && html !== undefined) {
                    wadah.innerHTML = html;
                }
            })
            .catch(function () { /* abaikan, coba lagi pada siklus berikutnya */ });
    }

    setInterval(segarkan, 30000);
});
</script>
@endpush
