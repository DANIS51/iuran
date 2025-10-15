<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // ===================== INDEX =====================
    public function index()
    {
        $pembayarans = Pembayaran::with(['warga', 'iuran'])->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    // ===================== CREATE =====================
    public function create()
    {
        $wargas = Warga::all();
        $iurans = Iuran::all();
        return view('pembayaran.create', compact('wargas', 'iurans'));
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'iuran_id' => 'required|exists:iurans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric|min:100',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $tarif = (int) $iuran->jumlah;     // contoh: 20000
        $jumlahBayar = (int) $request->jumlah; // contoh: 100000
        $periode = $iuran->periode;       // mingguan / bulanan / tahunan
        $tanggalBase = \Carbon\Carbon::parse($request->tanggal_bayar);

        if ($jumlahBayar < $tarif) {
            return back()->with('error', 'Jumlah pembayaran tidak boleh kurang dari tarif iuran.');
        }

        // Hitung berapa kali pembayaran
        $jumlahKali = intdiv($jumlahBayar, $tarif); // misal: 100000 / 20000 = 5
        $sisa = $jumlahBayar % $tarif; // misal: 0

        $tanggalSekarang = $tanggalBase->copy();

        for ($i = 0; $i < $jumlahKali; $i++) {
            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalSekarang->format('Y-m-d'),
                'jumlah' => $tarif,
                'status' => 'lunas',
            ]);

            // // Tambah tanggal berdasarkan periode
            // if ($periode === 'mingguan') {
            //     $tanggalSekarang->addWeek();
            // } elseif ($periode === 'bulanan') {
            //     $tanggalSekarang->addMonth();
            // } elseif ($periode === 'tahunan') {
            //     $tanggalSekarang->addYear();
            // }
        }

        // Kalau ada sisa uang (tidak genap tarif)
        if ($sisa > 0) {
            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalSekarang->format('Y-m-d'),
                'jumlah' => $sisa,
                'status' => 'belum',
            ]);
        }

        return redirect()->route('pembayaran.index')
            ->with('success', "Pembayaran berhasil dicatat sebanyak {$jumlahKali} kali.");
    }

    // ===================== EDIT =====================
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $wargas = Warga::all();
        $iurans = Iuran::all();
        return view('pembayaran.edit', compact('pembayaran', 'wargas', 'iurans'));
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'iuran_id' => 'required|exists:iurans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric|min:100',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $totalIuran = (int) $iuran->jumlah;

        // Hitung total pembayaran sebelumnya (kecuali yang sedang diedit)
        $totalBayarSebelumnya = Pembayaran::where('warga_id', $request->warga_id)
            ->where('iuran_id', $request->iuran_id)
            ->where('id', '!=', $id)
            ->sum('jumlah');

        $jumlahBaru = (int) $request->jumlah;
        $totalBayarBaru = $totalBayarSebelumnya + $jumlahBaru;

        // Jika total melebihi iuran
        if ($totalBayarBaru > $totalIuran) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Total pembayaran melebihi jumlah iuran yang harus dibayar!');
        }

        // Tentukan status otomatis
        $status = $totalBayarBaru >= $totalIuran ? 'Lunas' : 'Belum Lunas';

        $pembayaran->update([
            'warga_id' => $request->warga_id,
            'iuran_id' => $request->iuran_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah' => $jumlahBaru,
            'status' => $status,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    // ===================== DESTROY =====================
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
