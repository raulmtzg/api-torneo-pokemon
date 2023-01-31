<?php

namespace App\Http\Controllers;

use App\Models\Competidores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    public function entrenadores()
    {
        
        $totalEntrenadores = DB::table('competidores')->count();

        return response()->json([
            'totalEntrenadores' =>$totalEntrenadores,
            'status' => true,                
        ],200);
        

    }

    public function pokemonPopular()
    {
        
        $pokemon = DB::table('pokemon')
                 ->select('nombre', 'pokemon_id', DB::raw('count(*) as total'))
                 ->groupBy('nombre','pokemon_id')
                 ->orderBy('total','desc')
                 ->limit(1)
                 ->get();

        return response()->json([
            'pokemon' =>$pokemon,
            'status' => true,                
        ],200);
        

    }

    public function pokemonsTop()
    {
        
        $pokemons = DB::table('pokemon')
                 ->select('nombre', 'pokemon_id', DB::raw('count(*) as total'))
                 ->groupBy('nombre','pokemon_id')
                 ->orderBy('total','desc')
                 ->limit(5)
                 ->get();
        
        $suma = 0;

        foreach ($pokemons as $pokemon) {
            $suma += $pokemon->total;
        }

        $result = array();
        foreach ($pokemons as $pokemon) {
            $porcentaje = (100 * $pokemon->total)/$suma;
            $porcentaje = round($porcentaje, 0);
            $arrTemp = array(
                'nombre' => $pokemon->nombre,
                'pokemon_id' => $pokemon->pokemon_id,
                'total' => $pokemon->total,
                'porcentaje' => $porcentaje
            );
            array_push($result, $arrTemp);            
        }

        return response()->json([
            'pokemons' =>$result,
            'total' => $suma,
            'status' => true,                
        ],200);
        
    }

    public function pokemonsHp()
    {
        
        $pokemons = DB::table('pokemon')
                ->distinct()            
                 ->select('nombre','hp', 'pokemon_id')                 
                 ->orderBy('hp','desc')
                 ->limit(5)
                 ->get();
        
        $total = 0;


        foreach ($pokemons as $pokemon) {
            $total += $pokemon->hp;
        }

        $result = array();

        foreach ($pokemons as $pokemon) {
            $porcentaje = (100 * $pokemon->hp)/$total;
            $porcentaje = round($porcentaje, 0);
            $arrTemp = array(
                'nombre' => $pokemon->nombre,
                'hp' => $pokemon->hp,
                'pokemon_id' => $pokemon->pokemon_id,
                'porcentaje' => $porcentaje
            );
            array_push($result, $arrTemp);            
        }

        return response()->json([
            'pokemons' =>$result,
            'total' => $total,
            'status' => true,                
        ],200);
        
    }

    public function pokemonsTipos()
    {
        
        $pokemons = DB::table('pokemon')
                 ->select('tipo', DB::raw('count(*) as total')) 
                 ->groupBy('tipo')                
                 ->orderBy('total','desc')                 
                 ->get();
                
        return response()->json([
            'pokemons' =>$pokemons,            
            'status' => true,                
        ],200);
        
    }


}
