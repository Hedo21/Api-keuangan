<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keuangan extends Model
{
    public function keuangan()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    protected $table = "keuangans";
    protected $fillable = ['uang_masuk', 'uang_keluar'];
    use HasFactory;
}
