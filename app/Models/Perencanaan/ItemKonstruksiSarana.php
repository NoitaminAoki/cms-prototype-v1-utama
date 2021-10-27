<?php

namespace App\Models\Perencanaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKonstruksiSarana extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'konstruksi_sarana_id',
        'pdf_name', 
        'pdf_path',
        'tanggal',
    ];
}
