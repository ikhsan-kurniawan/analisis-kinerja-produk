<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Hasil</th>
                    <th>Periode</th>
                    <th>Disimpan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $index => $item)
                    @php
                        $bulan_tertulis = [
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

                        $tanggal = explode('-', $item->periode);
                        $bulan = $bulan_tertulis[$tanggal[1]];
                        $tahun = $tanggal[0];
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>HA-{{ $item->id }}</td>
                        <td>{{ $bulan . ' ' . $tahun }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{ route('hasil.show', ['id' => $item['id']]) }}" class="btn btn-primary">Lihat</a>
                            <form action="{{ route('hasil.destroy', ['id' => $item->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>