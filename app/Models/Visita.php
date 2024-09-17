<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'motivo',
        'numero_cracha',
        'pessoa_id',
        'setor_id',
        'usuario_cadastro_id',
        'empresa_id',
        'servidor',
        'unidade_id',
        'updated_by',
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function usuario_cadastro(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_cadastro_id');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
