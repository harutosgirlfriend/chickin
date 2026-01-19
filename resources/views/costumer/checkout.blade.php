@extends('template')

@section('title', 'Checkout')

@section('content')


    <div class="flex flex-col p-5 w-full mx-auto">

        <div class="lg:w-1/2 md:w-3/5 w-full max-w-lg p-10 shadow-xl shadow-[#e4c6ba]/70 rounded-md mx-auto">

            <h1 class="text-center text-xl font-bold mb-5">MASUKKAN DATA DIRI ANDA</h1>
            <form action="{{ route('simpan.transaksi') }}" onsubmit="return cekPembayaran(event)" id="checkoutForm">
                <input type="text" hidden name="kode_transaksi" value="{{ $kode_transaksi }}">
                @if ($product)
                    <div class="flex items-center justify-between border-b pb-3 w-full">
                        <div class="flex items-center space-x-3 w-full">
                            <img src="{{ asset('images/product/' . $product->gambar) }}" alt="Produk"
                                class="w-16 h-16 rounded-md object-cover">
                            <div>
                                <p class="font-medium">{{ $product->kode_product }}</p>
                                <p class="font-medium">{{ $product->nama_product }}</p>
                                <input class="font-medium" hidden name="kode_product" value="{{ $product->kode_product }}">
                                <input class="font-medium" hidden name="jumlah" value="{{ $product->jumlah }}">
                                <input class="font-medium" hidden name="harga" value="{{ $product->harga }}">
                                <input class="font-medium" hidden name="nama_product" value="{{ $product->nama_product }}">
                                <input class="font-medium" hidden name="subtotal"
                                    value="{{ $product->jumlah * $product->harga }}">


                                <p class="text-sm text-gray-500" id="hargaEl"></p>
                                <input class="text-sm text-gray-500 intharga" hidden name=""
                                    value="{{ $product->harga }}"id="harga">
                                <input class="text-sm text-gray-500 intharga" hidden name=""
                                    value="{{ $product->nama_product }}"id="nama_product">
                                <input class="text-sm text-gray-500 intharga" hidden name=""
                                    value="{{ $product->jumlah }}"id="jumlah">
                                <input class="text-sm text-gray-500 intharga" hidden name="total_harga"
                                    value="{{ $total }}"id="">
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">{{ $product->jumlah }}X</p>
                            <input class="font-semibold" hidden value="{{ $product->jumlah }}">

                            <p class="text-gray-600 subEl">
                                Rp{{ number_format($product->jumlah * $product->harga) }}
                            </p>
                            <input class="font-semibold subtotal" hidden value="{{ $product->jumlah * $product->harga }}">
                        </div>
                    </div>
                @endif
                @if ($items)
                    @foreach ($items as $product)
                        <div class="flex items-center justify-between border-b pb-3 w-full">
                            <div class="flex items-center space-x-3 w-full">
                                <img src="{{ asset('images/product/' . $product->product->gambar) }}" alt="Produk"
                                    class="w-16 h-16 rounded-md object-cover">
                                <div>
                                    <p class="font-medium">{{ $product->kode_product }}</p>
                                    <p class="font-medium">{{ $product->product->nama_product }}</p>

                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][kode_product]"
                                        value="{{ $product->kode_product }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][jumlah]"
                                        value="{{ $product->jumlah }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][harga]"
                                        value="{{ $product->product->harga }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][subtotal]"
                                        value="{{ $product->jumlah * $product->product->harga }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][nama_product]"
                                        value="{{ $product->product->nama_product }}">


                                    <p class="text-sm text-gray-500" id="hargaEl"></p>
                                    <input class="text-sm text-gray-500 intharga" hidden name=""
                                        value="{{ $product->product->harga }}"id="harga">
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ $product->jumlah }}X</p>
                                <input class="font-semibold" hidden value="{{ $product->jumlah }}">

                                <p class="text-gray-600 subEl">{{ $product->jumlah * $product->product->harga }}
                                </p>
                                <input class="font-semibold subtotal" hidden
                                    value="{{ $product->jumlah * $product->product->harga }}">
                            </div>
                        </div>
                    @endforeach

                @endif



                <div class="form grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">


                    <div class="md:col-span-2">
                        <label for="price" class="block text-sm/6 font-medium text-gray-900">Nama</label>
                        <div class="mt-2">
                            <div
                                class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <input type="text" name="nama" placeholder="Nama"
                                    class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                    value="{{ auth()->user()->nama }}" />

                            </div>
                            <input class="font-medium" hidden name="id_user" value="{{ auth()->user()->id }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm/6 font-medium text-gray-900">Kabupaten/Kota</label>
                        <div class="mt-2">

                            <div class="mt-2">
                                <select id="kabupaten" name="kota" data-selected="{{ old('kota') }}"
                                    class="w-full rounded-md border-gray-300 p-3 text-gray-900 focus:ring-indigo-600 focus:border-indigo-600">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div>
                        <label class="block text-sm/6 font-medium text-gray-900">Kecamatan</label>
                        <div class="mt-2">
                            <div class="mt-2">
                                <select id="kecamatan" name="kecamatan"
                                    class="w-full rounded-md border-gray-300 py-1.5 pl-3 pr-7 text-gray-900 focus:ring-indigo-600 focus:border-indigo-600">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                        </div>
                    </div>



                </div>

                {{-- <button type="button" id="pembayaran">Pembayaran</button> --}}

                <div class="">
                    <label for="ongkir" class="block text-sm/6 font-medium text-gray-900">Ongkir</label>
                    <div class="mt-2">
                        <p id="ongkirText" class="flex items-center rounded-md bg-white pl-3 py-1.5 h-[38px]">

                            Rp 10.000
                        </p>

                    </div>
                </div>
                <div class="md:col-span-2">
                    <label for="voucher_select" class="block text-base font-medium text-gray-900">
                        Diskon
                    </label>

                    <div class="mt-2">
                        <select id="voucher_select" name="voucher"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">
                                {{ $voucher->count() }} voucher tersedia
                            </option>

                            @foreach ($voucher as $v)
                                <option value="{{ $v->kode_voucher }}" data-type="{{ $v->tipe_diskon }}"
                                    data-value="{{ $v->nilai_diskon }}" data-min="{{ $v->min_belanja }}"
                                    data-max="{{ $v->maks_diskon ?? 0 }}">
                                    @if ($v->tipe_diskon === 'persen')
                                        Diskon {{ $v->nilai_diskon }}%
                                        @if ($v->maks_diskon)
                                            (maks Rp{{ number_format($v->maks_diskon) }})
                                        @endif
                                    @else
                                        Potongan Rp{{ number_format($v->nilai_diskon) }}
                                    @endif
                                    • Min belanja Rp{{ number_format($v->min_belanja) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm/6 font-medium text-gray-900">Alamat</label>
                    <div class="mt-2 border border-gray-300 rounded-md">
                        <textarea id="alamat" name="alamat" rows="3" placeholder="Jl. abc/Ds. durian runtuh rt 01"
                            class="block w-full resize-none py-1 px-2 text-base text-gray-900 placeholder:text-gray-400 
                   focus:ring-indigo-600 focus:border-indigo-600 focus:outline-none sm:text-sm/6 rounded-md"
                            value="{{ old('alamat') }}" required></textarea>
                    </div>

                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm/6 font-medium text-gray-900">Total</label>
                    <div class="mt-2">
                        <p id="totalText"
                            class="flex items-center rounded-md bg-white pl-3 py-1.5 border border-gray-300 h-[38px]">
                            Rp {{ number_format($total) }}
                        </p>

                        <input type="hidden" id="totalHarga" value="{{ $total }}">
                        <input type="hidden" id="ongkir" value="0" name="ongkir">
                        <input type="hidden" name="id_voucher" id="voucherInput">

                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="metode_pembayaran" class="block text-sm/6 font-medium text-gray-900">Metode
                        Pembayaran</label>
                    <label class=" flex w-full items-center space-x-2 bg-white p-2 cursor-pointer rounded-md">
                        <input type="radio" id="cod" name="metode_pembayaran" value="COD" checked
                            class="appearance-none w-4 h-4 border-2 border-green-500 rounded-full 
              checked:bg-green-500 checked:border-green-500">
                        <label for="ukuran-s">COD</label><br>

                        <input type="radio" id="pay-button" name="metode_pembayaran" value="nontunai"
                            class="appearance-none w-4 h-4 border-2 border-green-500 rounded-full 
              checked:bg-green-500 checked:border-green-500">
                        <label for="ukuran-m">Metode Lain</label><br>
                    </label>


                    {{-- <p>Jarak ke lokasi anda: <strong id="jarak">-</strong></p>
                    <input type="hidden" name="jarak" id="jarak_input"> --}}

                    <div class="md:col-span-2 flex justify-center items-center w-full mt-4">
                        <button class="p-3 bg-indigo-500 w-full rounded-md" type="submit" id="link">

                            <span class="font-semibold text-white">BELI SEKARANG</span>

                        </button>
                    </div>

                </div>


            </form>

        </div>

    </div>
    <div id="loading" class="fixed inset-0 bg-white/80 flex items-center justify-center z-50 hidden">
        <div class="w-12 h-12 border-4 border-gray-300 border-t-blue-500 rounded-full animate-spin"></div>
    </div>

    {{-- <script>
        document.getElementById('pembayaran').addEventListener('click', function() {

            // buka popup
            document.getElementById('popup').classList.remove('hidden');

            let kode_trans = document.getElementById('kode_trans').value;
            let total = document.getElementById('total').value;

            // loading
            document.getElementById('qr_area').innerHTML = `
        <div class="text-center py-4">
            <div class="w-10 h-10 border-4 border-gray-300 border-t-blue-600 rounded-full animate-spin mx-auto mb-3"></div>
            <p class="text-gray-600">Memuat QR...</p>
        </div>
    `;

            fetch("{{ route('qris') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode_transaksi: kode_trans,
                        total_harga: total
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('qr_area').innerHTML = `
                <img src="${data.qr_url}" 
                     class="w-60 mx-auto my-4 rounded-lg shadow">
                <p class="text-sm text-gray-600">Kode Transaksi:</p>
                <p class="font-semibold mb-2">${kode_trans}</p>
                <p class="text-sm text-gray-600">Total:</p>
                <p class="font-semibold mb-2">Rp ${total}</p>
            `;
      
                    } else {
                        document.getElementById('qr_area').innerHTML = `
                <p class="text-red-600 font-semibold">
                    Gagal membuat QRIS.
                </p>
            `;
                    }
                });
        });

        // close popup
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('popup').classList.add('hidden');
        });

        // klik di luar modal
        window.onclick = function(e) {
            if (e.target === document.getElementById('popup')) {
                document.getElementById('popup').classList.add('hidden');
            }
        }
    </script> --}}
    <!-- Loading Overlay -->

    <div id="ongkirLoading" class="hidden flex items-center gap-2 text-sm text-gray-600 mt-2">
        <svg class="animate-spin h-4 w-4 text-indigo-500" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                fill="none"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z"></path>
        </svg>
        <span>Menghitung ongkir...</span>
    </div>



    <div id="loading" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="w-16 h-16 border-4 border-t-4 border-gray-200 border-t-blue-500 rounded-full animate-spin"></div>
    </div>

    <script type="text/javascript">
        let snapToken = '';
        document.getElementById('voucher_select').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];

            const tipe = selected.dataset.type;
            const nilai = parseFloat(selected.dataset.value || 0);
            const min = parseFloat(selected.dataset.min || 0);

            const subtotal = parseFloat(document.getElementById('totalHarga').value);
            const ongkir = parseFloat(document.getElementById('ongkir').value);

            let diskon = 0;

            if (subtotal >= min) {
                if (tipe === 'persen') {
                    diskon = subtotal * (nilai / 100);
                } else if (tipe === 'nominal') {
                    diskon = nilai;
                }
            }

            const totalBayar = Math.max(subtotal - diskon, 0) + ongkir;

            document.getElementById('totalText').innerText =
                'Rp ' + totalBayar.toLocaleString('id-ID');

            document.getElementById('voucherInput').value = selected.value;
        });

        function validasiSebelumBayar() {
            const alamat = document.getElementById('alamat').value.trim();
            const kabupaten = document.getElementById('kabupaten').value;
            const kecamatan = document.getElementById('kecamatan').value;

            const voucherSelect = document.getElementById('voucher_select');
            const voucherDipilih = voucherSelect.value;
            const jumlahVoucher = voucherSelect.options.length - 1;

            if (!alamat) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Alamat belum diisi',
                    text: 'Harap masukkan alamat pengiriman terlebih dahulu'
                });
                return false;
            }

            if (!kabupaten) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kabupaten belum dipilih',
                    text: 'Harap pilih kabupaten/kota terlebih dahulu'
                });
                return false;
            }

            if (!kecamatan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kecamatan belum dipilih',
                    text: 'Harap pilih kecamatan terlebih dahulu'
                });
                return false;
            }


            if (jumlahVoucher > 0 && !voucherDipilih) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Voucher belum dipilih',
                    text: 'Silakan pilih voucher terlebih dahulu'
                });
                return false;
            }

            return true;
        }



        const payRadio = document.getElementById('pay-button');

        payRadio.addEventListener('click', async function() {

            if (!validasiSebelumBayar()) {
                this.checked = false;
                return;
            }

            if (snapToken !== '') {
                window.snap.pay(snapToken, {
                    onSuccess: function() {
                        document.getElementById('checkoutForm').submit();
                    }
                });
                return;
            }

            if (snapToken !== '') {
                window.snap.pay(snapToken, {
                    onSuccess: function() {
                        document.getElementById('checkoutForm').submit();
                    },
                    onPending: function() {

                    },
                    onError: function() {

                    },
                    onClose: function() {


                    }
                });
            } else {
                if (!this.checked) return;

                try {
                    const formData = new FormData(document.getElementById('checkoutForm'));

                    const response = await fetch('/generate-snap-token', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!data.snap_token) {
                        alert('Gagal mendapatkan token');
                        this.checked = false;
                        return;
                    }
                    snapToken = data.snap_token;
                    window.snap.pay(data.snap_token, {
                        onSuccess: function() {
                            document.getElementById('checkoutForm').submit();
                        },
                        onPending: function() {

                        },
                        onError: function() {

                        },
                        onClose: function() {


                        }
                    });

                } catch (e) {
                    console.error(e);
                    payRadio.checked = false;
                }
            }

        });


        $(document).ready(function() {

            const ORS_API_KEY =
                "eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6ImRmYjc4NTVlYjUwYTQyZmFhNDdkNzNmMGE2NWY1ZWM2IiwiaCI6Im11cm11cjY0In0=";

            const allowedKabupaten = [{
                    id: 3375,
                    name: "Pekalongan",
                    tipe: "Kota"
                },
                {
                    id: 3325,
                    name: "Batang",
                    tipe: "Kabupaten"
                }
            ];

            const tujuanKabupaten = {
                3375: {
                    lat: -6.8886,
                    lng: 109.6753
                },
                3325: {
                    lat: -6.9729,
                    lng: 109.7099
                }
            };


            $('#kabupaten').select2({
                placeholder: "Pilih Kabupaten/Kota",
                width: '100%'
            });

            $('#kecamatan').select2({
                placeholder: "Pilih Kecamatan",
                width: '100%'
            });


            $('#kabupaten').append('<option value=""></option>');

            allowedKabupaten.forEach(k => {
                $('#kabupaten').append(
                    `<option value="${k.name}" data-id="${k.id}">
                ${k.tipe} ${k.name}
            </option>`
                );
            });

            $('#kabupaten').on('change', function() {

                const kabID = $(this).find(':selected').data('id');

                $('#kecamatan')
                    .empty()
                    .append('<option value="">Loading...</option>')
                    .trigger('change');

                if (!kabID) return;

                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabID}.json`)
                    .then(res => res.json())
                    .then(data => {

                        $('#kecamatan').empty();

                        let filtered = data;


                        if (kabID == 3325) {
                            const allowedBatang = ['batang', 'kandeman'];
                            filtered = data.filter(kec =>
                                allowedBatang.includes(kec.name.toLowerCase().trim())
                            );
                        }

                        if (filtered.length === 0) {
                            $('#kecamatan')
                                .append('<option value="">Kecamatan tidak tersedia</option>')
                                .trigger('change');
                            return;
                        }

                        $('#kecamatan').append('<option value=""></option>');

                        filtered.forEach(kec => {
                            $('#kecamatan').append(
                                `<option value="${kec.name}">${kec.name}</option>`
                            );
                        });

                        $('#kecamatan').trigger('change');
                    })
                    .catch(() => {
                        alert('Gagal memuat kecamatan');
                        $('#kecamatan')
                            .empty()
                            .append('<option value=""></option>')
                            .trigger('change');
                    });
            });


            $('#kecamatan').on('change', function() {

                const kecamatan = $(this).val();
                if (!kecamatan) return;


                const kabID = $('#kabupaten').find(':selected').data('id');
                const tujuan = tujuanKabupaten[kabID];
                if (!tujuan) return;

                $('#ongkirLoading').removeClass('hidden');
                $('#ongkirText').text('Menghitung...');
                let ongkir = 0;
                if (kecamatan.toLowerCase().includes('batang') || kecamatan.toLowerCase().includes(
                        'kandeman')) {
                    ongkir = 15000;
                } else if (kecamatan.toLowerCase().includes('pekalongan barat')) {
                    ongkir = 13 * 1500;
                } else if (kecamatan.toLowerCase().includes('pekalongan timur')) {
                    ongkir = 12 * 1500;
                } else if (kecamatan.toLowerCase().includes('pekalongan selatan')) {
                    ongkir = 14 * 1500;
                } else {
                    ongkir = 14 * 1500;
                }


                $('#ongkir').val(ongkir);
                $('#ongkirText').text(
                    'Rp ' + ongkir.toLocaleString('id-ID')
                );

                $('#ongkirLoading').addClass('hidden');
                hitungTotalAkhir();


            });
        });


        function hitungTotalAkhir() {
            const subtotal = parseFloat($('#totalHarga').val()) || 0;
            const ongkir = parseFloat($('#ongkir').val()) || 0;

            const selected = $('#voucher_select option:selected');

            let diskon = 0;

            if (selected.val()) {
                const tipe = selected.data('type');
                const nilai = parseFloat(selected.data('value')) || 0;
                const min = parseFloat(selected.data('min')) || 0;
                const max = parseFloat(selected.data('max')) || 0;

                if (subtotal >= min) {
                    if (tipe === 'persen') {
                        diskon = subtotal * (nilai / 100);
                    } else {
                        diskon = nilai;
                    }

                    // 🔒 BATASI MAKS DISKON
                    if (max > 0) {
                        diskon = Math.min(diskon, max);
                    }
                }
            }

            const total = Math.max(subtotal - diskon, 0) + ongkir;

            $('#totalText').text(
                'Rp ' + total.toLocaleString('id-ID')
            );

            return total;
        }


        document.getElementById('voucher_select').addEventListener('change', function() {
            document.getElementById('voucherInput').value = this.value;
            hitungTotalAkhir();
        });



        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        async function cekPembayaran(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            try {
                const loading = document.getElementById('loading');
                loading.classList.remove('hidden');

                const response = await fetch("/cek/transaksi", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const data = await response.json();

                loading.classList.add('hidden');

                if (data.success) {
                    payRadio.classList.value = data.pembayaran;
                    form.submit();
                } else {
                    Swal.fire({
                        title: 'Oops!',
                        text: data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }

            } catch (error) {
                document.getElementById('loading').classList.add('hidden');
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan koneksi',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }


            return false;
        }
    </script>
@endsection
