<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    
    protected $table = 'comentario';
    
    protected $fillable = ['idnoticia', 'textocomentario', 'fechacomentario', 'email'];
    
    public function noticia()
    {
        return $this->belongsTo('App\Models\Noticia', 'idnoticia', 'id');
    }
}
