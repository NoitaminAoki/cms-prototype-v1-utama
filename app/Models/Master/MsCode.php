<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{
    Perencanaan\Divisi,
};

class MsCode extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'divisi_id',
        'code',
        'nama'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id')->withDefault(['nama' => 'none']);
    }
}
