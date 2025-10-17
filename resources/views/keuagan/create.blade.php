@extends('layout.admin')

@section('title', 'Tambah Data Keuangan')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-wallet2 me-2"></i> Tambah Data Keuangan
    </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('keuangan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tipe" class="form-label fw-semibold">Tipe Transaksi</label>
            <select name="tipe" id="tipe" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="masuk" {{ old('tipe') == 'masuk' ? 'selected' : '' }}>Uang Masuk</option>
                <option value="keluar" {{ old('tipe') == 'keluar' ? 'selected' : '' }}>Uang Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Contoh: Pembayaran iuran RT" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label fw-semibold">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah uang" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
