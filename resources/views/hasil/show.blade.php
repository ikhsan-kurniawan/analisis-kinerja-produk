<x-app-layout :title='$title' :header='$header'>
    <div>
        <h5 class="my-0">ID Hasil: HA-{{ $hasil->id }}</h5>
        <h5 class="my-0">Disimpan: {{ $hasil->created_at }}</h5>
    </div>

    <hr class="border border-dark border-2 opacity-50 my-2">

    <div class="container mt-4">
        <table class="table text-center data-table table-striped table-bordered">
            <thead>
                <tr class="table-success">
                    <th>Peringkat</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil->hasilDetail as $item)
                <tr>
                    <td>{{ $item['peringkat'] }}</td>
                    <td>{{ $item['kode_barang'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>