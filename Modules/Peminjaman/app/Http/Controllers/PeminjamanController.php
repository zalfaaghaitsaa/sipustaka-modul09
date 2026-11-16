<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Peminjaman\Http\Requests\PinjamRequest;
use Modules\Peminjaman\Models\Pinjam;

class PeminjamanController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Peminjaman::index');
    }

    public function getData(): JsonResponse
    {
        return response()->json(Pinjam::latest()->get());
    }

    public function store(PinjamRequest $request): JsonResponse
    {
        $data = $request->safe()->except('berkas');
        $file = $request->file('berkas');
        $data['berkas'] = $file->store('berkas_peminjaman', 'public');
        $data['nama_berkas'] = $file->getClientOriginalName();

        Pinjam::create($data);

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

    public function edit(Pinjam $pinjam): JsonResponse
    {
        return response()->json($pinjam);
    }

    public function update(PinjamRequest $request, Pinjam $pinjam): JsonResponse
    {
        $data = $request->safe()->except('berkas');

        if ($request->hasFile('berkas')) {
            if ($pinjam->berkas) {
                Storage::disk('public')->delete($pinjam->berkas);
            }
            $file = $request->file('berkas');
            $data['berkas'] = $file->store('berkas_peminjaman', 'public');
            $data['nama_berkas'] = $file->getClientOriginalName();
        }

        $pinjam->update($data);

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    public function destroy(Pinjam $pinjam): JsonResponse
    {
        if ($pinjam->berkas) {
            Storage::disk('public')->delete($pinjam->berkas);
        }

        $pinjam->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}