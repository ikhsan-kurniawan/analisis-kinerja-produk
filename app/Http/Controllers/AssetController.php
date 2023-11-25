<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $asset = Asset::get();

        return view('aset.index', [
            'title' => 'Aset',
            'header' => 'Aset',
            'asset' => $asset,
        ]);
    }

    public function create()
    {
        return view('aset.create', [
            'title' => 'Tambah Aset',
            'header' => 'Tambah Aset',
        ]);
    }

    public function store(Request $request)
    {
        // Membersihkan nilai sebelum validasi
        $request->merge([
            'nilai' => str_replace(['Rp', '.'], ['', ''], $request->input('nilai')),
        ]);

        $request->validate([
            'nama' => 'required',
            'nilai' => ['required', 'numeric', 'min:0'],
            'penyusutan' => ['required', 'numeric', 'between:0,100'],
        ]);

        Asset::create([
            'nama' => $request->nama,
            'nilai' => $request->nilai,
            'penyusutan' => $request->penyusutan,
        ]);

        return redirect()->route('asset.index')->with('message', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $asset = Asset::find($id);

        return view('aset.edit', [
            'asset' => $asset,
            'title' => 'Edit Aset',
            'header' => 'Edit Aset',
        ]);
    }

    public function update(Request $request, $id)
    {
        // Membersihkan nilai sebelum validasi
        $request->merge([
            'nilai' => str_replace(['Rp', '.'], ['', ''], $request->input('nilai')),
        ]);

        $request->validate([
            'nama' => 'required',
            'nilai' => ['required', 'numeric', 'min:0'],
            'penyusutan' => ['required', 'numeric', 'between:0,100'],
        ]);

        $data = Asset::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'nilai' => $request->nilai,
            'penyusutan' => $request->penyusutan,
        ]);

        return redirect()->route('asset.index')->with('message', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Asset::findOrFail($id);

        $data->delete();

        return redirect()->route('asset.index')->with('message', 'Data berhasil dihapus');
    }
}
