<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        <div>
            <h3 class="text-center mb-3">Data</h3>
            <table class="table text-center data-table table-striped table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th class="align-middle">#</th>
                        <th class="align-middle">Kode Barang</th>
                        <th class="align-middle">Nama Barang</th>
                        <th class="align-middle">Return on Assets</th>
                        <th class="align-middle">Gross Margin</th>
                        <th class="align-middle">Inventory Turn Over</th>
                        <th class="align-middle">Rasio Efisiensi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1;
                    @endphp
                    @foreach($data as $index => $dataItem)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $dataItem['kode_barang'] }}</td>
                        <td>{{ $dataItem['nama_barang'] }}</td>
                        <td>{{ number_format($dataItem['roa'], 2) }}%</td>
                        <td>{{ number_format($dataItem['gm'], 2) }}%</td>
                        <td>{{ number_format($dataItem['ito'], 2) }}</td>
                        <td>{{ number_format($dataItem['re'], 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr class="border border-dark border-2 opacity-50 my-4">

        <h3 class="text-center mb-3">Detail Proses</h3>
        
        <div>
            <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#normalisasi" aria-expanded="false" aria-controls="normalisasi">
                Normalisasi
            </button>
            <div class="collapse" id="normalisasi">
                <div class="card card-body px-1">
                    <table class="table text-center data-table table-striped table-bordered">
                        <thead>
                            <tr class="table-active">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Kode Barang</th>
                                <th class="align-middle">Nama Barang</th>
                                <th class="align-middle">Return on Assets</th>
                                <th class="align-middle">Gross Margin</th>
                                <th class="align-middle">Inventory Turn Over</th>
                                <th class="align-middle">Rasio Efisiensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp
                            @foreach($normalisasi as $index => $normalisasiItem)
                            <tr>
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $normalisasiItem['kode_barang'] }}</td>
                                <td>{{ $normalisasiItem['nama_barang'] }}</td>
                                <td>{{ $normalisasiItem['roa'] }}</td>
                                <td>{{ $normalisasiItem['gm'] }}</td>
                                <td>{{ $normalisasiItem['ito'] }}</td>
                                <td>{{ $normalisasiItem['re'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
        </div>

        {{-- <hr class="border border-dark border-2 opacity-50 my-4"> --}}

        <div class="mt-4">
            <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#normalisasi_terbobot" aria-expanded="false" aria-controls="normalisasi_terbobot">
                Normalisasi Terbobot
            </button>
            <div class="collapse" id="normalisasi_terbobot">
                <div class="card card-body px-1">
                    <table class="table text-center data-table table-striped table-bordered">
                        <thead>
                            <tr class="table-active">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Kode Barang</th>
                                <th class="align-middle">Nama Barang</th>
                                <th class="align-middle">Return on Assets</th>
                                <th class="align-middle">Gross Margin</th>
                                <th class="align-middle">Inventory Turn Over</th>
                                <th class="align-middle">Rasio Efisiensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp
                            @foreach($normalisasi_terbobot as $index => $normalisasiItem)
                            <tr>
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $normalisasiItem['kode_barang'] }}</td>
                                <td>{{ $normalisasiItem['nama_barang'] }}</td>
                                <td>{{ $normalisasiItem['roa'] }}</td>
                                <td>{{ $normalisasiItem['gm'] }}</td>
                                <td>{{ $normalisasiItem['ito'] }}</td>
                                <td>{{ $normalisasiItem['re'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
        </div>

        {{-- <hr class="border border-dark border-2 opacity-50 my-4"> --}}

        <div class="mt-4">
            <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#solusi_ideal" aria-expanded="false" aria-controls="solusi_ideal">
                Solusi Ideal Positif dan Solusi Ideal Negatif
            </button>
            <div class="collapse" id="solusi_ideal">
                <div class="card card-body px-1">
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr class="table-info">
                                <th>#</th>
                                <th>Solusi</th>
                                <th>Return on Assets</th>
                                <th>Gross Margin</th>
                                <th>Inventory Turn Over</th>
                                <th>Rasio Efisiensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Solusi Ideal Positif</td>
                                <td>{{ $idealPositif['roa'] }}</td>
                                <td>{{ $idealPositif['gm'] }}</td>
                                <td>{{ $idealPositif['ito'] }}</td>
                                <td>{{ $idealPositif['re'] }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Solusi Ideal Negatif</td>
                                <td>{{ $idealNegatif['roa'] }}</td>
                                <td>{{ $idealNegatif['gm'] }}</td>
                                <td>{{ $idealNegatif['ito'] }}</td>
                                <td>{{ $idealNegatif['re'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
        </div>

        {{-- <hr class="border border-dark border-2 opacity-50 my-4"> --}}

        <div class="mt-4">
            <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#preferensi" aria-expanded="false" aria-controls="preferensi">
                Nilai Kedekatan dan Preferensi
            </button>
            <div class="collapse" id="preferensi">
                <div class="card card-body px-1">
                    <table class="table text-center data-table table-striped table-bordered">
                        <thead>
                            <tr class="table-active">
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>D+</th>
                                <th>D-</th>
                                <th>Preferensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp
                            @foreach ($hasilKedekatan as $index => $item)
                                @foreach ($preferensi as $preferensiItem)
                                    @if ($item['kode_barang'] == $preferensiItem['kode_barang'])
                                        <tr>
                                            <td>{{ $nomor++ }}</td>
                                            <td>{{ $item['kode_barang'] }}</td>
                                            <td>{{ $item['nama_barang'] }}</td>
                                            <td>{{ $item['D+'] }}</td>
                                            <td>{{ $item['D-'] }}</td>
                                            <td>{{ $preferensiItem['V'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
        </div>
    
        <hr class="border border-dark border-2 opacity-50 my-4">

        <div>
            <h3 class="text-center mb-3">Hasil Analisis Kinerja Produk</h3>
            <table class="table text-center data-table table-striped table-bordered">
                <thead>
                    <tr class="table-success">
                        <th>Peringkat</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil as $index => $hasilItem)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hasilItem['kode_barang'] }}</td>
                        <td>{{ $hasilItem['nama_barang'] }}</td>
                        <td>{{ $hasilItem['V'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <form method="post" action="{{ route('hasil.store') }}">
                @csrf
                <input type="text" id="bulan" name="bulan" value="{{ $bulan }}" required hidden>
                <input type="text" id="tahun" name="tahun" value="{{ $tahun }}" required hidden>
                <button type="submit" class="btn btn-success btn-block">Simpan Hasil</button>
            </form>
        </div>
    </div>
</x-app-layout>