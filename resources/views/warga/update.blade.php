@extends('layout.admin')

@section('title', 'Edit Data Warga')

@section('content')
<div class="container-fluid">
    <div class="card shadow border-0 rounded-4 p-4">
        <h4 class="fw-bold text-primary mb-4">Edit Data Warga</h4>

        <form action="{{ route('warga.update', $warga->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $warga->nama) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $warga->alamat) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">No Telepon</label>
                <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $warga->no_telepon) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-Laki" {{ $warga->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ $warga->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
