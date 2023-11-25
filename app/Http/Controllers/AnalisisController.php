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
            $gm = $item->total_laba / ($item->sub_harga * $item->total_qty) * 100;
            $roa = $item->total_laba / ($item->sub_harga_beli * $item->total_qty) * 100;
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
        //         'kode_barang' => '001',
        //         'nama_barang' => 'Produk 1',
        //         'roa' => 12.5,
        //         'gm' => 9.0,
        //         'ito' => 6.5,
        //         're' => 85.0,
        //     ],
        //     [
        //         'kode_barang' => '002',
        //         'nama_barang' => 'Produk 2',
        //         'roa' => 10.0,
        //         'gm' => 8.5,
        //         'ito' => 5.5,
        //         're' => 92.0,
        //     ],
        //     [
        //         'kode_barang' => '003',
        //         'nama_barang' => 'Produk 3',
        //         'roa' => 14.0,
        //         'gm' => 11.0,
        //         'ito' => 7.0,
        //         're' => 88.0,
        //     ],
        //     [
        //         'kode_barang' => '004',
        //         'nama_barang' => 'Produk 4',
        //         'roa' => 11.5,
        //         'gm' => 9.5,
        //         'ito' => 6.0,
        //         're' => 90.0,
        //     ],
        //     [
        //         'kode_barang' => '005',
        //         'nama_barang' => 'Produk 5',
        //         'roa' => 13.0,
        //         'gm' => 8.0,
        //         'ito' => 5.2,
        //         're' => 86.0,
        //     ],
        //     // [
        //     //     'kode_barang' => '006',
        //     //     'nama_barang' => 'Produk 6',
        //     //     'roa' => 9.5,
        //     //     'gm' => 10.5,
        //     //     'ito' => 0.068,
        //     //     're' => 91.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '007',
        //     //     'nama_barang' => 'Produk 7',
        //     //     'roa' => 12.0,
        //     //     'gm' => 7.5,
        //     //     'ito' => 0.045,
        //     //     're' => 89.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '008',
        //     //     'nama_barang' => 'Produk 8',
        //     //     'roa' => 11.0,
        //     //     'gm' => 9.2,
        //     //     'ito' => 0.062,
        //     //     're' => 87.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '009',
        //     //     'nama_barang' => 'Produk 9',
        //     //     'roa' => 12.2,
        //     //     'gm' => 8.8,
        //     //     'ito' => 0.057,
        //     //     're' => 84.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '010',
        //     //     'nama_barang' => 'Produk 10',
        //     //     'roa' => 10.8,
        //     //     'gm' => 9.8,
        //     //     'ito' => 0.075,
        //     //     're' => 83.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '011',
        //     //     'nama_barang' => 'Produk 11',
        //     //     'roa' => 12.5,
        //     //     'gm' => 9.0,
        //     //     'ito' => 0.065,
        //     //     're' => 85.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '012',
        //     //     'nama_barang' => 'Produk 12',
        //     //     'roa' => 10.0,
        //     //     'gm' => 8.5,
        //     //     'ito' => 0.055,
        //     //     're' => 92.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '013',
        //     //     'nama_barang' => 'Produk 13',
        //     //     'roa' => 14.0,
        //     //     'gm' => 11.0,
        //     //     'ito' => 0.070,
        //     //     're' => 88.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '014',
        //     //     'nama_barang' => 'Produk 14',
        //     //     'roa' => 11.5,
        //     //     'gm' => 9.5,
        //     //     'ito' => 0.060,
        //     //     're' => 90.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '015',
        //     //     'nama_barang' => 'Produk 15',
        //     //     'roa' => 13.0,
        //     //     'gm' => 8.0,
        //     //     'ito' => 0.052,
        //     //     're' => 86.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '016',
        //     //     'nama_barang' => 'Produk 16',
        //     //     'roa' => 9.5,
        //     //     'gm' => 10.5,
        //     //     'ito' => 0.068,
        //     //     're' => 91.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '017',
        //     //     'nama_barang' => 'Produk 17',
        //     //     'roa' => 12.0,
        //     //     'gm' => 7.5,
        //     //     'ito' => 0.045,
        //     //     're' => 89.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '018',
        //     //     'nama_barang' => 'Produk 18',
        //     //     'roa' => 11.0,
        //     //     'gm' => 9.2,
        //     //     'ito' => 0.062,
        //     //     're' => 87.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '019',
        //     //     'nama_barang' => 'Produk 19',
        //     //     'roa' => 12.2,
        //     //     'gm' => 8.8,
        //     //     'ito' => 0.057,
        //     //     're' => 84.0,
        //     // ],
        //     // [
        //     //     'kode_barang' => '020',
        //     //     'nama_barang' => 'Produk 20',
        //     //     'roa' => 10.8,
        //     //     'gm' => 9.8,
        //     //     'ito' => 0.075,
        //     //     're' => 83.0,
        //     // ],
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
