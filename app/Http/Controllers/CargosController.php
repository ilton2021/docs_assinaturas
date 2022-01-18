<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargos;
use DB;
use Validator;

class CargosController extends Controller
{
    public function cadastroCarg(){
        $cargos = Cargos::orderby('nome','ASC')->paginate(30);
        return view('cargos/cadastro_cargo', compact('cargos'));
    }

    public function novoCarg(){
        return view('cargos/novo_cargo');
    }

    public function storeCarg(Request $request){
        $input = $request->all();
       	$validator = Validator::make($request->all(), [
		    'nome' => 'required|max:255'
		]);
		if ($validator->fails()) {
			return view('cargos/novo_cargo')
		        		->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$cargos  = Cargos::create($input);
            $loggers = Loggers::create($input);
		    $cargos  = Cargos::all();
            $validator  = 'Cargo Cadastrado com Sucesso!';
			return view('cargos/cadastro_cargo', compact('cargos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
    }

    public function alterarCarg($id){
        $cargos = Cargos::where('id',$id)->get();
        return view('cargos/alterar_cargo', compact('cargos'));
    }

    public function updateCarg($id, Request $request){
        $input = $request->all();
		$validator = Validator::make($request->all(), [
			'nome' => 'required|max:255'
		]);
		if ($validator->fails()) {
			return view('cargos/novo_cargo')
		    			->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$cargos = Cargos::find($id); 
			$cargos->update($input);
			$loggers = Loggers::create($input);
			$cargos = Cargos::all();
			$validator ='Cargo Alterado com Sucesso!';
			return view('cargos/cadastro_cargo', compact('cargos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
	}

    public function excluirCarg($id){
        $cargos = Cargos::where('id',$id)->get();
        return view('cargos/excluir_cargo', compact('cargos'));
    }

    public function deleteCarg($id, Request $request){
        Cargos::find($id)->delete();
        $input     = $request->all();
		$loggers   = Loggers::create($input);
		$cargos    = Cargos::all();
        $validator = 'Cargo excluído com sucesso!';
		return view('cargos/cadastro_cargo', compact('cargos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
