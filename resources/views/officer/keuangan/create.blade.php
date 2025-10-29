@extends('layout.officer')

@section('title', 'Tambah Transaksi Keuangan')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-plus-circle me-2"></i> Tambah Transaksi Keuangan
    </h3>

    {{-- Alert Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Tambah Transaksi --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('officer.keuangan.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipe" class="form-label">Tipe Transaksi</label>
                        <select class="form-select" id="tipe" name="tipe" required>
                            <option value="">Pilih Tipe</option>
                            <option value="masuk">Uang Masuk</option>
                            <option value="keluar">Uang Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="100" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan
                    </button>
                    <a href="{{ route('officer.keuangan') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
