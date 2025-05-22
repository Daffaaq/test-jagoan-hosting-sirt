<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';

    protected $fillable = ['nama_lengkap', 'foto_ktp', 'status_penghuni', 'nomor_telepon', 'status_menikah'];

    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class);
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class);
    }
}
