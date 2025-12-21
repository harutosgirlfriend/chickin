@extends('templateAdmin')



@section('content')
    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">

                <div class="flex justify-between items-center mb-6">

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Data Product
                    </h2>
                    <div class="flex space-x-3">
                        <div class="flex input-group w-50 rounded-md border-2 px-2">
                            <div class="icon flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <input id="liveSearch" class="form-control border-none" type="text" name="keyword"
                                placeholder="Cari Produk" value="">
                        </div>
                        <button data-bs-toggle="modal" data-bs-target="#modalTambahProduct"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md">
                            Tambah Product
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Gambar
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Kode Product <span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Nama <span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Stok<span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Kategori
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Harga
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                    AKSI
                                </th>
                            </tr>
                        </thead>

                        <tbody  id="productTable"  class="bg-white divide-y divide-gray-200">


                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-indigo-600 font-medium w-16"><img
                                            src=" {{ asset('images/product/' . $product->gambar) }}" alt=""></td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->kode_product }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->nama_product }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $product->stok }}</td>

                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->kategori }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->harga }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <button class="text-indigo-600 hover:text-indigo-900 flex p-2" title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditProduct{{ $product->kode_product }}">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                Edit
                                            </button>
                                        </span>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <button class="text-blue-600 hover:text-blue-900 flex p-2" title="Detail"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailProduct{{ $product->kode_product }}">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg> Detail
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modalDetailProduct{{ $product->kode_product }}" tabindex="-1"
                                    aria-labelledby="modalDetailProductLabel{{ $product->kode_product }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalDetailProductLabel{{ $product->kode_product }}">Detail Product
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="flex gap-5">
                                                    <div class="text-center mb-3">
                                                        <?php if ($product->gambar) : ?>
                                                        <img src="{{ asset('images/product/' . $product->gambar) }}"
                                                            width="150" class="img-fluid rounded" alt="Gambar Barang">
                                                        <?php else : ?>
                                                        <em>Tidak ada gambar</em>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="">
                                                        <p><strong>Kode Product:</strong>{{ $product->kode_product }}</p>
                                                        <p><strong>Nama Product:</strong> {{ $product->kode_product }}</p>
                                                        <p><strong>Harga:</strong> {{ $product->harga }}</p>
                                                        <p><strong>Stok:</strong> {{ $product->stok }}</p>
                                                        <p><strong>Kategori:</strong> {{ $product->kategori }}</p>
                                                    </div>
                                                </div>


                                                <p><strong>Deskripsi</strong>
                                                    <textarea name="deskripsi"
                                                        class="form-control resize-y w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                        rows="4" required>{{ $product->deskripsi }}</textarea>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalEditProduct{{ $product->kode_product }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="{{ route('edit.product', $product->kode_product) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <fieldset>
                                                        <legend>Edit Product</legend>
                                                        <input type="hidden" name="kode_product"
                                                            value="{{ $product->kode_product }}">

                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Product</label>
                                                            <input type="text" name="nama_product"
                                                                class="form-control" value="{{ $product->nama_product }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Stok</label>
                                                            <input type="text" name="stok" class="form-control"
                                                                value="{{ $product->stok }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Harga</label>
                                                            <input type="text" name="harga" class="form-control"
                                                                value="{{ $product->harga }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kategori</label>
                                                            <input type="text" name="kategori" class="form-control"
                                                                value="{{ $product->kategori }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi"
                                                                class="form-control resize-y w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                                                rows="4" required>{{ $product->deskripsi }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Ganti Gambar (jika perlu)</label>
                                                            <input type="file" name="gambar[]" class="form-control" multiple>
                                                        
                                                        </div>
                                                    </fieldset>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach





                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="modalTambahProduct" tabindex="-1" aria-labelledby="modalTambahProductLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('product.simpan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Nama Product</label>
                                        <input type="text" name="nama_product" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga</label>
                                        <input type="number" name="harga" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi"
                                            class="form-control resize-y w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            rows="4" required></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Kategori</label>
                                        <input type="text" name="kategori" class="form-control" required>
                                    </div>

                                    <div class="mb-2">
                                        <label>Gambar</label>
                                           <input type="file" name="gambar[]" class="form-control" multiple>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
document.getElementById('liveSearch').addEventListener('keyup', function () {
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll('#productTable tr');

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
