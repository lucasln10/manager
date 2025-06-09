<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sigla',
        'user_id',
    ];

    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'departamento_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'departamento_id');
    }
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'departamento_id');
    }
}
