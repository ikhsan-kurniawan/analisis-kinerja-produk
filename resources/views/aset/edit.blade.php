<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        {{-- <h1>Edit Data Aset</h1> --}}
    
        <form method="POST" action="{{ route('asset.update', ['id' => $asset->id]) }}">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $asset->nama }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nilai">Nilai:</label>
                <input type="text" class="form-control @error('nilai') is-invalid @enderror uang" id="nilai" name="nilai" value="{{ $asset->nilai }}" autocomplete="off">
                @error('nilai')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="penyusutan">Penyusutan (%)</label>
                <input type="text" class="form-control @error('penyusutan') is-invalid @enderror" id="penyusutan" name="penyusutan" value="{{ $asset->penyusutan }}" autocomplete="off">
                @error('penyusutan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-app-layout>
