@extends('layout.officer')

@section('title', 'Edit Petugas')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-primary">
        <i class="bi bi-pencil-square me-2"></i> Edit Petugas
    </h2>

    <form action="{{ route('officer.update', $officer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Petugas</label>
            <input type="text" name="name" class="form-control" value="{{ $officer->name }}" required>
        </div>

        <div class="mb-3">
            <label>Pilih User</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $officer->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Perbarui</button>
        <a href="{{ route('officer.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
