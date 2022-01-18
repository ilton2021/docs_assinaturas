<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestor;
use App\Models\Loggers;
use App\Models\Unidades;
use App\Models\Cargos;
use App\Models\Funcao;
use App\Models\User;
use Validator;
use DB;

class GestorController extends Controller
{
    public function cadastroGest(){
        $gestores = Gestor::all();
        $unidades = Unidades::all();
        return view('gestores/cadastro_gestor', compact('gestores','unidades'));
    }

    public function novoGest(){
        $funcoes  = Funcao::orderby('descricao','ASC')->get();
        $unidades = Unidades::all();
        $cargos   = Cargos::orderby('NOME','ASC')->get();
        $users    = User::all();
        return view('gestores/novo_gestor', compact('funcoes','unidades','cargos','users'));
    }

    public function pesquisarGestor(Request $request)
    {
        $input = $request->all();
        if(empty($input['pesq'])) { $input['pesq'] = ""; }
        if(empty($input['pesq2'])) { $input['pesq2'] = ""; }
		$pesq  = $input['pesq'];
        $pesq2 = $input['pesq2'];
        if($pesq != ""){
            if($pesq2 == "nome") {
                $gestores = DB::table('gestor')->where('nome','like','%'.$pesq.'%')->get();
            } else if($pesq2 == "email") {
                $gestores = DB::table('gestor')->where('email','like','%'.$pesq.'%')->get();
            } else if($pesq2 == "cpf") {
                $gestores = DB::table('gestor')->where('cpf','like','%'.$pesq.'%')->get();
            }
        } else {
            $gestores = Gestor::all();
        }
        return view('gestores/cadastro_gestor', compact('gestores','pesq','pesq2'));
    }

    public function storeGest(Request $request){
        $input    = $request->all();
        $cargos   = Cargos::all();
        $funcoes  = Funcao::all();
        $unidades = Unidades::all();
        $users    = User::all();
        $nome     = $_FILES['carimbo']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('carimbo') === NULL) {	
			$validator = 'Selecione um Carimbo!';
			return view('gestores/novo_gestor', compact('cargos','funcoes','unidades','users'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png' || $extensao == 'JPG' || $extensao == 'JPEG' || $extensao == 'PNG') {
                $validator = Validator::make($request->all(), [
                    'nome'      => 'required|max:255',
                    'matricula' => 'required|max:255',
                    'email'     => 'required|max:255|email',
                    'cpf'       => 'required|max:20'
                ]);
                if ($validator->fails()) {
                    return view('gestores/novo_gestor', compact('cargos','funcoes','unidades','users'))
                                ->withErrors($validator)
                                ->withInput(session()->flashInput($request->input()));
                }else {
                    $request->file('carimbo')->move('../public/storage/carimbo/', $nome);
					$input['carimbo']  = $nome; 
					$input['caminho'] = 'carimbo/'.$nome; 
                    $gestores  = Gestor::create($input);
                    $loggers   = Loggers::create($input);
                    $gestores  = Gestor::all();
                    $validator = 'Gestor Cadastrado com Sucesso!';
                    return view('gestores/cadastro_gestor', compact('gestores','unidades'))
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

    public function alterarGest($id){
        $gestores = Gestor::where('id',$id)->get();
        $funcoes  = Funcao::all();
        $unidades = Unidades::all();
        $cargos   = Cargos::all();
        $users    = User::all();
        return view('gestores/alterar_gestor', compact('gestores','funcoes','unidades','cargos','users'));
    }

    public function updateGest($id, Request $request){
        $input    = $request->all();
        $cargos   = Cargos::all();
        $funcoes  = Funcao::all();
        $unidades = Unidades::all();
        $users    = User::all();
        $gestores = Gestor::where('id',$id)->get();
        $nome1 = "";
		if($request->file('carimbo') === NULL && $input['carimbo_'] == "") {	
			$validator = 'Selecione o Carimbo do Gestor!!';		
			return view('gestores/alterar_gestor', compact('gestores','cargos','funcoes','unidades','users'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		} else {
			if($request->file('carimbo') !== null) {
			   $nome1 = $_FILES['carimbo']['name'];
			   $extensao = pathinfo($nome1, PATHINFO_EXTENSION);
			} else {
			   $nome2 = $input['carimbo_'];	
			   $extensao = pathinfo($nome2, PATHINFO_EXTENSION);
			}			
			if($extensao == 'jpg' || $extensao == 'png' || $extensao == 'jpeg' || $extensao == 'JPG' || $extensao == 'PNG' || $extensao == 'JPEG') {
                $validator = Validator::make($request->all(), [
                    'nome'      => 'required|max:255',
                    'matricula' => 'required|max:255',
                    'email'     => 'required|max:255|email',
                    'cpf'       => 'required|max:20'
                ]);
                if ($validator->fails()) {
                    return view('gestores/alterar_gestor', compact('gestores','cargos','funcoes','unidades','users'))
                                ->withErrors($validator)
                                ->withInput(session()->flashInput($request->input()));
                }else {
                    if($nome1 != "") {
                        $request->file('carimbo')->move('../public/storage/carimbo/', $nome1);
                        $input['carimbo'] = $nome1; 
                        $input['caminho'] = 'carimbo/'.$nome1; 
                    } 
                    $gestores  = Gestor::find($id); 
                    $gestores->update($input);
                    $loggers   = Loggers::create($input);
                    $gestores  = Gestor::all();
                    $validator = 'Gestor Alterado com Sucesso!';
                    return view('gestores/cadastro_gestor', compact('gestores','unidades'))
                                ->withErrors($validator)
                                ->withInput(session()->flashInput($request->input()));
                }
            } else {
                $validator = 'Só é permitido imagens: .jpg, .jpeg ou .png!';		
				return view('gestores/alterar_gestor', compact('gestores','cargos','funcoes','unidades','users'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
            }
        }
    }

    public function excluirGest($id){
        $gestores = Gestor::where('id',$id)->get();
        return view('gestores/excluir_gestor', compact('gestores'));
    }

    public function deleteGest($id, Request $request){
        $input     = $request->all();
        $data = Gestor::find($id);
		$image_path = public_path().'/storage/'.$data->caminho;
        unlink($image_path);
        $data->delete();
		$loggers   = Loggers::create($input);
		$gestores  = Gestor::all();
        $unidades  = Unidades::all();
        $validator = 'Gestor excluído com sucesso!';
		return view('gestores/cadastro_gestor', compact('gestores','unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
    }
}
