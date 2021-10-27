<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{
    Master\MsCode,
    Master\MsNestedSubCode,
};

class MsSubCode extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_code_id',
        'paket_code_id',
        'code',
        'nama',
        'has_child',
    ];

    public function divisi()
    {
        return $this->belongsTo(MsCode::class, 'parent_code_id');
    }

    public function nested_sub_code()
    {
        return $this->hasMany(MsNestedSubCode::class, 'sub_code_id');
    }
}
