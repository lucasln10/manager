<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'data_criacao',
        'data_vencimento',
        'data_conclusao',
        'concluida',
        'urgente',
        'atrasada',
        'cancelada',
        'pendente',
        'funcionario_id',
        'departamento_id',
        'cargo_id',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
