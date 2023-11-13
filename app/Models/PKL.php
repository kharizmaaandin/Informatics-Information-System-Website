<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    public $timestamps = false;
    protected $table = 'pkl';
    protected $primaryKey = 'NIM';
    protected $fillable = ['NIM', 'status_pkl', 'nilai_pkl', 'berkas'];
    public $incrementing = false;

    use HasFactory;
}
