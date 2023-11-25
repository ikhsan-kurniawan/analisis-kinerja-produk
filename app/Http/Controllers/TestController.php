<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $bulanSebelum = $bulan - 1;
        $tahunSebelum = $tahun;
        if ($bulanSebelum == 0) {
            $bulanSebelum = 12;
            $tahunSebelum--;
        }
        $bulanSebelum = str_pad($bulanSebelum, 2, '0', STR_PAD_LEFT);


        // DB::connection('barang_mysql')->statement("INSERT INTO barang_keluar_masuk (kode_barang, nama_barang, stock_awal_bulan, jumlah_penjualan, jumlah_pembelian, stock_akhir_bulan, periode)
        // SELECT a.kode_barang,a.nama_barang,
        // ((select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')-(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')) as stock_awal_bulan,

        // (select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahun-$bulan-%') as jumlah_penjualan,(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahun-$bulan-%') as jumlah_pembelian,

        // ((select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')-(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%') -
        // (select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahun-$bulan-%')+(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahun-$bulan-%')) as stock_akhir_bulan,
        // '$tahun-$bulan-10' as periode

        // FROM v_barang a");


        // $barang_keluar_masuk = DB::connection('barang_mysql')->select("SELECT  a.kode_barang,a.nama_barang,
        // ((select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')-(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')) as stock_awal_bulan,

        // (select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahun-$bulan-%') as jumlah_penjualan,(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahun-$bulan-%') as jumlah_pembelian,

        // ((select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%')-(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahunSebelum-$bulanSebelum-%') -
        // (select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Penjualan' and tanggal_transaksi like '$tahun-$bulan-%')+(select IFNULL(sum(jumlah_pcs),0) from v_barang_keluar_masuk where kode_barang=a.kode_barang and 
        // keterangan='Pembelian' and tanggal_transaksi like '$tahun-$bulan-%')) as stock_akhir_bulan,
        // '$tahun-$bulan-10' as periode

        // FROM v_barang a;");

        // foreach ($barang_keluar_masuk as $data) {
        //     DB::connection('barang_mysql')->table('barang_keluar_masuk')->insert([
        //         'kode_barang' => $data->kode_barang,
        //         'nama_barang' => $data->nama_barang,
        //         'stock_awal_bulan' => $data->stock_awal_bulan,
        //         'jumlah_penjualan' => $data->jumlah_penjualan,
        //         'jumlah_pembelian' => $data->jumlah_pembelian,
        //         'stock_akhir_bulan' => $data->stock_akhir_bulan,
        //         'periode' => $data->periode,
        //     ]);
        // }

        // dd($barang_keluar_masuk);
        echo "done";
    }
}
