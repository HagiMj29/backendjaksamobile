<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\jaksa_masuk_sekolah;

class JaksaController extends Controller
{
    public function index()
    {
        
        $jaksa = jaksa_masuk_sekolah::with('user')->latest()->get();

        $result = $jaksa->map(function ($data){
            
            return [
                'id'=>$data->id,
                'user_id'=>$data->user_id,
                'user_name'=>$data->user->name,
                'sekolah'=>$data->sekolah,  
                'status'=>$data->status,  
            ];

        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result'=>$result], 200);
    }

    public function store(Request $request)
    {
       $validatedData=$request->validate([
            'user_id' => 'required|exists:users,id',
            'sekolah' => 'required',
        ]);
    
        $jaksa = jaksa_masuk_sekolah::create(array_merge($validatedData, [
            'status' => 'diproses'
        ]));
        
        $result = $jaksa;
        
        return response()->json(['message' => 'Data Berhasil di Tambahkan', 'result'=>$result], 201);
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'sekolah' => 'required',
    ]);

    // Temukan pengaduan berdasarkan ID
    $pengaduan = jaksa_masuk_sekolah::findOrFail($id);

    // Perbarui data
    $pengaduan->update(array_merge($validatedData, [
        'status' => 'diproses'
    ]));

    // Jika berhasil diperbarui, kembalikan respons
    if ($pengaduan) {
        return response()->json(['message' => 'Data pengaduan berhasil diperbarui'], 200);
    } else {
        return response()->json(['message' => 'Gagal memperbarui data pengaduan'], 500);
    }
}

public function destroy(jaksa_masuk_sekolah $jaksa_masuk_sekolah)
{
    $jaksa_masuk_sekolah->delete();

    return response()->json(['message' => 'Data Berhasil di Hapus'], 200);
}

public function edit_status(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'status' => 'required',
    ]);

    // Temukan pengaduan berdasarkan ID
    $pengaduan = jaksa_masuk_sekolah::findOrFail($id);

    // Perbarui data pengaduan dengan data yang telah divalidasi
    $pengaduan->update($validatedData);

    // Kembalikan respons berdasarkan keberhasilan pembaruan data
    if ($pengaduan) {
        return response()->json(['message' => 'Data pengaduan berhasil diperbarui'], 200);
    } else {
        return response()->json(['message' => 'Gagal memperbarui data pengaduan'], 500);
    }
}



}
