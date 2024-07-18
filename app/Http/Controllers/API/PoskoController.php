<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\posko_pilkada;


class PoskoController extends Controller
{
    public function index()
    {
        
        $posko = posko_pilkada::with('user')->latest()->get();

        $result = $posko->map(function ($data){
            
            return [
                'id'=>$data->id,
                'user_id'=>$data->user_id,
                'user_name'=>$data->user->name,
                'no_hp'=>$data->no_hp,
                'nik_ktp'=>$data->nik_ktp,
                'input_pdf_ktp'=>$data->input_pdf_ktp,
                'laporan_pengaduan'=>$data->laporan_pengaduan,
                'input_pdf_pengaduan'=>$data->input_pdf_pengaduan,
                'status'=>$data->status,
        
            ];

        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result'=>$result], 200);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'no_hp' => 'required',
            'nik_ktp' => 'required',
            'laporan_pengaduan' => 'required',
            'input_pdf_ktp' => 'required|file|mimes:pdf',
            'input_pdf_pengaduan' => 'required|file|mimes:pdf',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('input_pdf_ktp')) {
            $ktpPath = $request->file('input_pdf_ktp')->store('ktp_files');
            $validatedData['input_pdf_ktp'] = $ktpPath;
        }
    
        if ($request->hasFile('input_pdf_pengaduan')) {
            $pengaduanFile = $request->file('input_pdf_pengaduan');
            $fileName = 'input_pdf_pengaduan_pegawai_' . $request->user_id . '.' . $pengaduanFile->getClientOriginalExtension();
            $pengaduanPath = $pengaduanFile->storeAs('pengaduan_files', $fileName);
            $validatedData['input_pdf_pengaduan'] = $pengaduanPath;
        }
    
        // Simpan data
        $pengaduan = posko_pilkada::create(array_merge($validatedData, [
            'status' => 'diproses'
        ]));
    
        // Jika berhasil disimpan, kembalikan respons
        if ($pengaduan) {
            return response()->json(['message' => 'Data pengaduan berhasil disimpan'], 201);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data pengaduan'], 500);
        }
    }


    public function update(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'no_hp' => 'required',
        'nik_ktp' => 'required',
        'laporan_pengaduan' => 'required',
        'input_pdf_ktp' => 'nullable|file|mimes:pdf',
        'input_pdf_pengaduan' => 'nullable|file|mimes:pdf',
    ]);

    // Temukan pengaduan berdasarkan ID
    $pengaduan = posko_pilkada::findOrFail($id);

    // Handle file uploads
    if ($request->hasFile('input_pdf_ktp')) {
        $ktpPath = $request->file('input_pdf_ktp')->store('ktp_files', 'public');
        $validatedData['input_pdf_ktp'] = $ktpPath;
    } else {
        $validatedData['input_pdf_ktp'] = $pengaduan->input_pdf_ktp; // Gunakan file KTP yang sudah ada
    }

    if ($request->hasFile('input_pdf_pengaduan')) {
        $pengaduanFile = $request->file('input_pdf_pengaduan');
        $fileName = 'input_pdf_pengaduan_pegawai_' . $request->user_id . '.' . $pengaduanFile->getClientOriginalExtension();
        $pengaduanPath = $pengaduanFile->storeAs('pengaduan_files', $fileName, 'public');
        $validatedData['input_pdf_pengaduan'] = $pengaduanPath;
    } else {
        $validatedData['input_pdf_pengaduan'] = $pengaduan->input_pdf_pengaduan; // Gunakan file pengaduan yang sudah ada
    }

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

public function destroy(posko_pilkada $posko_pilkada)
{
    $posko_pilkada->delete();

    return response()->json(['message' => 'Data Berhasil di Hapus'], 200);
}

public function edit_status(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'status' => 'required',
    ]);

    // Temukan pengaduan berdasarkan ID
    $pengaduan = posko_pilkada::findOrFail($id);

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
