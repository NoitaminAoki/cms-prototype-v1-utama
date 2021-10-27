<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Master\MsSubCode,
};

class PengajuanDana extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paket_id',
        'image_name', 
        'image_path', 
        'tanggal',
    ];

    public function paket()
    {
        return $this->belongsTo(MsSubCode::class, 'paket_id');
    }
}
