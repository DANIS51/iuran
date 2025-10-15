@extends('layout.admin')

@section('title', 'Tambah Warga')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Data Warga
        </div>

        <div class="card-body p-4">
            {{-- Form Tambah Data --}}
            <form action="{{ route('warga.store') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Warga</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap warga" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No Telepon --}}
                <div class="mb-3">
                    <label for="no_telepon" class="form-label fw-semibold">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                        class="form-control @error('no_telepon') is-invalid @enderror"
                        placeholder="Masukkan nomor telepon aktif" value="{{ old('no_telepon') }}">
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
