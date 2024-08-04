<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;


    protected $fillable = [
        'turno_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'horario_turma_professor')
            ->withPivot('professor_id');
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'horario_turma_professor')
            ->withPivot('turma_id');
    }
}
