<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Visita;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';
    protected $fillable = [
        'nome',
        'status',
        'usuario_rede',
        'setor_id'
    ];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

}
