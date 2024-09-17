<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versao extends Model
{
    use HasFactory;
    protected $fillable = [
        'versao',
        'data',
        'descricao'
    ];

    public $timestamps = false;

    protected $table = 'versao';
}
