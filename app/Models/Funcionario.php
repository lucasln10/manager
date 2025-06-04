<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cargo;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nascimento',
        'email',
        'cpf',
        'telefone',
        'image',
        'cargo_id',
        'departamento_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'funcionario_id');
    }
}
