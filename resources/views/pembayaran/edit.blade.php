@extends('layout.admin')

@section('title', 'Edit Pembayaran')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-pencil-square me-2"></i> Edit Pembayaran
    </h3>

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Warga</label>
                <select name="warga_id" class="form-select" required>
                    @foreach ($wargas as $warga)
                        <option value="{{ $warga->id }}" {{ $pembayaran->warga_id == $warga->id ? 'selected' : '' }}>
                            {{ $warga->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Iuran</label>
                <select name="iuran_id" class="form-select" required>
                    @foreach ($iurans as $iuran)
                        <option value="{{ $iuran->id }}" {{ $pembayaran->iuran_id == $iuran->id ? 'selected' : '' }}>
                            {{ $iuran->nama_iuran }} ({{ $iuran->periode }}) - Rp{{ number_format($iuran->jumlah, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ $pembayaran->tanggal_bayar }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah Bayar (Rp)</label>
                <input type="number" name="jumlah" class="form-control" value="{{ $pembayaran->jumlah }}" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Update Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
