<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class JamKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'jam_masuk',
        'jam_keluar',
    ];

    public function getJamMasukAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function setJamMasukAttribute($value)
    {
        $this->attributes['jam_masuk'] = Carbon::createFromFormat('H:i', $value)->toTimeString(); // Menyimpan waktu dalam format 'H:i:s'
    }

    public function getJamKeluarAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function setJamKeluarAttribute($value)
    {
        $this->attributes['jam_keluar'] = Carbon::createFromFormat('H:i', $value)->toTimeString(); // Menyimpan waktu dalam format 'H:i:s'
    }
}
