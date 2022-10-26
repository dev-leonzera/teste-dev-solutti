<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['loja_id', 'nome', 'valor', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function getValorAttribute()
    {
        $valor = $this->attributes['valor'];
        return 'R$ ' . number_format($valor, 2, ',', '');
    }

    public function loja()
    {
        return $this->belongsTo(Loja::class);
    }
}
