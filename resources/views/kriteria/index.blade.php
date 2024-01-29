<x-app-layout :title='$title' :header='$header'>
    {{-- @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif --}}
    <div class="container">
        <table class="table table-striped text-center">
            <thead>
                <tr class="table-info">
                    <th>#</th>
                    <th>Indikator</th>
                    <th>Atribut</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $index => $kriteriaItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kriteriaItem->indikator }}</td>
                    <td>{{ $kriteriaItem->atribut }}</td>
                    <td>{{ $kriteriaItem->bobot }}</td>
                    <td>
                        <a href="{{ route('kriteria.edit', ['id' => $kriteriaItem['id']]) }}" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>