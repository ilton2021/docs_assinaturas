<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcao;
use App\Models\Loggers;
use DB;
use Validator;

class FuncaoController extends Controller
{
    public function cadastroFuncoes(){
        $funcoes = Funcao::all();
        return view('funcoes/cadastro_funcoes', compact('funcoes'));
    }

    public function novoFuncoes(){
        return view('funcoes/novo_funcoes');
    }

    public function storeFuncoes(Request $request){
        $input = $request->all();
       	$validator = Validator::make($request->all(), [
		    'descricao' => 'required|max:255'
		]);
		if ($validator->fails()) {
			return view('funcoes/novo_funcoes')
		        		->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$funcoes = Funcao::create($input);
            $loggers = Loggers::create($input);
		    $funcoes = Funcao::all();
            $validator  = 'Função Cadastrada com Sucesso!';
			return view('funcoes/cadastro_funcoes', compact('funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
    }

    public function alterarFuncoes($id){
        $funcoes = Funcao::where('id',$id)->get();
        return view('funcoes/alterar_funcoes', compact('funcoes'));
    }

    public function updateFuncoes($id, Request $request){
        $input = $request->all();
		$validator = Validator::make($request->all(), [
			'descricao' => 'required|max:255'
		]);
		if ($validator->fails()) {
			return view('funcoes/novo_funcoes')
		    			->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$funcoes = Funcao::find($id); 
			$funcoes->update($input);
			$loggers = Loggers::create($input);
			$funcoes = Funcao::all();
			$validator ='Função Alterada com Sucesso!';
			return view('funcoes/cadastro_funcoes', compact('funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
	}

    public function excluirFuncoes($id){
        $funcoes = Funcao::where('id',$id)->get();
        return view('funcoes/excluir_funcoes', compact('funcoes'));
    }

    public function deleteFuncoes($id, Request $request){
        Funcao::find($id)->delete();
        $input     = $request->all();
		$loggers   = Loggers::create($input);
		$funcoes   = Funcao::all();
        $validator = 'Função excluída com sucesso!';
		return view('funcoes/cadastro_funcoes', compact('funcoes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
