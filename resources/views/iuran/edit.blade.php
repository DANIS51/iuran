@extends('layout.admin')

@section('title', 'Edit Iuran')

@section('content')
<div class="card shadow border-0 rounded-4 p-4">
    <h4 class="fw-bold text-primary mb-3">Edit Iuran</h4>

    <form action="{{ route('iuran.update', $iuran->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Iuran</label>
            <input type="text" name="nama_iuran" class="form-control" value="{{ $iuran->nama_iuran }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $iuran->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Periode</label>
            <select name="periode" class="form-select" required>
                <option value="mingguan" {{ $iuran->periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ $iuran->periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahunan" {{ $iuran->periode == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ $iuran->keterangan }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('iuran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
