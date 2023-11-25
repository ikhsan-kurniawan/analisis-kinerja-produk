<hr>
<table id="myDataTable" class="table table-striped table-bordered text-center">
    <thead>
        <tr class="table-info">
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
        $nomor = 0;
        @endphp
        @foreach($data as $index => $dataItem)
        <tr>
            <td>{{ ++$nomor }}</td>
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
@if (!$data->isEmpty())
    <div class="my-3">
        {{-- <a href="{{ route('analisis.hitung') }}" id="analisis-link">
            <button type="button" class="btn btn-success btn-block">Analisis</button>
        </a> --}}
        <a href="{{ route('analisis.hitung', ['bulan' => $bulan, 'tahun' => $tahun]) }}" id="analisis-link">
            <button type="button" class="btn btn-success btn-block">Analisis</button>
        </a>
    </div>

    {{-- <script>
        $(document).ready(function() {
            // Mengambil nilai bulan dan tahun dari input
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
    
            // Membuat URL dengan parameter bulan dan tahun
            var url = "{{ route('analisis.hitung') }}?bulan=" + bulan + "&tahun=" + tahun;
    
            // Mengubah atribut href dari tautan Analisis
            $('#analisis-link').attr('href', url);
        });
    </script> --}}
@endif