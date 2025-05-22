<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghuniRumah extends Model
{
    use HasFactory;

    protected $table = 'penghuni_rumah';

    protected $fillable = ['rumah_id', 'penghuni_id', 'tanggal_mulai', 'tanggal_selesai'];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
