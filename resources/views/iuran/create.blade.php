@extends('layout.admin')

@section('title', 'Tambah Iuran')

@section('content')
<div class="card shadow border-0 rounded-4 p-4">
    <h4 class="fw-bold text-primary mb-3">Tambah Iuran</h4>

    <form action="{{ route('iuran.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Iuran</label>
            <input type="text" name="nama_iuran" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Periode</label>
            <select name="periode" class="form-select" required>
                <option value="">-- Pilih Periode --</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
                <option value="tahunan">Tahunan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('iuran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
