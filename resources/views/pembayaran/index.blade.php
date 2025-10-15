@extends('layout.admin')

@section('title', 'Data Pembayaran')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-receipt-cutoff me-2"></i> Data Pembayaran
    </h3>

    {{-- Alert Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tombol Tambah dan Hapus Terpilih --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
        </a>

        <button type="button" id="btnDeleteSelected" class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Hapus Terpilih
        </button>
    </div>

    {{-- Tabel Data --}}
    <form id="deleteForm" action="{{ route('pembayaran.bulkDelete') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="card shadow-sm border-0 rounded-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>
                                All
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>No</th>
                            <th>Nama Warga</th>
                            <th>Iuran</th>
                            <th>jumlah yang harus di bayar </th>
                            <th>Periode</th>
                            <th>Jumlah Periode</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                         </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayarans as $pembayaran)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" class="checkItem" value="{{ $pembayaran->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pembayaran->warga->nama ?? '-' }}</td>
                                <td>{{ $pembayaran->iuran->nama_iuran ?? '-' }}</td>
                                <td>Rp{{ number_format($pembayaran->iuran->jumlah, 0, ',', '.')}}</td>
                                <td>{{ $pembayaran->iuran->periode ?? '-' }}</td>
                                <td>{{ $pembayaran->jumlah_periode }}</td>
                                <td>{{ $pembayaran->tanggal_bayar }}</td>
                                <td>Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if($pembayaran->status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Lunas</span>
                                    @endif
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted">Belum ada data pembayaran.</td>
                            </tr>
                        @endforelse
                        <tr class="table-secondary fw-bold">
                            <td colspan="5" class="text-end">Total:</td>
                            <td>{{ $totalPeriode }}</td>
                            <td></td>
                            <td>Rp{{ number_format($totalJumlah, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

{{-- ✅ SCRIPT CHECKBOX DAN DELETE --}}
<script>
    // Centang / uncentang semua
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
    });

    // Update status checkAll jika sebagian dicentang
    document.querySelectorAll('.checkItem').forEach(cb => {
        cb.addEventListener('change', function() {
            const all = document.querySelectorAll('.checkItem').length;
            const checked = document.querySelectorAll('.checkItem:checked').length;
            document.getElementById('checkAll').checked = (all === checked);
        });
    });

    // Tombol hapus terpilih
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
@endsection
