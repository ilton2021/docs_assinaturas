<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidades;
use App\Models\Documentos;
use App\Models\Gestor;
use App\Models\Aprovacao;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $unidades = Unidades::all();
        return view('home', compact('unidades'));
    }

    public function escolher_unidade()
    {
        $unidades = Unidades::all();
        return view('escolher_unidade', compact('unidades'));
    }

    public function fluxo($id)
    {
        $documentos = Documentos::where('unidade_id',$id)->get();
        $id_Gestor = Auth::user()->id;
        $gestor = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor = Gestor::where('id',$id_GestorImediato)->get();
        return view('comecar_fluxo_doc', compact('documentos','gestor'));
    }

    public function storeFluxo($id, Request $request)
    {
        $input = $request->all();
        $input['ativo']      = 1;
        $input['unidade_id'] = $id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        
        $aprovacao = Aprovacao::create($input);
        $validator = "O Documento está no Fluxo!!";
        return view('home')
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));						
    }

    public function validar_fluxo($id)
    {
        $id_Gestor = Auth::user()->id;
        $gestor    = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor     = Gestor::where('id',$id_GestorImediato)->get();
        $documentos = Documentos::where('id',$id)->get();
        $aprovacao  = Aprovacao::where('documento_id',$documentos[0]->id)->get();
        return view('validar_fluxo', compact('documentos','gestor','aprovacao'));
    }

    public function storeValidar_fluxo($id, Request $request)
    {
        $documentos = Documentos::where('id',$id)->get();
        $input = $request->all();
        $input['ativo'] = 1;
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $input['data_prevista']  = date('Y-m-d', strtotime($input['data_prevista']));
        $aprovacao = Aprovacao::create($input);
        $validator = "Documento Validado com Sucesso!!";
        return view('home')
                ->withErros($validator)
                ->withInput(session()->flashInput($request->input()));
    }

    public function validarDocs($id)
    {
        $documentos = Documentos::where('unidade_id',$id)->get();
        $idG = Auth::user()->id;
        $aprovacao = Aprovacao::where('gestor_id',$idG)->where('ativo',1)->get();
        $aprovacoes = Aprovacao::where('documento_id',$documentos[0]->id)->get();
        $gestores = Gestor::all(); 
        return view('validar_documentos', compact('documentos','aprovacao','gestores','aprovacoes'));
    }
}
