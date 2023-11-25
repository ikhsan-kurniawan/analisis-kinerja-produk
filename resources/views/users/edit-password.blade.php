<x-app-layout :title='$title' :header='$header'>
    <div class="container">    
        <form method="POST" action="{{ route('password.ubah') }}">
            @csrf
            @method('PUT')
    
            <div class="form-group">
                <label for="password_sekarang">Password Sekarang</label>
                <input type="password" class="form-control" id="password_sekarang" name="password_sekarang">
                @error('password_sekarang')
                    <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="password_konfirmasi">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
    
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-app-layout>
