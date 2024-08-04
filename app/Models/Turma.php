<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'turno_id',
        'serie',
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'horario_turma_professor')
            ->withPivot('professor_id');
    }
}
