<?php

namespace App\Models\Konstruksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProgressKemajuan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'progress_kemajuan_id',
        'image_name', 
        'image_path', 
        'tanggal',
    ];
}
