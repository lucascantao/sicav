<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'documento',
        'tipo_documento',
        'email',
        'sexo',
        'data_nascimento',
        'telefone1',
        'telefone2',
        'foto1',
        'foto2',
        'usuario_cadastro_id',
        'updated_by',
    ];

    public function usuario_cadastro(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_cadastro_id');
    }
    public function visita(): HasMany
    {
        return $this->hasMany(Visita::class);
    }
}
