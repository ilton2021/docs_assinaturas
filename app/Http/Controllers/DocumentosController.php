<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentos;
use App\Models\Unidades;
use App\Models\Fornecedores;
use App\Models\Loggers;
use App\Models\Aprovacao;
use Auth;
use App\Models\Gestor;
use Validator;
use DB;

class DocumentosController extends Controller
{
    public function cadastroDoc()
    {
        $documentos   = Documentos::all();
		$fornecedores = Fornecedores::all();
        return view('documentos/cadastro_documento', compact('documentos','fornecedores'));
    }

    public function novoDoc()
    {
        $unidades = Unidades::all();
		$fornecedores = Fornecedores::all();
        return view('documentos/novo_documento', compact('unidades','fornecedores'));
    }

    public function storeDoc(Request $request)
    {
        $input = $request->all();
        $input['tipo'] 		= 1;
		$input['gestor_id'] = 0;
		$nome = $_FILES['imagem']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('imagem') === NULL) {	
			$validator = 'Selecione um documento!';
			return view('documentos/novo_documento', compact('unidades'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao == 'pdf') {
				$validator = Validator::make($request->all(), [
					'nome'  => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('documentos/novo_documento', compact('unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}else {
					$request->file('imagem')->move('../public/storage/documento/', $nome);
					$input['imagem']  = $nome; 
					$input['caminho'] = 'documento/'.$nome; 
					$unidades = Unidades::all();
					$qtdU = sizeof($unidades);
					$id_unidade = $input['unidade_id'];
					for($i = 1; $i <= $qtdU; $i++) {
						if($id_unidade == $i) {
							$doc   = DB::table('documentos')->where('unidade_id', $id_unidade)->max('ordem');
							$docs  = Documentos::where('unidade_id',$id_unidade)->get();
							$qtd1  = sizeof($docs);
							$sigla = Unidades::where('id',$id_unidade)->get();
							$sigla = $sigla[0]->sigla;
							$va    = 0;
							$hoje  = date('Y',(strtotime('now')));
							if($qtd1 == 0){
								$input['numeroDoc'] = $sigla.'1/'.$hoje;	
								$input['ordem']     = $doc + 1;								
							}else if($qtd1 > 0){
								$va 			    = $doc + 1;
								$input['numeroDoc'] = $sigla.$va.'/'.$hoje;
								$input['ordem']     = $doc + 1;								
							}
						}
					}
					$input['concluida'] = 0;
					$documento    = Documentos::create($input);
					$loggers      = Loggers::create($input);
					$documentos   = Documentos::all();
					$fornecedores = Fornecedores::all();
                    $validator  = 'Documento Cadastrado com Sucesso!';
					return view('documentos/cadastro_documento', compact('documentos','fornecedores'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só é permitido documentos: .pdf!';		
				return view('documentos/novo_documento')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
		}
    }

    public function alterarDoc($id, Request $request)
    {
		$aprovacao  = Aprovacao::where('documento_id',$id)->get();
		$id_ultimo  = DB::table('aprovacao')->where('documento_id',$id)->max('id');
		$aprov  	= Aprovacao::where('id',$id_ultimo)->get();
		$documentos = Documentos::all();
		$fornecedores = Fornecedores::all();
		$qtd = sizeof($aprovacao);
		$qtd = sizeof($aprovacao); 
		if($qtd > 0) {
			if ($aprov[0]->gestor_id == Auth::user()->id && $aprov[0]->fluxo == 1) {
				$documentos = Documentos::where('id',$id)->get();
				$unidades = Unidades::all();
				return view('documentos/alterar_documento', compact('documentos','unidades','fornecedores'));
			} else {
				$fornecedores = Fornecedores::all();
				$validator = 'Este Documento está em Aprovação! Você não pode alterá-lo!!!';
				return view('documentos/cadastro_documento', compact('documentos','fornecedores'))
						  ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));
			}
		} else {
			$documentos = Documentos::where('id',$id)->get();
			$unidades = Unidades::all();
			return view('documentos/alterar_documento', compact('documentos','unidades','fornecedores'));;
		}
    }


	public function updateDoc($id, Request $request)
    {
		$input = $request->all();
		$nome1 = "";
		if($request->file('imagem') === NULL && $input['imagem_'] == "") {	
			$validator = 'Selecione um Arquivo para o Documento!!';		
			return view('documentos/novo_documento')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		} else {
			if($request->file('imagem') !== null) {
			   $nome1    = $_FILES['imagem']['name'];
			   $extensao = pathinfo($nome1, PATHINFO_EXTENSION);
			} else {
			   $nome2    = $input['imagem_'];	
			   $extensao = pathinfo($nome2, PATHINFO_EXTENSION);
			}			
			if($extensao == 'pdf' || $extensao == 'PDF') {
				$validator = Validator::make($request->all(), [
					'nome' 			=> 'required|max:255',
					'fornecedor_id' => 'required|integer',
					'unidade_id'	=> 'required|integer'
				]);
				if ($validator->fails()) {
					$documentos = Documentos::where('id',$id)->get();
					$unidades   = Unidades::all();
					return view('documentos/alterar_documento', compact('documentos','unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					if($nome1 != "") {
						$request->file('imagem')->move('../public/storage/documento/', $nome1);
						$input['caminho'] = 'documento/'.$nome1;
						$data = Documentos::find($id);
						$image_path = public_path().'/storage/'.$data->caminho;
						unlink($image_path);
					} 
					$input['tipo'] 		= '1'; 
					$input['concluida'] = 0;
					$documentos   = Documentos::find($id);
					$documentos   = $documentos->update($input);
					$loggers      = Loggers::create($input);
					$documentos   = Documentos::all();
					$fornecedores = Fornecedores::all();
					$validator = "Documento Alterado com Sucesso!!";
					return view('documentos/cadastro_documento', compact('documentos','fornecedores'))
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

    public function excluirDoc($id, Request $request)
    {
		$aprovacao  = Aprovacao::where('documento_id',$id)->get();
		$id_ultimo  = DB::table('aprovacao')->where('documento_id',$id)->max('id');
		$aprov  	= Aprovacao::where('id',$id_ultimo)->get();
		$documentos = Documentos::all();
		$qtd = sizeof($aprovacao);
		if($qtd > 0) {
			if ($aprov[0]->gestor_id == Auth::user()->id && $aprov[0]->fluxo == 1) {
				$documentos = Documentos::where('id',$id)->get();
				$unidades = Unidades::all();
				return view('documentos/excluir_documento', compact('documentos','unidades'));
			} else {
				$fornecedores = Fornecedores::all();
				$validator = 'Este Documento está em Aprovação! Você não pode excluí-lo!!!';
				return view('documentos/cadastro_documento', compact('documentos','fornecedores'))
						  ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));
			}
		} else {
			$documentos = Documentos::where('id',$id)->get();
			$unidades = Unidades::all();
			return view('documentos/excluir_documento', compact('documentos','unidades'));
		}
    }

	public function destroyDoc($id, Request $request)
    {
        $input = $request->all();
        $data  = Documentos::find($id);
		$image_path = public_path().'/storage/'.$data->caminho;
        unlink($image_path);
        $data->delete();
		$loggers    = Loggers::create($input);
        $documentos = Documentos::all();
        $validator  = "Documento Excluído com Sucesso!!";
        return view('documentos/cadastro_documento', compact('documentos'))
				  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
    }

	public function pesquisarDocumento()
	{
		$unidades   = Unidades::all();
		$documentos = Documentos::where('unidade_id',0)->get();
		return view('pesquisar_documento', compact('unidades','documentos'));
	}

	public function pesqDocumento(Request $request)
	{
		$input = $request->all(); 
		$unidades = Unidades::all();
		if(empty($input['unidade_id'])) { $input['unidade_id'] = ""; }
		if(empty($input['nome'])) { $input['nome'] = ""; }
		$unidade = $input['unidade_id'];
		$nome    = $input['nome'];
		if($nome != ""){
			if($unidade == ""){
				$documentos = Documentos::where('nome','like','%'.$nome.'%')->get();
			} else {
				$documentos = Documentos::where('unidade_id',$unidade)->where('nome','like','%'.$nome.'%')->get();
			}
		} else {
			if($unidade == ""){
				$documentos = Documentos::all();
			} else {
				$documentos = Documentos::where('unidade_id',$unidade)->get();
			}
		} 
		return view('pesquisar_documento', compact('unidades','documentos'));
	}

	public function checkDoc($id)
	{ 
		$documentos = Documentos::where('id',$id)->get(); 
		$id 		= $documentos[0]->unidade_id;
		$id_Gestor  = Auth::user()->id;
        $gestor 	= Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor 		   = Gestor::where('id',$id_GestorImediato)->get();
		$idD 			   = $documentos[0]->id;
		return redirect()->route('fluxo', [$id])
				->with('documentos','gestor','idD');
	}
}
