<x-app-layout :title='$title' :header='$header'>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kriteria</span>
                    <span class="info-box-number"> {{ count($kriteria) }} </span>
                </div>
            
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Aset</span>
                    <span class="info-box-number">{{ count($aset) }}</span>
                </div>
            </div>
        </div>
        
        
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hasil Tersimpan</span>
                    <span class="info-box-number">{{ count($hasil) }}</span>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title text-center">Kriteria</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Indikator</th>
                                <th>Atribut</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $item)
                                <tr>
                                    <td>{{ $item->indikator }}</td>
                                    <td>{{ $item->atribut }}</td>
                                    <td>{{ $item->bobot }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title text-center">Aset</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Nama Aset</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $item)
                                <tr>
                                    <td>{{ $item['nama'] }}</td>
                                    <td class="uang">{{ $item['nilai'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-bold">
                                <td>Total Aset</td>
                                <td class="uang">{{ $total_aset->total_nilai_aset }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>