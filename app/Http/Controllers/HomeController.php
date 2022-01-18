<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidades;
use App\Models\Documentos;
use App\Models\Gestor;
use App\Models\Aprovacao;
use Auth;
use Validator;
use Mail;
use DB;

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

    public function cadastroBasicos()
    {
        return view('cadastro_basicos');
    }

    public function escolher_unidade()
    {
        $unidades = Unidades::all();
        return view('escolher_unidade', compact('unidades'));
    }

    public function fluxo($id)
    {
        $documentos = Documentos::where('unidade_id',$id)->get();
        $id_Gestor  = Auth::user()->id;
        $gestor     = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor     = Gestor::where('id',$id_GestorImediato)->get();
        return view('comecar_fluxo_doc', compact('gestor','documentos'));
    }

    public function storeFluxo($id, Request $request)
    {
        $input = $request->all();
        $documentos          = Documentos::where('id',$id)->get();
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $id_Gestor           = Auth::user()->id;
        $gestor              = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato   = $gestor[0]->gestor_imediato_id;
        $gestorI             = Gestor::where('id',$id_GestorImediato)->get();
        $validator = Validator::make($request->all(), [
            'documento_id'  => 'required',
            'data_prevista' => 'required',
            'observacao'    => 'required'
        ]);
        if ($validator->fails()) {
            return view('comecar_fluxo_doc', compact('gestor','documentos'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            $input['ativo']      = 1;
            $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
            DB::statement('UPDATE documentos SET gestor_id = '.$id_GestorImediato.' WHERE id = '.$id.';');
            $nomeDoc = $documentos[0]->nome;
            $nome    = $input['solicitante'];
            $motivo  = $input['observacao'];
            $input['fluxo'] = 1;
            $email = 'ilton.albuquerque@hcpgestao.org.br';
            //Assinar Documento
            if($gestor[0]->funcao_id == 1) {
                Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
                    $m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
                    $m->subject('O Documento: '.$nomeDoc.' foi adicionado para validação!!!');
                    $m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
                    $m->to($email);
                });
            } else if($gestor[0]->funcao_id == 5) {
                Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
                    $m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
                    $m->subject('O Gestor: '.$nome.' Aprovou o Documento: '.$nomeDoc.'. Sua vez de validar!!!');
                    $m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
                    $m->to($email);
                });
            } else {
                Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
                    $m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
                    $m->subject('O Gestor: '.$nome.' Aprovou o Documento: '.$nomeDoc.'. Sua vez de validar!!!');
                    $m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
                    $m->to($email);
                });
            }
            $aprovacao = Aprovacao::create($input);
            $validator = "O Documento está no Fluxo!!";
            return redirect()->route('home');						
        } 
    }

    public function validar_fluxo($id)
    {
        $id_Gestor = Auth::user()->id;
        $gestor    = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor     = Gestor::where('id',$id_GestorImediato)->get();
        $documentos = Documentos::where('id',$id)->get();
        $aprovacao  = Aprovacao::where('documento_id',$id)->get();
        return view('validar_fluxo', compact('documentos','gestor','aprovacao'));
    }

    public function storeValidar_fluxo($id, Request $request)
    {
        $documentos = Documentos::where('id',$id)->get();
        $id_Gestor = Auth::user()->id;
        $input = $request->all();
        $funcao = Gestor::where('id',$id_Gestor)->get('funcao_id');
        if($funcao[0]->funcao_id == '5') {
            $input['fluxo'] = 2; 
            $aprovacao = Aprovacao::where('documento_id',$id)->get();
            $idGestor  = $aprovacao[0]->gestor_anterior_id;
            DB::statement('UPDATE documentos SET gestor_id = '.$id_Gestor.' WHERE id = '.$id.';');
        } else {
            $input['fluxo'] = 1;
            DB::statement('UPDATE documentos SET gestor_id = '.$id_Gestor.' WHERE id = '.$id.';');
        }
        $input['ativo'] = 1;
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $input['data_prevista']  = date('Y-m-d', strtotime($input['data_prevista']));
        
        $aprovacao = Aprovacao::create($input);
        
        $nomeDoc = $documentos[0]->nome;
        $nome    = $input['solicitante'];
        $motivo  = $input['observacao'];
        $email = 'ilton.albuquerque@hcpgestao.org.br';
        //Assinar Documento
        if($funcao[0]->funcao_id == '5') {
            Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
                $m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
                $m->subject('O Documento: '.$nomeDoc.' foi aprovado por todos no fluxo!!!');
                $m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
                $m->to($email);
            }); 
        } else {
            Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
                $m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
                $m->subject('O Gestor: '.$nome.' Aprovou o Documento: '.$nomeDoc.'!!!');
                $m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
                $m->to($email);
            });
        }
        $validator = "Documento Validado com Sucesso!!";
        return view('home')
                ->withErros($validator)
                ->withInput(session()->flashInput($request->input()));
    }

    public function validar_nfluxo($id, Request $request)
    {
        $id_Gestor = Auth::user()->id;
        $gestor    = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato = $gestor[0]->gestor_imediato_id;
        $gestor     = Gestor::where('id',$id_GestorImediato)->get();
        $documentos = Documentos::where('id',$id)->get();
        $aprovacao  = Aprovacao::where('documento_id',$documentos[0]->id)->get();
        return view('validar_nfluxo', compact('documentos','gestor','aprovacao'));
    }

    public function storenValidar_fluxo($id, Request $request)
    {
        $documentos = Documentos::where('id',$id)->get();
        $input = $request->all();
        DB::statement('UPDATE aprovacao SET ativo = 0 WHERE documento_id = '.$id.';');
        $id_Gestor = Auth::user()->id;
        DB::statement('UPDATE documentos SET gestor_id = '.$id_Gestor.' WHERE id = '.$id.';');
        $input['ativo'] = 1;
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $input['gestor_id'] = $documentos[0]->solicitante_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $input['data_prevista']  = date('Y-m-d', strtotime($input['data_prevista']));
        $input['fluxo'] = 1;
        $aprovacao = Aprovacao::create($input);
        $nomeDoc = $documentos[0]->nome;
        $nome    = $input['solicitante'];
        $motivo  = $input['observacao'];
        //Assinar Documento
        Mail::send([], [], function($m) use ($email,$motivo,$nome,$nomeDoc) { 
			$m->from('ilton.albuquerque@hcpgestao.org.br', 'Assinatura de Documentos');
			$m->subject('O Gestor: '.$nome.' Reprovou o Documento: '.$nomeDoc.', que precisa ser Corrigido!!!');
			$m->setBody($motivo .'! Acesse o portal da Assinatura dos Documentos: https://hcpgestao.org.br/docs_assinaturas');
			$m->to($email);
		});
        $validator = "Documento Validado com Sucesso!!";
        return view('home')
                ->withErros($validator)
                ->withInput(session()->flashInput($request->input()));
    }

    public function validarDocs()
    {
        $idG = Auth::user()->id;
        $aprovacao = DB::table('aprovacao')
        ->join('documentos','documentos.id','=','aprovacao.documento_id')
        ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
        'documentos.caminho as caminho')
        ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)
        ->get();        
        $aprovacoes = Aprovacao::all();
        $gestores = Gestor::all(); 
        return view('validar_documentos', compact('aprovacao','gestores','aprovacoes'));
    }

    public function validarDocumentos(Request $request)
    {
        $input = $request->all();
        $idG = Auth::user()->id;
        $aprovacao = DB::table('aprovacao')
        ->join('documentos','documentos.id','=','aprovacao.documento_id')
        ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
        'documentos.caminho as caminho')
        ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)->get(); 
        $qtd = sizeof($aprovacao);
        
        for($a = 1; $a <= $qtd; $a++){
			if(!empty($input['check_'.$a])){
				if($input['check_'.$a] == "on"){
					$idG = $input['gestor_id_'.$a]; 
					HomeController::aprovar($id_mp,$idG);
					$ap += 1;
				}
			}
		}
    }

    function aprovar($id_mp, $idG)
    {

    }

    public function visualizarFluxos()
    {
        $idG = Auth::user()->id;
        $gestor = Gestor::where('id',$idG)->get();
        if($gestor[0]->funcao_id == "1") {
            $aprovacao = DB::table('aprovacao')
            ->join('documentos','documentos.id','=','aprovacao.documento_id')
            ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
            'documentos.caminho as caminho')
            ->where('fluxo',2)
            ->get();
        } else {
            $aprovacao = DB::table('aprovacao')
            ->join('documentos','documentos.id','=','aprovacao.documento_id')
            ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
            'documentos.caminho as caminho')
            ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)
            ->get();
        }
                
        $aprovacoes = Aprovacao::all();
        $gestores = Gestor::all(); 
        return view('validar_documentos_fluxos', compact('aprovacao','gestores','aprovacoes'));
    }
}