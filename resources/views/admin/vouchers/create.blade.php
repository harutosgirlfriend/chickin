@extends('templateAdmin')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Voucher</h2>

            <form action="{{ route('admin.vouchers.store') }}" method="post">
                @csrf
                <div class="mb-2">
                    <label>Nilai Diskon</label>
                    <input type="number" name="nilai_diskon" class="form-control" required min="0">
                </div>
                @error('nilai_diskon')
                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-2">
                    <label>Minimal Belanja</label>
                    <input type="number" name="min_belanja" class="form-control" required min="0" step="0.01">
                </div>
                @error('min_belanja')
                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-2">
                    <label>Mulai Berlaku</label>
                    <input type="date" name="mulai_berlaku" class="form-control" required>
                </div>
                @error('mulai_berlaku')
                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-2">
                    <label>Kadaluarsa Pada</label>
                    <input type="date" name="kadaluarsa_pada" class="form-control">
                </div>
                @error('kadaluarsa_pada')
                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-2">
                    <label>Tipe Diskon</label>
                    <select name="tipe_diskon" class="form-control" required>
                        <option value="persen">Persen</option>
                        <option value="nominal">Nominal</option>
                    </select>
                </div>
                @error('tipe_diskon')
                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                @enderror
                <div class="mb-2">
                    <label>Maksimal Diskon(kalau tipe diskon persen)</label>
                    <input type="number" name="maks_diskon" class="form-control" step="0.01">
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endsection
