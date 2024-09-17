<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao'
    ];

    protected $table = 'perfis';

    public function users(): HasMany 
    {
        return $this->hasMany(User::class);
    }
}
