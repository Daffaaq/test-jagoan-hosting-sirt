<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_iuran';

    protected $fillable = [
        'penghuni_id',
        'rumah_id',
        'iuran_id',
        'bulan',
        'tahun',
        'jumlah',
        'status',
        'tanggal_bayar',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function iuran()
    {
        return $this->belongsTo(Iuran::class);
    }
}
