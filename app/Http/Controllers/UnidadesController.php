<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidades;
use App\Models\Loggers;
use Storage;
use DB;
use Validator;

class UnidadesController extends Controller
{
    public function cadastroUnd(){
        $unidades = Unidades::all();
        return view('unidades/cadastro_unidades', compact('unidades'));
    }

    public function novaUnd(){
        return view('unidades/nova_unidade');
    }

    public function storeUnd(Request $request){
        $input = $request->all();
        $nome  = $_FILES['imagem']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('imagem') === NULL) {	
			$validator = 'Selecione uma Imagem!';
			return view('unidades/nova_unidade')
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png') {
				$validator = Validator::make($request->all(), [
					'nome'  => 'required|max:255',
                    'sigla' => 'required|max:10'
				]);
				if ($validator->fails()) {
					return view('unidades/nova_unidade')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}else {
					$request->file('imagem')->move('../public/storage/unidades/', $nome);
					$input['imagem']  = $nome; 
					$input['caminho'] = 'unidades/'.$nome; 
					$unidades = Unidades::create($input);
                    $loggers = Loggers::create($input);
					$unidades = Unidades::all();
                    $validator  = 'Unidade Cadastrada com Sucesso!';
					return view('unidades/cadastro_unidades', compact('unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só é permitido imagens: .jpg, .jpeg ou .png!';		
				return view('unidades/nova_unidade')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
		}
    }

    public function alterarUnd($id){
        $unidades = Unidades::where('id',$id)->get();
        return view('unidades/alterar_unidade', compact('unidades'));
    }

    public function updateUnd($id, Request $request){
        $input = $request->all();
		$nome1 = "";
		if($request->file('imagem') === NULL && $input['imagem_'] == "") {	
			$validator = 'Selecione a imagem da Unidade!!';		
			return view('unidades/nova_unidade')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		} else {
			if($request->file('imagem') !== null) {
			   $nome1 = $_FILES['imagem']['name'];
			   $extensao = pathinfo($nome1, PATHINFO_EXTENSION);
			} else {
			   $nome2 = $input['imagem_'];	
			   $extensao = pathinfo($nome2, PATHINFO_EXTENSION);
			}			
			if($extensao == 'jpg' || $extensao == 'png' || $extensao == 'jpeg' || $extensao == 'JPG' || $extensao == 'PNG' || $extensao == 'JPEG') {
				$validator = Validator::make($request->all(), [
					'nome'  => 'required|max:255',
					'sigla' => 'required|max:20'
				]);
				if ($validator->fails()) {
					return view('unidades/nova_unidade')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}else {
					if($nome1 != "") {
					  $request->file('imagem')->move('../public/storage/unidades/', $nome1);
					  $input['imagem'] = $nome1; 
					  $input['caminho'] = 'unidades/'.$nome1; 
					} 
					$unidade = Unidades::find($id); 
					$unidade->update($input);
					$loggers = Loggers::create($input);
					$unidades = Unidades::all();
					$validator ='Unidade Alterada com Sucesso!';
					return view('unidades/cadastro_unidades', compact('unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só é permitido imagens: .jpg, .jpeg ou .png!';
				return view('unidades/nova_unidade')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
		}
    }

    public function excluirUnd($id){
        $unidades = Unidades::where('id',$id)->get();
        return view('unidades/excluir_unidade', compact('unidades'));
    }

    public function deleteUnd($id, Request $request){
        $input = $request->all();		
		$data = Unidades::find($id);
		$image_path = public_path().'/storage/'.$data->caminho;
        unlink($image_path);
        $data->delete();
		$loggers = Loggers::create($input);
		$unidades = Unidades::all();
        $validator = 'Unidade excluída com sucesso!';
		return view('unidades/cadastro_unidades', compact('unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
