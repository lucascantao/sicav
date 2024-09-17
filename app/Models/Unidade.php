<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'deleted_at'
    ];

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class);
    }
}
