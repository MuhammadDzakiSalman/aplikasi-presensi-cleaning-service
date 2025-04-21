<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IzinFile extends Model
{
    use HasFactory;

    protected $fillable = ['izin_id', 'file_path'];

    public function izin()
    {
        return $this->belongsTo(Izin::class);
    }
}
