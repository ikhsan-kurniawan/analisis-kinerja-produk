<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        {{-- <h1>Edit Data Kriteria</h1> --}}
    
        <form method="POST" action="{{ route('kriteria.update', ['id' => $kriteria->id]) }}">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label for="indikator">Indikator:</label>
                <input type="text" class="form-control" id="indikator" name="indikator" value="{{ $kriteria->indikator }}" readonly>
            </div>
    
            <div class="form-group">
                <label for="atribut">Atribut</label>
                <input type="text" class="form-control" id="atribut" name="atribut" value="{{ $kriteria->atribut }}" readonly>
            </div>
    
            <div class="form-group">
                <label for="bobot">Bobot (1-5)</label>
                <input type="text" class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ $kriteria->bobot }}" autocomplete="off">
                @error('bobot')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>    
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-app-layout>
