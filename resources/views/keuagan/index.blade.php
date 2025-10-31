@extends('layout.admin')

@section('title', 'Data Keuangan')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-wallet2 me-2"></i> Data Keuangan
    </h3>

    {{-- Alert Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('keuangan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
            </a>
        </div>
        <div class="text-end">
            <small class="text-muted">Breakdown: Pembayaran = Rp{{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}; Kas Masuk = Rp{{ number_format($totalMasukKeuangan ?? 0, 0, ',', '.') }}; Net Keuangan = Rp{{ number_format($keuanganNet ?? 0, 0, ',', '.') }}</small>
        </div>
    </div>

    {{-- Tabel Keuangan --}}
    <form action="{{ route('keuangan.bulkDelete') }}" method="POST" id="bulkDeleteForm" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        @csrf
        @method('DELETE')
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-primary">
                        <tr>
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
                            <tr>
                                <td><input type="checkbox" name="ids[]" class="form-check-input checkItem" value="{{ $k->id }}"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($k->tipe === 'masuk')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-danger">Keluar</span>
                                    @endif
                                </td>
                                <td class="{{ $k->tipe === 'masuk' ? 'text-success' : 'text-danger' }}">
                                    @if ($k->tipe === 'masuk')
                                        Rp{{ number_format($k->jumlah, 0, ',', '.') }}
                                    @else
                                        -Rp{{ number_format($k->jumlah, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                                <td>{{ $k->pembayaran_id ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data keuangan.</td>
                        @endforelse
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger mt-2" id="bulkDeleteBtn" disabled>Hapus Terpilih</button>
            </div>
        </div>
    </form>
    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            let checked = this.checked;
            document.querySelectorAll('.checkItem').forEach(function(cb) {
                cb.checked = checked;
            });
            document.getElementById('bulkDeleteBtn').disabled = !checked && document.querySelectorAll('.checkItem:checked').length === 0;
        });
        document.querySelectorAll('.checkItem').forEach(function(cb) {
            cb.addEventListener('change', function() {
                let anyChecked = document.querySelectorAll('.checkItem:checked').length > 0;
                document.getElementById('bulkDeleteBtn').disabled = !anyChecked;
            });
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total Pembayaran (masuk):</th>
                        <th colspan="4" class="text-success">
                            Rp{{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total Kas Masuk:</th>
                        <th colspan="4" class="text-success">
                            Rp{{ number_format($totalMasukKeuangan ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total Uang Keluar:</th>
                        <th colspan="4" class="text-danger">
                            Rp{{ number_format($totalKeluar, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr class="fw-bold table-primary">
                        <th colspan="3" class="text-end">Saldo Akhir:</th>
                        <th colspan="4" class="text-dark">
                            Rp{{ number_format($saldoAkhir, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
