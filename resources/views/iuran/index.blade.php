@extends('layout.admin')

@section('title', 'Data Iuran')

@section('content')
<div class="card shadow-sm border-0 rounded-4 p-4 bg-white animate__animated animate__fadeIn">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-2 mb-md-0">
            <i class="bi bi-wallet2 me-2"></i> Daftar Iuran
        </h4>
        <a href="{{ route('iuran.create') }}" class="btn btn-primary rounded-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Iuran
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Data Iuran --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-primary text-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Iuran</th>
                    <th>Jumlah</th>
                    <th>Periode</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($iurans as $index => $iuran)
                <tr class="align-middle">
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold text-start">{{ $iuran->nama_iuran }}</td>
                    <td>
                        <span class="badge bg-success bg-opacity-25 text-success px-3 py-2">
                            Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info text-dark">{{ ucfirst($iuran->periode) }}</span>
                    </td>
                    <td class="text-muted">{{ $iuran->keterangan ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('iuran.edit', $iuran->id) }}" 
                           class="btn btn-sm btn-outline-warning me-1 rounded-3 shadow-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('iuran.destroy', $iuran->id) }}" 
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 shadow-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox me-2"></i> Belum ada data iuran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tambahan animasi halus (gunakan animate.css) --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
