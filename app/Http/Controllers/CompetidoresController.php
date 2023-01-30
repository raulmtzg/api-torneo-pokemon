<?php

namespace App\Http\Controllers;

use App\Models\Competidores;
use App\Models\Configuracion;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompetidoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $competidores = Competidores::query()->paginate(perPage:5);
        $data = array();        
        foreach ($competidores as $competidor) {
            $pokemons = Pokemon::where('competidor_id', $competidor->id)->get();
            $arrTemp = array('entrenador' => $competidor, 'pokemons' => $pokemons);
            array_push($data, $arrTemp);          
        }

        $result = array('entrenadores'=>$data, 'paginate' => $competidores);

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:competidores',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',            
        ]);

        if( $validator->fails() ){
            return response()->json([
                'err' => $validator->errors(),
                'status' => false,                
            ],400);           
        }

        
        $bases_torneo = Configuracion::all();

        if(!$bases_torneo[0]->is_open){
            return response()->json([
                'message' =>'El periodo de inscripciones terminó',
                'status' => false,                
            ],200); 
        }

        $competidor = new Competidores;
        
            $competidor->nombre = $request->nombre;
            $competidor->apellidos = $request->apellidos;
            $competidor->correo = $request->correo;
            $competidor->fecha_nacimiento = $request->fecha_nacimiento;            
            $competidor->save();

        foreach ($request->pokemones as $pokemon) {
            $jugador = new Pokemon;
            $jugador->pokemon_id = $pokemon['id'];
            $jugador->nombre = $pokemon['name'];
            $jugador->tipo = $pokemon['type'];
            $jugador->hp = $pokemon['hp'];
            $jugador->ataque = $pokemon['attack'];
            $jugador->defensa = $pokemon['defense'];
            $jugador->competidor_id = $competidor->id;

            $jugador->save();

        }

        return response()->json([
            'competidor' =>$competidor,
            'message' =>'Registro exitoso!!!',
            'status' => true,                
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Competidores  $competidores
     * @return \Illuminate\Http\Response
     */
    public function show(Competidores $competidores)
    {
        
        return $competidores;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Competidores  $competidores
     * @return \Illuminate\Http\Response
     */
    public function edit(Competidores $competidores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competidores  $competidores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competidores $competidores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Competidores  $competidores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competidores $competidores)
    {
        //
    }
}
