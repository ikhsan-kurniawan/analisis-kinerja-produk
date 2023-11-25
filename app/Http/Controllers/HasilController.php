<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AnalisisController;
use App\Models\Hasil;
use App\Models\HasilDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::orderBy('created_at', 'desc')->get();

        return view('hasil.index', [
            'title' => 'Hasil Analisis',
            'header' => 'Hasil Analisis',
            'hasil' => $hasil,
        ]);
    }
    public function store(Request $request)
    {
        // Ambil data dari sesi
        $hasil_peringkat = Session::get('hasil_peringkat');

        // Buat nilai periode
        $periode = $request->tahun . '-' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT) . '-01'; // Misalnya: "2023-12"

        // Simpan data ke database
        $hasil = Hasil::create([
            'periode' => $periode,
        ]);

        foreach ($hasil_peringkat as $item) {
            HasilDetail::create([
                'id_hasil' => $hasil->id,
                'kode_barang' => $item['kode_barang'],
                'nama_barang' => $item['nama_barang'],
                'peringkat' => $item['peringkat'],
            ]);
        }

        // Hapus data dari sesi setelah disimpan
        Session::forget('hasil_peringkat');

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('hasil.index')->with('message', 'Hasil analisis berhasil disimpan');
    }

    public function show(AnalisisController $analisisController, $id)
    {
        $hasil = Hasil::with('hasilDetail')->findOrFail($id);

        $bulan_tertulis = $analisisController->terbilang(Carbon::parse($hasil->periode)->format('m'));

        return view('hasil.show', [
            'title' => 'Hasil Analisis',
            'header' => 'Hasil Analisis Periode: ' . $bulan_tertulis . ' ' . Carbon::parse($hasil->periode)->format('Y'),
            'hasil' => $hasil,
        ]);
    }

    public function destroy($id)
    {
        // Menghapus hasil_detail yang terkait
        HasilDetail::where('id_hasil', $id)->delete();

        // Menghapus hasil
        Hasil::destroy($id);

        // Redirect atau memberikan respons sesuai kebutuhan
        return redirect()->route('hasil.index')->with('message', 'Data berhasil dihapus.');
    }
}
