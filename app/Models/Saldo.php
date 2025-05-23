<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $table = 'saldos';

    protected $fillable = ['bulan', 'tahun', 'total_pemasukan', 'total_pengeluaran', 'saldo'];
}
