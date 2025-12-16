@extends('templateAdmin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Voucher</h2>

        <form action="{{ route('admin.vouchers.update', $voucher->kode_voucher) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label>Kode Voucher</label>
                <input type="text" value="{{ $voucher->kode_voucher }}" class="form-control" disabled>
            </div>

            <div class="mb-2">
                <label>Nilai Diskon</label>
                <input type="number" name="nilai_diskon" value="{{ old('nilai_diskon', $voucher->nilai_diskon) }}" class="form-control" required min="0">
                @error('nilai_diskon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-2">
                <label>Minimal Belanja</label>
                <input type="number" name="min_belanja" value="{{ old('min_belanja', $voucher->min_belanja) }}" class="form-control" required min="0" step="0.01">
                @error('min_belanja')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-2">
                <label>Mulai Berlaku</label>
                <input type="date" name="mulai_berlaku" value="{{ old('mulai_berlaku', date('Y-m-d', strtotime($voucher->mulai_berlaku))) }}" class="form-control" required>
                @error('mulai_berlaku')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-2">
                <label>Kadaluarsa Pada</label>
                <input type="date" name="kadaluarsa_pada" value="{{ old('kadaluarsa_pada', $voucher->kadaluarsa_pada ? date('Y-m-d', strtotime($voucher->kadaluarsa_pada)) : '') }}" class="form-control">
                @error('kadaluarsa_pada')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-2">
                <label>Tipe Diskon</label>
                <select name="tipe_diskon" class="form-control" required>
                    <option value="persen" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'persen' ? 'selected' : '' }}>Persen</option>
                    <option value="nominal" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'nominal' ? 'selected' : '' }}>Nominal</option>
                </select>
                @error('tipe_diskon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-2">
                <label>Maksimal Diskon</label>
                <input type="number" name="maks_diskon" value="{{ old('maks_diskon', $voucher->maks_diskon) }}" class="form-control" step="0.01">
                @error('maks_diskon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
