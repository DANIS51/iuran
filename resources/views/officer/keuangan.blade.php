@extends('layout.officer')

@section('title', 'Data Keuangan')

@section('content')
<div class="container py-4 animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-3 mb-md-0">
            <i class="bi bi-wallet2 me-2"></i> Data Keuangan
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('officer.keuangan.create') }}" class="btn btn-primary shadow-sm rounded-3 px-3">
                <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
            </a>
            <button type="button" id="btnDeleteSelected" class="btn btn-outline-danger shadow-sm rounded-3 px-3">
                <i class="bi bi-trash me-1"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <form id="deleteForm" action="{{ route('officer.keuangan.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead class="bg-light border-bottom">
                            <tr class="text-secondary fw-semibold">
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jumlah (Rp)</th>
                                <th>Keterangan</th>
                                <th>Pembayaran ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keuangans as $index => $k)
                                <tr class="table-row-hover">
                                    <td>
                                        <input type="checkbox" name="ids[]" class="form-check-input checkItem" value="{{ $k->id }}">
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($k->tipe === 'masuk')
                                            <span class="badge bg-success bg-opacity-75 px-3 py-2">Masuk</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-75 px-3 py-2">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="{{ $k->tipe === 'masuk' ? 'text-success fw-semibold' : 'text-danger fw-semibold' }}">
                                        {{ $k->tipe === 'masuk' ? '' : '-' }}Rp{{ number_format($k->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="text-muted">{{ $k->keterangan ?? '-' }}</td>
                                    <td>{{ $k->pembayaran_id ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox me-2"></i> Belum ada data keuangan.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- Baris total --}}
                            <tr class="table-light fw-bold border-top">
                                <td colspan="4" class="text-end">Total Pembayaran:</td>
                                <td colspan="3" class="text-success">
                                    Rp{{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td colspan="4" class="text-end">Total Kas Masuk:</td>
                                <td colspan="3" class="text-success">
                                    Rp{{ number_format($totalMasukKeuangan ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td colspan="4" class="text-end">Total Uang Keluar:</td>
                                <td colspan="3" class="text-danger">
                                    Rp{{ number_format($totalKeluar ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="table-light fw-bold">
                                <td colspan="4" class="text-end">Saldo Akhir:</td>
                                <td colspan="3" class="text-dark">
                                    Rp{{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Checkbox & Delete --}}
<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
    });

    document.querySelectorAll('.checkItem').forEach(cb => {
        cb.addEventListener('change', function() {
            const all = document.querySelectorAll('.checkItem').length;
            const checked = document.querySelectorAll('.checkItem:checked').length;
            document.getElementById('checkAll').checked = (all === checked);
        });
    });

    document.getElementById('btnDeleteSelected').addEventListener('click', function() {
        const selected = document.querySelectorAll('.checkItem:checked');
        if (selected.length === 0) {
            alert('Pilih data yang ingin dihapus!');
            return;
        }

        if (confirm(`Yakin ingin menghapus ${selected.length} data keuangan?`)) {
            document.getElementById('deleteForm').submit();
        }
    });
</script>

{{-- Style tambahan --}}
<style>
    .table-row-hover:hover {
        background-color: #f8f9fa !important;
        transition: 0.2s ease-in-out;
    }
    .badge {
        font-size: 0.85rem;
    }
    .card {
        border-radius: 1rem !important;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
