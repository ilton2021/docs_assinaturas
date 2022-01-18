<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedores;
use App\Models\Loggers;
use Validator;
use DB;

class FornecedoresController extends Controller
{
    public function cadastroForn(){
        $fornecedores = Fornecedores::all();
        return view('fornecedores/cadastro_fornecedor', compact('fornecedores'));
    }

    public function novoForn(){
        return view('fornecedores/novo_fornecedor');
    }

    public function storeForn(Request $request){
        $input = $request->all();
       	$validator = Validator::make($request->all(), [
		    'nome'          => 'required|max:255',
            'tipo_contrato' => 'required|max:255',
            'tipo_pessoa'   => 'required|max:255',
            'cnpj_cpf'      => 'required|max:20',
            'email'         => 'required|max:255|email'
		]);
		if ($validator->fails()) {
			return view('fornecedores/novo_fornecedor')
		        		->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$fornecedores = Fornecedores::create($input);
            $loggers = Loggers::create($input);
		    $fornecedores = Fornecedores::all();
            $validator  = 'Fornecedor Cadastrado com Sucesso!';
			return view('fornecedores/cadastro_fornecedor', compact('fornecedores'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
    }

    public function alterarForn($id){
        $fornecedores = Fornecedores::where('id',$id)->get();
        return view('fornecedores/alterar_fornecedor', compact('fornecedores'));
    }

    public function updateForn($id, Request $request){
        $input = $request->all();
		$validator = Validator::make($request->all(), [
			'nome'          => 'required|max:255',
            'tipo_contrato' => 'required|max:255',
            'tipo_pessoa'   => 'required|max:255',
            'cnpj_cpf'      => 'required|max:20',
            'email'         => 'required|max:255|email'
		]);
		if ($validator->fails()) {
			return view('fornecedores/nova_fornecedor')
		    			->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}else {
			$fornecedores = Fornecedores::find($id); 
			$fornecedores->update($input);
			$loggers = Loggers::create($input);
			$fornecedores = Fornecedores::all();
			$validator ='Fornecedor Alterado com Sucesso!';
			return view('fornecedores/cadastro_fornecedor', compact('fornecedores'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		}
	}

    public function excluirForn($id){
        $fornecedores = Fornecedores::where('id',$id)->get();
        return view('fornecedores/excluir_fornecedor', compact('fornecedores'));
    }

    public function deleteForn($id, Request $request){
        Fornecedores::find($id)->delete();
        $input   = $request->all();
		$loggers = Loggers::create($input);
		$fornecedores = Fornecedores::all();
        $validator    = 'Fornecedor excluído com sucesso!';
		return view('fornecedores/cadastro_fornecedor', compact('fornecedores'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
