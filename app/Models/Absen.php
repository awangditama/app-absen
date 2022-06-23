<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'user_absens';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'status_masuk'
   ];
}
