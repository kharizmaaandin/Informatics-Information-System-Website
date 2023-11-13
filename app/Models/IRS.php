<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    public $timestamps = false;
    protected $table = 'irs';
    protected $primaryKey = 'id_irs';
    protected $fillable = ['id_irs','smst_aktif', 'jumlah_sks', 'berkas_irs', 'NIM'];
    public $incrementing = false;

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }
    use HasFactory;
}
