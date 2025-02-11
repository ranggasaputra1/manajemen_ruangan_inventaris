<?php

namespace App\Http\Controllers;

use App\Models\DataPeminjaman;
use App\Models\DataBarang;
use App\Models\DataRuangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DataPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = DataPeminjaman::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_peminjam', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
        }
        
        $dataPeminjaman = $query->orderBy('created_at', 'desc')->get();

        return view('dashboard.peminjaman.index', [
            "tittle" => "Daftar Peminjaman",
            "active_menu" => "peminjaman",
            'dataPeminjaman' => $dataPeminjaman
        ]);
    }

    public function create()
    {
        return view('dashboard.peminjaman.create', [
            "tittle" => "Tambah Peminjaman",
            "active_menu" => "peminjaman",
            'dataBarangs' => DataBarang::all(),
            'dataRuangan' => DataRuangan::all()
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'tgl_peminjaman' => 'required|date',
        'tgl_pengembalian' => 'required|date',
        'nama_peminjam' => 'required|string',
        'kode_barang' => 'nullable|array',
        'kode_ruangan' => 'nullable|array',
        'jumlah' => 'nullable',
        'status' => 'required|string',
    ]);

    // Kurangi stok barang
    if ($request->has('kode_barang')) {
        foreach ($request->kode_barang as $barangId) {
            $barang = DataBarang::find($barangId);
            if ($barang && $barang->jumlah_barang < $request->jumlah) {
                return redirect()->back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.']);
            }
            if ($barang) {
                $barang->jumlah_barang -= $request->jumlah;
                $barang->save();
            }
        }
    }

    DataPeminjaman::create([
        'tgl_peminjaman' => $request->tgl_peminjaman,
        'tgl_pengembalian' => $request->tgl_pengembalian,
        'nama_peminjam' => $request->nama_peminjam,
        'kode_barang' => $request->kode_barang ? json_encode($request->kode_barang) : null,
        'kode_ruangan' => $request->kode_ruangan ? json_encode($request->kode_ruangan) : null,
        'jumlah' => $request->jumlah,
        'status' => $request->status,
    ]);

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
}

