@extends('layout.admin')

@section('title', 'Data Petugas')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-primary">
        <i class="bi bi-person-badge-fill me-2"></i> Data Petugas
    </h2>

    <a href="{{ route('officer.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Petugas
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($officers as $index => $officer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $officer->name }}</td>
                <td>{{ $officer->user->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('officer.edit', $officer->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('officer.destroy', $officer->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
