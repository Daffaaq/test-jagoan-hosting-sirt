<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    protected $table = 'rumahs';

    protected $fillable = ['nomor_rumah', 'status_huni'];

    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class);
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class);
    }
}
