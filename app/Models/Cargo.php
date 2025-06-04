<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'descricao',
        'nivel',
        'departamento_id'
    ];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'cargo_id');
    }
}
