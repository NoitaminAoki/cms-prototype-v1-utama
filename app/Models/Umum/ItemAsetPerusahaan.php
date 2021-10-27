<?php

namespace App\Models\Umum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAsetPerusahaan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aset_id',
        'image_name', 
        'image_path',
        'tanggal',
    ];
}
