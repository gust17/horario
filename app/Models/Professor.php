<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;



    protected $fillable = ['name','materia_id'];


    public function disponibilidades(){
        return $this->hasMany(Disponibilidade::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
