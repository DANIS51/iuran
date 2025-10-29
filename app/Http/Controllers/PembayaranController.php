<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // ===================== INDEX =====================
    public function index()
    {
        $pembayarans = Pembayaran::with(['warga', 'iuran'])->get();
        $totalJumlah = $pembayarans->sum('jumlah');
        $totalPeriode = $pembayarans->sum('jumlah_periode');

        // Cek role user
        if(Auth::user()->role == 'officer') {
            return view('officer.pembayaran', compact('pembayarans', 'totalJumlah', 'totalPeriode'));
        }

        return view('pembayaran.index', compact('pembayarans', 'totalJumlah', 'totalPeriode'));
    }

    // ===================== CREATE =====================
    public function create()
    {
        $wargas = Warga::all();
        $iurans = Iuran::all();
        $isOfficer = Auth::user() && Auth::user()->role === 'officer';
        return view('pembayaran.create', compact('wargas', 'iurans', 'isOfficer'));
    }

    // ===================== STORE =====================

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'iuran_id' => 'required|exists:iurans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_periode' => 'required|integer|min:1',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $jumlahPeriode = (int) $request->jumlah_periode;

        $iuran = Iuran::findOrFail($request->iuran_id);
        $tarif = (int) $iuran->jumlah;
        $jumlahBayar = (int) $request->jumlah;
        $tanggalInput = Carbon::parse($request->tanggal_bayar);

        // Hitung total yang harus dibayar untuk jumlah periode
        $totalHarusBayar = $jumlahPeriode * $tarif;

        // Validasi: jumlah bayar tidak boleh melebihi total yang harus dibayar
        if ($jumlahBayar > $totalHarusBayar) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah bayar tidak boleh melebihi total yang harus dibayar untuk jumlah periode tersebut (Rp' . number_format($totalHarusBayar, 0, ',', '.') . ')!');
        }

        // Cari pembayaran BELUM LUNAS yang paling awal untuk warga + iuran ini
        $existing = Pembayaran::where('warga_id', $request->warga_id)
            ->where('iuran_id', $request->iuran_id)
            ->where('status', 'belum')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($existing) {
            // Gabungkan dengan existing
            $newJumlah = $existing->jumlah + $jumlahBayar;
            $newJumlahPeriode = $existing->jumlah_periode + $jumlahPeriode;
            $newTotalHarus = $newJumlahPeriode * $tarif;

            // Validasi total gabungan tidak melebihi yang harus dibayar
            if ($newJumlah > $newTotalHarus) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Total pembayaran setelah digabungkan melebihi yang harus dibayar untuk jumlah periode tersebut (Rp' . number_format($newTotalHarus, 0, ',', '.') . ')!');
            }

            $status = $newJumlah >= $newTotalHarus ? 'lunas' : 'belum';

            $existing->update([
                'jumlah' => $newJumlah,
                'jumlah_periode' => $newJumlahPeriode,
                'status' => $status,
                'tanggal_bayar' => $tanggalInput->format('Y-m-d'),
            ]);

            $isOfficer = Auth::user() && Auth::user()->role === 'officer';
            $redirect = $isOfficer ? route('officer.pembayaran') : route('pembayaran.index');
            return redirect($redirect)
                ->with('success', 'Pembayaran berhasil ditambahkan ke cicilan sebelumnya.');
        } else {
            // Buat record baru
            $status = $jumlahBayar >= $totalHarusBayar ? 'lunas' : 'belum';

            Pembayaran::create([
                'warga_id' => $request->warga_id,
                'iuran_id' => $request->iuran_id,
                'tanggal_bayar' => $tanggalInput->format('Y-m-d'),
                'jumlah' => $jumlahBayar,
                'status' => $status,
                'jumlah_periode' => $jumlahPeriode,
            ]);

            $isOfficer = Auth::user() && Auth::user()->role === 'officer';
            $redirect = $isOfficer ? route('officer.pembayaran') : route('pembayaran.index');
            return redirect($redirect)
                ->with('success', 'Pembayaran berhasil dicatat.');
        }
    }



    // ===================== EDIT =====================
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $wargas = Warga::all();
        $iurans = Iuran::all();
        $isOfficer = Auth::user() && Auth::user()->role === 'officer';
        return view('pembayaran.edit', compact('pembayaran', 'wargas', 'iurans', 'isOfficer'));
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
            'jumlah_periode' => 'required|integer|min:1',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $tarif = (int) $iuran->jumlah;
        $jumlahPeriode = (int) $request->jumlah_periode;
        $totalHarusBayar = $jumlahPeriode * $tarif;
        $jumlahBaru = (int) $request->jumlah;

        // Jika jumlah bayar melebihi total yang harus dibayar untuk periode tersebut
        if ($jumlahBaru > $totalHarusBayar) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah bayar melebihi total yang harus dibayar untuk jumlah periode tersebut!');
        }

        // Tentukan status otomatis
        $status = $jumlahBaru >= $totalHarusBayar ? 'lunas' : 'belum';

        $pembayaran->update([
            'warga_id' => $request->warga_id,
            'iuran_id' => $request->iuran_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah' => $jumlahBaru,
            'status' => $status,
            'jumlah_periode' => $jumlahPeriode,
        ]);

        $isOfficer = Auth::user() && Auth::user()->role === 'officer';
        $redirect = $isOfficer ? route('officer.pembayaran') : route('pembayaran.index');
        return redirect($redirect)->with('success', 'Pembayaran berhasil diperbarui.');
    }

    // ===================== DESTROY =====================
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        $isOfficer = Auth::user() && Auth::user()->role === 'officer';
        $redirect = $isOfficer ? route('officer.pembayaran') : route('pembayaran.index');
        return redirect($redirect)
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