public function show($id)
{
    $peminjaman = DataPeminjaman::with(['dataBarang', 'dataRuangan'])->findOrFail($id);

    return view('dashboard.peminjaman.show', [
        'tittle' => 'Detail Peminjaman',
        'active_menu' => 'peminjaman',
        'peminjaman' => $peminjaman
    ]);
}


    public function edit($id)
    {
        $peminjaman = DataPeminjaman::findOrFail($id);
        $dataBarangs = DataBarang::all();
        $dataRuangan = DataRuangan::all();

        return view('dashboard.peminjaman.edit', [
            'tittle' => 'Edit Peminjaman',
            'active_menu' => 'peminjaman',
            'peminjaman' => $peminjaman,
            'dataBarangs' => $dataBarangs,
            'dataRuangan' => $dataRuangan
        ]);
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'tgl_peminjaman' => 'required|date',
        'tgl_pengembalian' => 'required|date',
        'nama_peminjam' => 'required|string|max:255',
        'kode_barang' => 'nullable|array',
        'kode_ruangan' => 'nullable|array',
        'jumlah' => 'nullable|integer|min:1',
        'status' => 'required|string|max:255',
    ]);

    $peminjaman = DataPeminjaman::findOrFail($id);

    // Decode data barang dan ruangan lama
    $oldKodeBarang = $peminjaman->kode_barang ? json_decode($peminjaman->kode_barang) : [];
    $newKodeBarang = $request->kode_barang ?? [];

    // Mengembalikan stok barang lama sebelum update
    foreach ($oldKodeBarang as $barangId) {
        $barang = DataBarang::find($barangId);
        if ($barang) {
            $barang->jumlah_barang += $peminjaman->jumlah;
            $barang->save();
        }
    }

    // Kurangi stok barang jika ada barang baru yang dipinjam
    foreach ($newKodeBarang as $barangId) {
        $barang = DataBarang::find($barangId);
        if ($barang && $barang->jumlah_barang < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.']);
        }
        if ($barang) {
            $barang->jumlah_barang -= $request->jumlah;
            $barang->save();
        }
    }

    // Jika status 'Dikembalikan', ubah status sebelum menghapus data
    if ($request->status === 'Dikembalikan') {
        // Simpan perubahan status sebelum dihapus
        $peminjaman->update([
            'status' => 'Dikembalikan'
        ]);

        // Mengembalikan stok barang
        foreach ($newKodeBarang as $barangId) {
            $barang = DataBarang::find($barangId);
            if ($barang) {
                $barang->jumlah_barang += $request->jumlah;
                $barang->save();
            }
        }

        // Hapus data setelah status diperbarui
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman dikembalikan dan dicatat dalam riwayat.');
    }

    // Jika masih dalam status lain, update data
    $peminjaman->update([
        'tgl_peminjaman' => $request->tgl_peminjaman,
        'tgl_pengembalian' => $request->tgl_pengembalian,
        'nama_peminjam' => $request->nama_peminjam,
        'kode_barang' => $newKodeBarang ? json_encode($newKodeBarang) : null,
        'kode_ruangan' => $request->kode_ruangan ? json_encode($request->kode_ruangan) : null,
        'jumlah' => $request->jumlah,
        'status' => $request->status, // Pastikan status tetap diperbarui
    ]);

    return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
}

    public function printSingle($id)
    {
        
        $peminjaman = DataPeminjaman::with(['dataBarang', 'dataRuangan'])->findOrFail($id);

        
        $pdf = Pdf::loadView('dashboard.peminjaman.print_single', compact('peminjaman'));

        return $pdf->stream('peminjaman.pdf');
    }

    public function print(Request $request, $sort_by)
{
    $query = DataPeminjaman::query();

    // Handle sorting
    if ($sort_by === 'newest') {
        $query->orderBy('tgl_peminjaman', 'desc');
    } elseif ($sort_by === 'oldest') {
        $query->orderBy('tgl_peminjaman', 'asc');
    } else {
        $query->orderBy('tgl_peminjaman', 'desc');
    }

    // Ambil data dengan relasi
    $dataPeminjamen = $query->with(['dataBarang', 'dataRuangan'])->get();

    // Kirim ke PDF
    $pdf = Pdf::loadView('dashboard.peminjaman.print', compact('dataPeminjamen'));
    return $pdf->stream('peminjaman.pdf');
}

    public function history()
    {
        return view('dashboard.peminjaman.history', [
            "tittle" => "Riwayat Peminjaman",
            "active_menu" => "peminjaman",
            'dataHistories' => DataPeminjaman::onlyTrashed()->get()
        ]);
    }

    public function destroy($id)
{
    $peminjaman = DataPeminjaman::findOrFail($id);

    // Dekode kode_barang dari JSON agar bisa digunakan dalam foreach
    $kodeBarangList = json_decode($peminjaman->kode_barang, true) ?? [];

    if (!empty($kodeBarangList)) {
        foreach ($kodeBarangList as $barang_id) {
            $barang = DataBarang::find($barang_id);
            if ($barang) {
                $barang->jumlah_barang += $peminjaman->jumlah ?? 0;
                $barang->save();
            }
        }
    }

    // Hapus data peminjaman
    $peminjaman->delete(); // Gunakan delete() untuk soft delete

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman dihapus dan stok barang diperbarui.');
}

    public function printHistory(Request $request, $sort_by)
    {
        $query = DataPeminjaman::onlyTrashed();
    
        // Handle sorting
        if ($sort_by === 'newest') {
            $query->orderBy('deleted_at', 'desc');
        } elseif ($sort_by === 'oldest') {
            $query->orderBy('deleted_at', 'asc');
        }
    
        $dataHistories = $query->with(['dataBarang', 'dataRuangan'])->get();
    
        $pdf = Pdf::loadView('dashboard.peminjaman.history_print', compact('dataHistories'));
        return $pdf->stream('history_peminjaman.pdf');
    }
    
}
