<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
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
        'sector_id',
        'image_real_name', 
        'image_name', 
        'base_path', 
        'tanggal',
    ];

    public const BASE_PATH = 'images/keuangan/pengajuan-dana/';

    
    protected static function boot()
    {
        parent::boot();

        Self::creating(function ($model) {
           $model->sector_id = Config::get('app.sector_id'); 
           $model->base_path = self::BASE_PATH; 
        });
    }

    public function paket()
    {
        return $this->belongsTo(MsSubCode::class, 'paket_id');
    }
}
