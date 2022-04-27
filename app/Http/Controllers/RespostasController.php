<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respostas;
use App\Models\Funcao;
use App\Models\Loggers;
use DB;
use Validator;

class RespostasController extends Controller
{
    public function cadastroRespostas(){
        $respostas = Respostas::all();
        $funcoes   = Funcao::all();
        return view('respostas/cadastro_respostas', compact('respostas','funcoes'));
    }

    public function novaRespostas(){
        $funcoes = Funcao::all();
        return view('respostas/novo_respostas', compact('funcoes'));
    }

    public function storeRespostas(Request $request){
        $input = $request->all();
       	$validator = Validator::make($request->all(), [
		    'descricao' => 'required|max:255',
            'funcao_id' => 'required'
		]);
		if ($validator->fails()) {
			return view('respostas/novo_respostas',compact('funcoes'))
		        		->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$respostas = Respostas::create($input);
            $loggers   = Loggers::create($input);
            $respostas = Respostas::all();
		    $funcoes   = Funcao::all();
            $validator = 'Resposta Cadastrada com Sucesso!';
			return view('respostas/cadastro_respostas', compact('respostas','funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
    }

    public function alterarRespostas($id){
        $respostas = Respostas::where('id',$id)->get();
        $funcoes   = Funcao::all();
        return view('respostas/alterar_respostas', compact('respostas','funcoes'));
    }

    public function updateRespostas($id, Request $request){
        $input = $request->all();
		$validator = Validator::make($request->all(), [
			'descricao' => 'required|max:255',
            'funcao_id' => 'required'
		]);
		if ($validator->fails()) {
			return view('respostas/novo_respostas')
		    			->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$respostas = Respostas::find($id); 
			$respostas->update($input);
			$loggers = Loggers::create($input);
			$respostas = Respostas::all();
            $funcoes   = Funcao::all();
			$validator ='Resposta Alterada com Sucesso!';
			return view('respostas/cadastro_respostas', compact('respostas','funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
	}

    public function excluirRespostas($id){
        $respostas = Respostas::where('id',$id)->get();
        $funcoes   = Funcao::all();
        return view('respostas/excluir_respostas', compact('respostas','funcoes'));
    }

    public function deleteRespostas($id, Request $request){
        Respostas::find($id)->delete();
        $input     = $request->all();
		$loggers   = Loggers::create($input);
        $respostas = Respostas::all();
		$funcoes   = Funcao::all();
        $validator = 'Resposta excluída com sucesso!';
		return view('respostas/cadastro_respostas', compact('respostas','funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
