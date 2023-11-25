<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Hasil;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $aset = Asset::get();
        $total_aset = DB::table('v_total_aset')->selectRaw("CAST(total_nilai_aset AS SIGNED) as total_nilai_aset")->first();
        $kriteria = Kriteria::get();
        $hasil = Hasil::get();

        $aset = $aset->map(function ($item) {
            $item['nilai'] = $item['nilai'] - ($item['nilai'] * $item['penyusutan'] / 100);
            return [
                'id' => $item['id'],
                'nama' => $item['nama'],
                'nilai' => $item['nilai'],
            ];
        });

        return view('dashboard', [
            'title' => 'Dashboard',
            'header' => 'Dashboard',
            'aset' => $aset,
            'total_aset' => $total_aset,
            'kriteria' => $kriteria,
            'hasil' => $hasil,
        ]);
    }
}
