<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_iurans';

    protected $fillable = [
        'penghuni_rumah_id',
        'iuran_id',
        'bulan',
        'tahun',
        'jumlah',
        'status',
        'tanggal_bayar',
    ];

    public function penghuniRumah()
    {
        return $this->belongsTo(PenghuniRumah::class);
    }

    public function iuran()
    {
        return $this->belongsTo(Iuran::class);
    }
}
