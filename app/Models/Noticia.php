<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    
    protected $table = 'noticia';
    protected $fillable = ['titulo', 'textonoticia', 'imagen', 'autor', 'fechanoticia'];
    
    public function comentarios() 
    {
        return $this->hasMany('App\Models\Comentario', 'idnoticia', 'id');
    }
}