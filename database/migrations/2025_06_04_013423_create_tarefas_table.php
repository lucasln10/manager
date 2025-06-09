<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('descricao')->nullable();
            $table->boolean('concluida')->default(false);
            $table->boolean('urgente')->default(false);
            $table->date('data_criacao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_conclusao')->nullable();
            $table->boolean('atrasada')->default(false);
            $table->boolean('cancelada')->default(false);
            $table->boolean('pendente')->default(false);
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->foreignId('cargo_id')->constrained('cargos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
