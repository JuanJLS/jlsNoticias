<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $text = $response->getOriginalContent();
        $array = 
            [
                'cabrón'        => '*****',
                'gilipollas'    => '*****',
                'hijo de puta'  => '*****',
                'mierda'        => '*****',
                'hija de puta'  => '*****',
                'zorra'         => '*****',
                'puta'          => '*****',
                'Cabrón'        => '*****',
                'Gilipollas'    => '*****',
                'Hijo de puta'  => '*****',
                'Mierda'        => '*****',
                'Hija de puta'  => '*****',
                'Zorra'         => '*****',
                'Puta'          => '*****',
                'polla'         => '*****',
                'Polla'         => '*****',
                'coño'          => '*****',
                'Coño'          => '*****',
                'vox'           => 'fascistas',
                ];
                
        foreach($array as $oldword => $newword) {
            $text = str_replace($oldword, $newword, $text);
        }
        $response->setContent($text);
        return $response;
    }
}
