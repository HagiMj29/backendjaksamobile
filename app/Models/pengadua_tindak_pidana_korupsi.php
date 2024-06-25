<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pengadua_tindak_pidana_korupsi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'no_hp',
        'nik_ktp',
        'uraian_singkat_laporan',
        'laporan_pengaduan',
        'input_pdf_ktp',
        'input_pdf_pengaduan',
        'status',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
