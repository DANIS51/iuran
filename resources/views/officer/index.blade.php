@extends('layout.admin')

@section('title', 'Data Petugas')

@section('content')
<div class="card shadow-sm border-0 rounded-4 p-4 bg-white animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-2 mb-md-0">
            <i class="bi bi-person-badge-fill me-2"></i> Daftar Petugas
        </h4>
        <a href="{{ route('officer.create') }}" class="btn btn-primary rounded-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Petugas
        </a>
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Data Petugas --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-primary text-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($officers as $index => $officer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold text-start">{{ $officer->name }}</td>
                    <td>
                        <span class="badge bg-info bg-opacity-25 text-dark px-3 py-2">
                            {{ $officer->user->name ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('officer.edit', $officer->id) }}"
                           class="btn btn-sm btn-outline-warning me-1 rounded-3 shadow-sm"
                           title="Edit Petugas">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('officer.destroy', $officer->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="btn btn-sm btn-outline-danger rounded-3 shadow-sm"
                                onclick="return confirm('Yakin ingin menghapus petugas ini?')"
                                title="Hapus Petugas">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox me-2"></i> Belum ada data petugas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tambahan animasi halus --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
