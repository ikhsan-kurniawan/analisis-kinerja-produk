<x-app-layout :title='$title' :header='$header'>
    <div class="container">
        {{-- <h1>Edit Profil</h1> --}}

        {{-- @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}
    
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', Auth::user()->username) }}">
                @error('username')
                    <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', Auth::user()->nama) }}">
            </div>
    
            {{-- <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="password" name="password">
            </div> --}}
    
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <a href="{{ route('password.edit') }}">
            <button type="button" class="btn btn-warning mt-3">Ubah Password</button>
        </a>
    </div>
</x-app-layout>
