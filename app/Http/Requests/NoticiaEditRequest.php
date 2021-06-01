<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo'        => 'required|min:4|max:150',
            'textonoticia'  => 'required|min:50',
            'autor'         => 'required|min:3|max:30',
            'fechanoticia'  => 'required|date', //|after_or_equal:today', -> Aquí podemos editar noticias sin cambiarle la fecha de publicación.
        ];
    }
    
    public function messages()
    {
        $required = 'El campo :attribute es obligatorio.';
        $min = 'El campo :attribute no tiene la longitud mínima requerida: :min';
        $max = 'El campo :attribute sobrepasa la longitud máxima permitida: :max';
        //$date = 'El campo :attribute tiene que ser igual o posterior al día de hoy.';
        
        return [
            'titulo.min'                    => $min,
            'titulo.max'                    => $max,
            'titulo.required'               => $required,
            'textonoticia.required'         => $required,
            'textonoticia.min'              => $min,
            'autor.required'                => $required,
            'autor.min'                     => $min,
            'autor.max'                     => $max,
            'fechanoticia.required'         =>$required,
            //'fechanoticia.after_or_equal'   =>$date,
            ];
    }
    
    public function attributes()
    {
        return [
            'titulo'        => 'Título de la Noticia',
            'textonoticia'  => 'Texto de la Noticia',
            'imagen'        => 'Imagen de la Noticia',
            'autor'         => 'Autor de la Noticia',
            'fechanoticia'  => 'Fecha de Publicación de la Noticia',
            ];
    }
}
