<?php

namespace App\Models\Perencanaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class BrosurPerumahan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sector_id',
        'pdf_real_name', 
        'pdf_name', 
        'base_path', 
        'tanggal',
    ];

    public const BASE_PATH = 'images/perencanaan/brosur-perumahan/';

    
    protected static function boot()
    {
        parent::boot();

        Self::creating(function ($model) {
           $model->sector_id = Config::get('app.sector_id'); 
           $model->base_path = self::BASE_PATH; 
        });
    }
}
