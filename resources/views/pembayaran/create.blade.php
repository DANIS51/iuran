@extends(isset($isOfficer) && $isOfficer ? 'layout.officer' : 'layout.admin')

@section('title', 'Tambah Pembayaran')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-cash-coin me-2"></i> Tambah Pembayaran
    </h3>

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form action="{{ isset($isOfficer) && $isOfficer ? route('officer.pembayaran.store') : route('pembayaran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="warga_id" class="form-label fw-semibold">Nama Warga</label>
                <select name="warga_id" class="form-select select2" required>
                    <option value="">-- Pilih Warga --</option>
                    @foreach ($wargas as $warga)
                        <option value="{{ $warga->id }}" {{ old('warga_id') == $warga->id ? 'selected' : '' }}>
                            {{ $warga->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="iuran_id" class="form-label fw-semibold">Jenis Iuran</label>
                <select name="iuran_id" class="form-select select2" required>
                    <option value="">-- Pilih Iuran --</option>
                    @foreach ($iurans as $iuran)
                        <option value="{{ $iuran->id }}" {{ old('iuran_id') == $iuran->id ? 'selected' : '' }}>
                            {{ $iuran->nama_iuran }} ({{ $iuran->periode }}) - Rp{{ number_format($iuran->jumlah, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_bayar" class="form-label fw-semibold">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ old('tanggal_bayar') }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_periode" class="form-label fw-semibold">Jumlah Periode</label>
                <input type="number" name="jumlah_periode" class="form-control" value="{{ old('jumlah_periode', 1) }}" min="1" required>
                <small class="form-text text-muted">Masukkan jumlah periode yang ingin dibayar (misal: 1 untuk 1 bulan, 3 untuk 3 bulan).</small>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label fw-semibold">Jumlah Bayar (Rp)</label>
                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}" required>
                <small class="form-text text-muted">Masukkan jumlah yang dibayar. Jika ingin bayar penuh beberapa periode, isi sesuai total (misal: 3 bulan x Rp20.000 = Rp60.000). Bisa juga cicil sebagian.</small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
