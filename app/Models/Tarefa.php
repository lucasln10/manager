<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarefa extends Model
{
    use HasFactory;
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
        'user_id'
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
