<x-app-layout :title='$title' :header='$header'>
    {{-- @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif --}}
    <div class="container">
        <a href="{{ route('asset.create') }}" class="btn btn-success mb-2">Tambah Aset</a>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                    <th>Penyusutan (%)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asset as $index => $assetItem)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $assetItem->nama }}</td>
                        <td class="uang">{{ $assetItem->nilai }}</td>
                        <td>{{ $assetItem->penyusutan }}</td>
                        <td>
                            <a href="{{ route('asset.edit', ['id' => $assetItem['id']]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('asset.destroy', ['id' => $assetItem->id]) }}" method="POST" style="display: inline;">
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