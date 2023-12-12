<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AnalisisController extends Controller
{
    public function index()
    {
        return view('analisis.index', [
            'title' => 'Analisis',
            'header' => 'Analisis',
        ]);
    }

    public function getData($tahun, $bulan)
    {
        $bulanSebelum = $bulan - 1;
        $tahunSebelum = $tahun;
        if ($bulanSebelum == 0) {
            $bulanSebelum = 12;
            $tahunSebelum--;
        }

        // fetch data untuk roa, gm, re
        $data = DB::connection('barang_mysql')->table('t_gm')
            ->select('kode_barang', 'nama_barang', 'sub_harga', 'sub_harga_beli', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(laba) as total_laba'))
            ->whereYear('tanggal_transaksi_penjualan', '=', $tahun)
            ->whereMonth('tanggal_transaksi_penjualan', '=', $bulan)
            ->where('sub_harga_beli', '!=', 0)
            ->groupBy('kode_barang')
            ->get();

        // fetch data untuk ito
        $barang_keluar_masuk = DB::connection('barang_mysql')->table('barang_keluar_masuk')
            ->whereYear('periode', '=', $tahun)
            ->whereMonth('periode', '=', $bulan)
            ->get();

        // rumus ito
        $ito = $barang_keluar_masuk->map(function ($item) {
            if (($item->stock_awal_bulan + $item->stock_akhir_bulan) <= 0) {
                return null;
            }

            $ito = $item->jumlah_penjualan / (($item->stock_awal_bulan + $item->stock_akhir_bulan) / 2);

            return [
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'ito' => $ito,
            ];
        })->filter();

        // rumus roa, gm, re
        $total_aset = DB::table('v_total_aset')->first()->total_nilai_aset;
        $data = $data->map(function ($item) use ($total_aset) {
            $gm = ($item->total_laba / ($item->sub_harga * $item->total_qty)) * 100;
            $roa = ($item->total_laba / (($item->sub_harga_beli * $item->total_qty) + $total_aset)) * 100;
            $re = ($item->total_qty * $item->sub_harga_beli) / ($item->total_qty * $item->sub_harga) * 100;

            return [
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'roa' => $roa,
                'gm' => $gm,
                'ito' => null,
                're' => $re,
            ];
        });

        // menggabungkan $data dengan $ito
        $data_gabung = $data->map(function ($item) use ($ito) {
            $matchingIto = $ito->firstWhere('kode_barang', $item['kode_barang']);
            if ($matchingIto) {
                $item['ito'] = $matchingIto['ito'];
            }

            return $item;
        });

        // menghapus data yang ito = null
        $data_gabung = $data_gabung->filter(function ($item) {
            return !is_null($item['ito']);
        });

        return $data_gabung;
    }

    public function loadData(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $data = $this->getData($tahun, $bulan);

        // kirim JSON:
        // return response()->json($data);
        // return response()->json(['data' => $data]);

        // kirim HTML:
        return view('analisis._load-data', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function hitung(Request $request, $bulan, $tahun)
    {
        // Membuatkan bulan menjadi tertulis
        $bulan_tertulis = $this->terbilang($bulan);

        // fetch kriteria
        $kriteria = Kriteria::get();

        // $data = $this->getData($request->tahun, $request->bulan);
        $data = $this->getData($tahun, $bulan);

        // $data = collect([
        //     [
        //         'kode_barang' => '8850007090267',
        //         'nama_barang' => 'JB Bath Milk+Rice Hair & Body Ref 400ml',
        //         'roa' => 6.90,
        //         'gm' => 6.45,
        //         'ito' => 2.00,
        //         're' => 93.55,
        //     ],
        //     [
        //         'kode_barang' => '8992222051729',
        //         'nama_barang' => 'Gatsby Styling Wax Power&Spikes 75g',
        //         'roa' => 49.15,
        //         'gm' => 32.95,
        //         'ito' => 1.00,
        //         're' => 67.05,
        //     ],
        //     [
        //         'kode_barang' => '8992222071130',
        //         'nama_barang' => 'Pixy PF Ref Natural 06',
        //         'roa' => 63.40,
        //         'gm' => 38.80,
        //         'ito' => 2.00,
        //         're' => 61.20,
        //     ],
        //     [
        //         'kode_barang' => '8992222073264',
        //         'nama_barang' => 'Pixy Aqua Beauty Mist 60ml',
        //         'roa' => 44.24,
        //         'gm' => 30.67,
        //         'ito' => 2.00,
        //         're' => 69.33,
        //     ],
        //     [
        //         'kode_barang' => '8992222073714',
        //         'nama_barang' => 'Pixy TWC PL Fair Ochre 01',
        //         'roa' => 52.06,
        //         'gm' => 34.24,
        //         'ito' => 2.00,
        //         're' => 65.76,
        //     ],
        //     [
        //         'kode_barang' => '8992222074254',
        //         'nama_barang' => 'Pixy FW White Aqua 100g',
        //         'roa' => 39.23,
        //         'gm' => 28.18,
        //         'ito' => 2.00,
        //         're' => 71.82,
        //     ],
        //     [
        //         'kode_barang' => '8992222093057',
        //         'nama_barang' => 'Pucelle EDL Victress 150ml',
        //         'roa' => 26.46,
        //         'gm' => 20.93,
        //         'ito' => 4.00,
        //         're' => 79.07,
        //     ],
        //     [
        //         'kode_barang' => '8992222282758',
        //         'nama_barang' => 'Pixy Lipcream 06 Bold Maroon',
        //         'roa' => 58.39,
        //         'gm' => 36.87,
        //         'ito' => 2.00,
        //         're' => 63.13,
        //     ],
        //     [
        //         'kode_barang' => '8992304009167',
        //         'nama_barang' => 'Garnier Men FF OC Cooling 100ml',
        //         'roa' => 43.78,
        //         'gm' => 30.45,
        //         'ito' => 0.86,
        //         're' => 69.55,
        //     ],
        //     [
        //         'kode_barang' => '8992304009204',
        //         'nama_barang' => 'Garnier Men FF OC Icy Scrub 100ml',
        //         'roa' => 43.78,
        //         'gm' => 30.45,
        //         'ito' => 0.67,
        //         're' => 69.55,
        //     ],
        //     [
        //         'kode_barang' => '8992304015298',
        //         'nama_barang' => 'Garnier Men FF Acno Scrub 100ml',
        //         'roa' => 43.78,
        //         'gm' => 30.45,
        //         'ito' => 0.33,
        //         're' => 69.55,
        //     ],
        //     [
        //         'kode_barang' => '8992304039614',
        //         'nama_barang' => 'Garnier Men FF Acno Wasabi 100ml',
        //         'roa' => 45.92,
        //         'gm' => 31.47,
        //         'ito' => 4.00,
        //         're' => 68.53,
        //     ],
        //     [
        //         'kode_barang' => '8992696405578',
        //         'nama_barang' => 'Dancow 1+ Madu 400g',
        //         'roa' => 9.69,
        //         'gm' => 8.84,
        //         'ito' => 3.00,
        //         're' => 91.25,
        //     ],
        //     [
        //         'kode_barang' => '8992696407039',
        //         'nama_barang' => 'Dancow 3+ Madu 350g',
        //         'roa' => 11.40,
        //         'gm' => 10.24,
        //         'ito' => 12.00,
        //         're' => 89.76,
        //     ],
        //     [
        //         'kode_barang' => '8992696407725',
        //         'nama_barang' => 'Dancow 5+ Madu 350g',
        //         'roa' => 12.56,
        //         'gm' => 11.16,
        //         'ito' => 6.00,
        //         're' => 88.84,
        //     ],
        //     [
        //         'kode_barang' => '8992696407831',
        //         'nama_barang' => 'Dancow 5+ Cokelat 750g',
        //         'roa' => 23.29,
        //         'gm' => 18.89,
        //         'ito' => 1.00,
        //         're' => 81.11,
        //     ],
        //     [
        //         'kode_barang' => '8992696427990',
        //         'nama_barang' => 'Milo ActivGo Pouch 800g',
        //         'roa' => 7.43,
        //         'gm' => 6.92,
        //         'ito' => 2.00,
        //         're' => 93.08,
        //     ],
        //     [
        //         'kode_barang' => '8992796011501',
        //         'nama_barang' => 'Viva Air Mawar 100ml',
        //         'roa' => 34.78,
        //         'gm' => 25.81,
        //         'ito' => 4.18,
        //         're' => 74.19,
        //     ],
        //     [
        //         'kode_barang' => '8992802016636',
        //         'nama_barang' => 'Milna BB Salmon CB 8-12bln 120g',
        //         'roa' => 11.31,
        //         'gm' => 10.16,
        //         'ito' => 10.00,
        //         're' => 89.84,
        //     ],
        //     [
        //         'kode_barang' => '8992802045025',
        //         'nama_barang' => 'Zee Swizz Choco 900g',
        //         'roa' => 21.56,
        //         'gm' => 17.73,
        //         'ito' => 2.00,
        //         're' => 82.27,
        //     ],
        // ]);

        // menghitung kuadrat dari masing-masing kriteria pada alternatif
        $data_kuadrat = $data->map(function ($item) {
            $item['roa'] = pow($item['roa'], 2);
            $item['gm'] = pow($item['gm'], 2);
            $item['ito'] = pow($item['ito'], 2);
            $item['re'] = pow($item['re'], 2);
            return $item;
        });

        // menghitung bobot perhitungan berdasarkan alternatif
        $bobot_perhitungan = collect([
            'roa' => sqrt($data_kuadrat->sum('roa')),
            'gm' => sqrt($data_kuadrat->sum('gm')),
            'ito' => sqrt($data_kuadrat->sum('ito')),
            're' => sqrt($data_kuadrat->sum('re')),
        ]);

        // membuat matriks keputusan ternormalisasi
        $normalisasi = $data->map(function ($item) use ($bobot_perhitungan) {
            return [
                'kode_barang' => $item['kode_barang'],
                'nama_barang' => $item['nama_barang'],
                'roa' => $item['roa'] / $bobot_perhitungan['roa'],
                'gm' => $item['gm'] / $bobot_perhitungan['gm'],
                'ito' => $item['ito'] / $bobot_perhitungan['ito'],
                're' => $item['re'] / $bobot_perhitungan['re'],
            ];
        });

        // membuat matriks keputusan ternomalisasi dan terbobot
        $normalisasi_terbobot = $normalisasi->map(function ($item) use ($kriteria) {
            return [
                'kode_barang' => $item['kode_barang'],
                'nama_barang' => $item['nama_barang'],
                'roa' => $item['roa'] * $kriteria->where('abbr', 'roa')->first()['bobot'],
                'gm' => $item['gm'] * $kriteria->where('abbr', 'gm')->first()['bobot'],
                'ito' => $item['ito'] * $kriteria->where('abbr', 'ito')->first()['bobot'],
                're' => $item['re'] * $kriteria->where('abbr', 're')->first()['bobot'],
            ];
        });

        // membuat matriks solusi ideal positif dan negatif
        $idealPositif = collect([]);
        $idealNegatif = collect([]);

        $kriteria->each(function ($k) use ($normalisasi_terbobot, &$idealPositif, &$idealNegatif) {
            $atribut = $k['atribut'];
            $abbr = $k['abbr'];

            if ($atribut === 'benefit') {
                // Untuk kriteria benefit, pilih nilai tertinggi sebagai A+ dan nilai terendah sebagai A-
                $maxValue = $normalisasi_terbobot->max($abbr);
                $minValue = $normalisasi_terbobot->min($abbr);
            } elseif ($atribut === 'cost') {
                // Untuk kriteria cost, pilih nilai terendah sebagai A+ dan nilai tertinggi sebagai A-
                $maxValue = $normalisasi_terbobot->min($abbr);
                $minValue = $normalisasi_terbobot->max($abbr);
            }
            $idealPositif->put($abbr, $maxValue);
            $idealNegatif->put($abbr, $minValue);
        });

        // Menghitung nilai D+ (nilai kedekatan positif) dan D- (nilai kedekatan negatif) untuk setiap alternatif
        $hasilKedekatan = $normalisasi_terbobot->map(function ($alternatif) use ($kriteria, $idealPositif, $idealNegatif) {
            $nilaiDPlus = 0;
            $nilaiDMinus = 0;

            $kriteria->each(function ($k) use ($alternatif, $idealPositif, $idealNegatif, &$nilaiDPlus, &$nilaiDMinus) {
                $atribut = $k['atribut'];
                $abbr = $k['abbr'];
                $nilaiAlternatif = $alternatif[$abbr];

                // Perhitungan nilai D+
                $nilaiDPlus += pow($nilaiAlternatif - $idealPositif[$abbr], 2);

                // Perhitungan nilai D-
                $nilaiDMinus += pow($nilaiAlternatif - $idealNegatif[$abbr], 2);
            });

            $nilaiDPlus = sqrt($nilaiDPlus);
            $nilaiDMinus = sqrt($nilaiDMinus);

            return [
                'kode_barang' => $alternatif['kode_barang'],
                'nama_barang' => $alternatif['nama_barang'],
                'D+' => $nilaiDPlus,
                'D-' => $nilaiDMinus,
            ];
        });

        // Menghitung nilai preferensi
        $preferensi = collect([]);

        $hasilKedekatan->each(function ($alternatif) use (&$preferensi) {
            $DPlus = $alternatif['D+'];
            $DMinus = $alternatif['D-'];

            // Perhitungan nilai preferensi (V)
            $V = $DMinus / ($DPlus + $DMinus);

            // Tambahkan nilai preferensi (V) ke dalam Collection
            $preferensi->push([
                'kode_barang' => $alternatif['kode_barang'],
                'nama_barang' => $alternatif['nama_barang'],
                'V' => $V,
            ]);
        });

        // Mengurutkan alternatif berdasarkan nilai preferensi
        $preferensiTerurut = $preferensi->sortByDesc('V')->values();

        // Menyiapkan data untuk cache. Menghilangkan nilai V dan menambahkan peringkat
        $hasil_peringkat = $preferensiTerurut->map(function ($item, $index) {
            unset($item['V']);
            $item['peringkat'] = $index + 1;
            return $item;
        });
        Session::put('hasil_peringkat', $hasil_peringkat);

        return view('analisis.hasil', [
            'title' => 'Hasil Perhitungan',
            'header' => 'Hasil Analisis Periode: ' . $bulan_tertulis . ' ' . $tahun,
            'data' => $data,
            'normalisasi' => $normalisasi,
            'normalisasi_terbobot' => $normalisasi_terbobot,
            'idealPositif' => $idealPositif,
            'idealNegatif' => $idealNegatif,
            'hasilKedekatan' => $hasilKedekatan,
            'preferensi' => $preferensi,
            'hasil' => $preferensiTerurut,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function terbilang($bulan)
    {
        $bulanMapping = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $namaBulan = $bulanMapping[$bulan];
        return $namaBulan;
    }
};
