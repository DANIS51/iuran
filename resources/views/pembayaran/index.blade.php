@extends('layout.admin')

@section('title', 'Data Pembayaran')

@section('content')
<div class="card shadow-sm border-0 rounded-4 p-4 bg-white animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-2 mb-md-0">
            <i class="bi bi-receipt-cutoff me-2"></i> Data Pembayaran
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary rounded-3 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
            </a>
            <button type="button" id="btnDeleteSelected" class="btn btn-outline-danger rounded-3 shadow-sm">
                <i class="bi bi-trash me-1"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <form id="deleteForm" action="{{ route('pembayaran.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-primary text-dark">
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>No</th>
                        <th>Nama Warga</th>
                        <th>Iuran</th>
                        <th>Jumlah Bayar</th>
                        <th>Periode</th>
                        <th>Jumlah Periode</th>
                        <th>Tanggal Bayar</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" class="form-check-input checkItem" value="{{ $pembayaran->id }}">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-start">{{ $pembayaran->warga->nama ?? '-' }}</td>
                            <td>{{ $pembayaran->iuran->nama_iuran ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    Rp{{ number_format($pembayaran->iuran->jumlah, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-25 text-dark">
                                    {{ ucfirst($pembayaran->iuran->periode ?? '-') }}
                                </span>
                            </td>
                            <td>{{ $pembayaran->jumlah_periode }}</td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                            <td class="fw-bold text-success">
                                Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($pembayaran->status == 'lunas')
                                    <span class="badge bg-success bg-opacity-75">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->role == 'admin')
                                    <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @else
                                    <a href="{{ route('officer.pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox me-2"></i> Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse

                    {{-- Baris total --}}
                    <tr class="table-secondary fw-bold">
                        <td colspan="6" class="text-end">Total:</td>
                        <td>{{ $totalPeriode }}</td>
                        <td></td>
                        <td>Rp{{ number_format($totalJumlah, 0, ',', '.') }}</td>
                        <td></td>
                        <td></td>
                </tbody>
            </table>
        </div>
    </form>
</div>

{{-- Script Checkbox & Delete --}}
<script>
    // ✅ Centang semua
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
    });

    // ✅ Update status "Check All"
    document.querySelectorAll('.checkItem').forEach(cb => {
        cb.addEventListener('change', function() {
            const all = document.querySelectorAll('.checkItem').length;
            const checked = document.querySelectorAll('.checkItem:checked').length;
            document.getElementById('checkAll').checked = (all === checked);
        });
    });

    // ✅ Hapus terpilih
    document.getElementById('btnDeleteSelected').addEventListener('click', function() {
        const selected = document.querySelectorAll('.checkItem:checked');
        if (selected.length === 0) {
            alert('Pilih data yang ingin dihapus!');
            return;
        }

        if (confirm(`Yakin ingin menghapus ${selected.length} data pembayaran?`)) {
            document.getElementById('deleteForm').submit();
        }
    });
</script>

{{-- Tambahkan animasi CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
