<?php

namespace App\Models\Umum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLegalitasPerusahaan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'legalitas_perusahaan_id',
        'image_name', 
        'image_path',
        'tanggal',
    ];
}
