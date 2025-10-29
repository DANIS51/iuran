@extends('layout.officer')

@section('title', 'Tambah Petugas')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-primary">
        <i class="bi bi-plus-circle me-2"></i> Tambah Petugas
    </h2>

    <form action="{{ route('officer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Petugas</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pilih User</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('officer.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
