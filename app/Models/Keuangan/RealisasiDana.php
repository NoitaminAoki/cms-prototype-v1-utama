<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Master\MsCode,

    Keuangan\PengajuanDana,
    Keuangan\MaterialPengajuanDana,
};

class RealisasiDana extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_name', 
        'image_path', 
        'tanggal',
    ];
}
