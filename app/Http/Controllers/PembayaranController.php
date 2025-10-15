<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'jumlah' => 'required|numeric|min:1',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $tarif = (int) $iuran->jumlah;      // contoh: 20000 per periode
        $jumlahBayar = (int) $request->jumlah; // contoh: 10000 / 100000
        $periode = strtolower($iuran->periode); // mingguan / bulanan / tahunan
        $tanggalInput = Carbon::parse($request->tanggal_bayar);

        // Cari pembayaran BELUM LUNAS yang paling awal untuk warga + iuran ini
        $existing = Pembayaran::where('warga_id', $request->warga_id)
            ->where('iuran_id', $request->iuran_id)
            ->where(function($q) {
                $q->where('status', 'belum')
                ->orWhere('status', 'Belum')
                ->orWhere('status', 'Belum Lunas');
            })
            ->orderBy('created_at', 'asc')
            ->first();

        // Helper: function untuk menambah periode pada tanggal
        $addPeriod = function (Carbon $date) use ($periode) {
            if ($periode === 'mingguan') {
                return $date->addWeek();
            } elseif ($periode === 'bulanan') {
                return $date->addMonth();
            } elseif ($periode === 'tahunan' || $periode === 'tahun') {
                return $date->addYear();
            } else {
                // default mingguan jika nilai periode tidak valid
                return $date->addWeek();
            }
        };

        // Jika ada pembayaran BELUM LUNAS sebelumnya -> gabungkan dulu
        if ($existing) {
            $totalSetelah = $existing->jumlah + $jumlahBayar;

            if ($totalSetelah < $tarif) {
                // Masih belum lunas: update record existing, tanggal tetap seperti semula
                $existing->update([
                    'jumlah' => $totalSetelah,
                    'status' => 'belum',
                ]);

                return redirect()->route('pembayaran.index')
                    ->with('success', 'Pembayaran cicilan berhasil ditambahkan. Status: Belum Lunas.');
            }

            // totalSetelah >= tarif -> pelunasan terjadi
            $excess = $totalSetelah - $tarif;

            // Update existing jadi lunas dan set tanggal pelunasan ke tanggal input (pilihanmu: tanggal pelunasan)
            $existing->update([
                'jumlah' => $tarif,
                'status' => 'lunas',
                'tanggal_bayar' => $tanggalInput->format('Y-m-d'),
            ]);

            // Jika ada kelebihan setelah pelunasan, proses kelebihan menjadi record periode berikutnya
            if ($excess > 0) {
                $tanggalNext = $tanggalInput->copy();
                // maju satu periode karena yang sekarang sudah dipakai untuk pelunasan
                $tanggalNext = $addPeriod($tanggalNext);

                $fullPeriods = intdiv($excess, $tarif);
                $remainder = $excess % $tarif;

                for ($i = 0; $i < $fullPeriods; $i++) {
                    Pembayaran::create([
                        'warga_id' => $request->warga_id,
                        'iuran_id' => $request->iuran_id,
                        'tanggal_bayar' => $tanggalNext->format('Y-m-d'),
                        'jumlah' => $tarif,
                        'status' => 'lunas',
                    ]);
                    // maju ke periode selanjutnya
                    $tanggalNext = $addPeriod($tanggalNext);
                }

                if ($remainder > 0) {
                    Pembayaran::create([
                        'warga_id' => $request->warga_id,
                        'iuran_id' => $request->iuran_id,
                        'tanggal_bayar' => $tanggalNext->format('Y-m-d'),
                        'jumlah' => $remainder,
                        'status' => 'belum',
                    ]);
                }
            }

            return redirect()->route('pembayaran.index')
                ->with('success', 'Pembayaran berhasil diproses dan cicilan sebelumnya dilunasi (jika tercapai).');
        }

        // Jika tidak ada existing BELUM LUNAS
        if ($jumlahBayar < $tarif) {
            // Buat 1 record baru sebagai cicilan (belum lunas)
            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalInput->format('Y-m-d'),
                'jumlah' => $jumlahBayar,
                'status' => 'belum',
            ]);

            return redirect()->route('pembayaran.index')
                ->with('success', 'Cicilan tersimpan. Status: Belum Lunas.');
        }

        // Jika bayar >= tarif dan tidak ada existing -> pecah jadi beberapa periode penuh + sisa
        $countFull = intdiv($jumlahBayar, $tarif); // misal: 100000 / 20000 = 5
        $sisa = $jumlahBayar % $tarif;

        $tanggalNow = $tanggalInput->copy();

        for ($i = 0; $i < $countFull; $i++) {
            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalNow->format('Y-m-d'),
                'jumlah' => $tarif,
                'status' => 'lunas',
            ]);

            // maju ke periode berikutnya
            $tanggalNow = $addPeriod($tanggalNow);
        }

        if ($sisa > 0) {
            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalNow->format('Y-m-d'),
                'jumlah' => $sisa,
                'status' => 'belum',
            ]);
        }

        return redirect()->route('pembayaran.index')
            ->with('success', "Pembayaran berhasil dicatat.");
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
