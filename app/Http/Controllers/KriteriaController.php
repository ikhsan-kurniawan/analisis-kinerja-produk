<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::get();

        return view('kriteria.index', [
            'title' => 'Kriteria',
            'header' => 'Kriteria',
            'kriteria' => $kriteria,
        ]);
    }

    public function edit($id)
    {
        $kriteria = Kriteria::find($id);

        return view('kriteria.edit', [
            'kriteria' => $kriteria,
            'title' => 'Edit Kriteria',
            'header' => 'Edit Kriteria',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bobot' => ['required', 'numeric', 'between:1,5'],
        ]);

        $data = Kriteria::findOrFail($id);

        $data->update([
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('kriteria.index')->with('message', 'Data berhasil diperbarui');
    }
}
