<x-app-layout :title='$title' :header='$header'>
    {{-- <a href="{{ route('analisis.hitung') }}">
        <button type="button" class="btn btn-primary">Analisis</button>
    </a> --}}
    <div class="form-group">
        <label for="bulan">Pilih Bulan:</label>
        <select name="bulan" id="bulan" class="form-control">
            <option value="" disabled selected>--- Pilih Bulan ---</option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tahun">Pilih Tahun:</label>
        <select name="tahun" id="tahun" class="form-control">
            <option value="" disabled selected>--- Pilih Tahun ---</option>
            @php
                $currentYear = date('Y');
                $startYear = 2022;
            @endphp
            @for ($year = $currentYear; $year >= $startYear; $year--)
                <option value="{{ $year }}" >{{ $year }}</option>
            @endfor
        </select>
    </div>
    <button id="loadData" class="btn btn-primary">Tampilkan Data</button>

    <div id="loading" class="progress mt-4" style="display: none;">
        <div class="progress-bar progress-bar-striped progress-bar-animated mx-auto" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>
    </div>

    <div id="data-container" class="">
        
    </div>
</x-app-layout>