<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        <form action="{{ route('asset.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required autocomplete="off">
                @error('nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nilai">Nilai:</label>
                <input type="text" class="form-control @error('nilai') is-invalid @enderror uang" id="nilai" name="nilai" required autocomplete="off">
                @error('nilai')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                
            </div>
            <div class="form-group">
                <label for="penyusutan">Penyusutan (%):</label>
                <input type="text" class="form-control @error('penyusutan') is-invalid @enderror" id="penyusutan" name="penyusutan" required autocomplete="off">
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