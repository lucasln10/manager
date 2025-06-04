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
    ];

    public function cargo()
    {
        return $this->hasMany(Cargo::class, 'cargo_id');
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
