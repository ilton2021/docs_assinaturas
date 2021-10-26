<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentos;
use App\Models\Unidades;
use Auth;
use App\Models\Gestor;
use Validator;

class DocumentosController extends Controller
{
    public function cadastroDoc()
    {
        $documentos = Documentos::all();
        return view('cadastro_documento', compact('documentos'));
    }

    public function novoDoc()
    {
        $unidades = Unidades::all();
        return view('novo_documento', compact('unidades'));
    }

    public function storeDoc(Request $request)
    {
        $input = $request->all();
        $input['tipo'] = 1;
        $input['solicitante_id'] = Auth::user()->id;
		$nome = $_FILES['imagem']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('imagem') === NULL) {	
			$validator = 'Selecione um documento!';
			return view('novo_documento', compact('unidades'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao == 'pdf') {
				$validator = Validator::make($request->all(), [
					'nome'  => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('novo_documento', compact('unidades'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}else {
					$request->file('imagem')->move('../public/storage/documento/', $nome);
					$input['imagem'] = $nome; 
					$input['caminho'] = 'documento/'.$nome; 
					$documento  = Documentos::create($input);
					$documentos = Documentos::all();
                    $validator  = 'Documento Cadastrado com Sucesso!';
					return view('cadastro_documento', compact('documentos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só é permitido documentos: .pdf!';		
				return view('novo_documento')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
		}
    }

    public function alterarDoc($id, Request $request)
    {
        $documentos = Documentos::where('id',$id)->get();
		$unidades = Unidades::all();

        return view('alterar_documento', compact('documentos','unidades'));
    }


	public function updateDoc($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
			'nome' => 'required|max:255',
		]);
        if ($validator->fails()) {
			$documentos = Documentos::where('id',$id)->get();
			$unidades = Unidades::all();
			return view('alterar_documento', compact('documentos','unidades'))
				  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
		} else {
            $documentos = Documentos::find($id);
            $documentos = $documentos->update($input);
            $documentos = Documentos::all();
            $validator = "Documento Alterado com Sucesso!!";
            return view('cadastro_documento', compact('documentos'))
				  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
        }
    }




    public function excluirDoc($id, Request $request)
    {
        $documentos = Documentos::where('id',$id)->get();
		$unidades = Unidades::all();
        return view('excluir_documento', compact('documentos','unidades'));
    }


	public function destroyDoc($id, Request $request)
    {
        $input = $request->all();
        $documentos = Documentos::find($id);
        $documentos = $documentos->delete($input);
        $documentos = Documentos::all();
        $validator = "Documento Excluído com Sucesso!!";
        return view('cadastro_documento', compact('documentos'))
				  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
    }
	



	public function pesquisarDocumento()
	{
		$unidades = Unidades::all();
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
		$id = $documentos[0]->unidade_id;
		$id_Gestor = Auth::user()->id;
        $gestor = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor = Gestor::where('id',$id_GestorImediato)->get();
		$idD = $documentos[0]->id;
		return redirect()->route('fluxo', [$id])
				->with('documentos','gestor','idD');
	}
}
