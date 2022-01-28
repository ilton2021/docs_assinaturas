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
        if(Auth::user()->funcao_id == "1"){
            return view('cadastro_basicos');
        } else {
            $unidades = Unidades::all();
            return view('home', compact('unidades'));
        }
    }

    public function escolher_unidade()
    {
        $unidades = Unidades::all();
        if(Auth::user()->funcao_id == "1"){
            return view('escolher_unidade', compact('unidades'));
        } else {
            return view('home', compact('unidades'));
        }
    }

    public function fluxo($id)
    {
        if(Auth::user()->funcao_id == "1"){
            $documentos = Documentos::where('unidade_id',$id)->get();
            $id_Gestor  = Auth::user()->id;
            $gestor     = Gestor::where('id',$id_Gestor)->get();
            $id_GestorImediato = $gestor[0]->gestor_imediato_id;
            $gestor     = Gestor::where('id',$id_GestorImediato)->get();
            $id = $id;
            return view('comecar_fluxo_doc', compact('gestor','documentos','id'));
        } else {
            $unidades = Unidades::all();
            return view('home', compact('unidades'));
        }
    }

    public function storeFluxo($id, Request $request)
    {
        $input               = $request->all();
        $id_doc              = $input['documento_id'];
        $documentos          = Documentos::where('id',$id_doc)->get();
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $id_Gestor           = Auth::user()->id;
        $gestor              = Gestor::where('id',$id_Gestor)->get();
        $id_GestorImediato   = $gestor[0]->gestor_imediato_id;
        $gestor              = Gestor::where('id',$id_GestorImediato)->get();
        $aprovacao           = Aprovacao::where('documento_id',$id_doc)->get();
        $qtd                 = sizeof($aprovacao);
        if($qtd > 0) {
            $documentos = Documentos::where('unidade_id',$id)->get();
            $validator  = "Este Documento já está em Validação!";
            return view('comecar_fluxo_doc', compact('gestor','documentos','id'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
        } else {
            $validator = Validator::make($request->all(), [
                'documento_id'  => 'required',
                'data_prevista' => 'required',
                'observacao'    => 'required'
            ]);
            if ($validator->fails()) {
                return view('comecar_fluxo_doc', compact('gestor','documentos','id'))
                            ->withErrors($validator)
                            ->withInput(session()->flashInput($request->input()));
            } else {
                $input['ativo']      = 1;
                $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
                DB::statement('UPDATE documentos SET gestor_id = '.$id_GestorImediato.' WHERE id = '.$id.';');
                $nomeDoc = $documentos[0]->nome;
                $nome    = $input['solicitante'];
                $motivo  = $input['observacao'];
                $input['resposta'] = 1;
                $input['fluxo']    = 1;
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
        $id_Gestor  = Auth::user()->id;
        $input      = $request->all();
        $funcao     = Gestor::where('id',$id_Gestor)->get('funcao_id');
        if($funcao[0]->funcao_id == '5') {
            $input['fluxo'] = 2; 
            $aprovacao = Aprovacao::where('documento_id',$id)->get();
            $idGestor  = $aprovacao[0]->gestor_anterior_id;
            DB::statement('UPDATE documentos SET gestor_id = '.$id_Gestor.' WHERE id = '.$id.';');
            DB::statement('UPDATE aprovacao SET ativo = 0 WHERE documento_id = '.$id.';');
            DB::statement('UPDATE documentos SET concluida = 1 WHERE documento_id = '.$id.';');
        } else {
            $input['fluxo'] = 1;
            DB::statement('UPDATE documentos SET gestor_id = '.$id_Gestor.' WHERE id = '.$id.';');
            DB::statement('UPDATE aprovacao SET ativo = 0 WHERE documento_id = '.$id.';');
        }
        $input['ativo']          = 1;
        $input['resposta']       = 1;
        $input['unidade_id']     = $documentos[0]->unidade_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $input['data_prevista']  = date('Y-m-d', strtotime($input['data_prevista']));
        $aprovacao = Aprovacao::create($input);
        $nomeDoc   = $documentos[0]->nome;
        $nome      = $input['solicitante'];
        $motivo    = $input['observacao'];
        $email     = 'ilton.albuquerque@hcpgestao.org.br';
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
        $aprovacao = Aprovacao::where('documento_id',$documentos[0]->id)->get();
        $gestor_im = $aprovacao[0]->gestor_anterior_id;
        DB::statement('UPDATE documentos SET gestor_id = '.$gestor_im.' WHERE id = '.$id.';');
        $input['ativo'] = 1;
        $input['unidade_id'] = $documentos[0]->unidade_id;
        $input['gestor_id'] = $documentos[0]->solicitante_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $input['data_prevista']  = date('Y-m-d', strtotime($input['data_prevista']));
        $input['fluxo']    = 1;
        $input['resposta'] = 2;
        $aprovacao = Aprovacao::create($input);
        $nomeDoc   = $documentos[0]->nome;
        $nome      = $input['solicitante'];
        $motivo    = $input['observacao'];
        $email     = 'ilton.albuquerque@hcpgestao.org.br';
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
        ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)->where('ativo',1)->get();        
        $aprovacoes = Aprovacao::all();
        $gestores   = Gestor::all(); 
        return view('validar_documentos', compact('aprovacao','gestores','aprovacoes'));
    }

    public function validarDocumentos(Request $request)
    {
        $input = $request->all();
        $idG = Auth::user()->id;
        $gestores   = Gestor::all();
        $aprovacoes = Aprovacao::all();
        $aprovacao  = DB::table('aprovacao')
        ->join('documentos','documentos.id','=','aprovacao.documento_id')
        ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
        'documentos.caminho as caminho')
        ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)->where('ativo',1)->get(); 
        $qtd = sizeof($aprovacao);   
        $ap = 0;     
        for($a = 1; $a <= $qtd; $a++){
			if(!empty($input['check_'.$a])){
				if($input['check_'.$a] == "on"){
                    $id_documento = $input['id_documento_'.$a];
					$idG          = Auth::user()->id; 
					HomeController::aprovar($id_documento,$idG);
					$ap += 1;
				}
			}
		}
        $aprovacao  = DB::table('aprovacao')
        ->join('documentos','documentos.id','=','aprovacao.documento_id')
        ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
        'documentos.caminho as caminho')
        ->where('fluxo',1)->where('aprovacao.gestor_id',$idG)->where('ativo',1)->get();
        if($ap == 0) {
            $validator = 'Aprovação Realizada com Sucesso!';
            return view('validar_documentos', compact('aprovacao','gestores','aprovacoes'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
        } else {
            return view('validar_documentos', compact('aprovacao','gestores','aprovacoes'));
        }
    }

    function aprovar($id_documento, $idG)
    {
        $documentos = Documentos::where('id',$id_documento)->get(); 
        $id         = $documentos[0]->id;
        $gestor     = Gestor::where('id',$idG)->get();
        $gestor_id  = $gestor[0]->gestor_imediato_id; 
        if(Auth::user()->funcao_id == "5") {  
            $input['fluxo'] = 2;
            DB::statement('UPDATE documentos SET gestor_id = '.$gestor_id.' WHERE id = '.$id.';');
            DB::statement('UPDATE aprovacao SET ativo = 0 WHERE documento_id = '.$id.';');
        } else {
            $input['fluxo'] = 1;
            DB::statement('UPDATE documentos SET gestor_id = '.$gestor_id.' WHERE id = '.$id.';');
            DB::statement('UPDATE aprovacao SET ativo = 0 WHERE documento_id = '.$id.';');
        }
        $input['ativo']          = 1;
        $input['unidade_id']     = $documentos[0]->unidade_id;
        $input['data_aprovacao'] = date('Y-m-d', strtotime('now'));
        $aprovacao     = Aprovacao::where('documento_id',$id)->get();
        $data_prevista = $aprovacao[0]->data_prevista;
        $input['data_prevista']      = date('Y-m-d', strtotime($data_prevista));
        $input['observacao']         = 'Autorizada'; 
        $input['documento_id']       = $id;
        $input['gestor_id']          = $gestor_id;
        $input['gestor_anterior_id'] = $idG;
        $input['resposta']           = 1;
        $aprovacao = Aprovacao::create($input);
        $nomeDoc   = $documentos[0]->nome;
        $nome      = $gestor[0]->nome;
        $motivo    = $input['observacao'];
        $email     = 'ilton.albuquerque@hcpgestao.org.br';
        //Assinar Documento
        if(Auth::user()->funcao_id == '5') {
            Mail::send([], [], function($m) use ($email,$motivo,$nomeDoc) { 
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
    }

    public function visualizarFluxos()
    {
        $unidades   = Unidades::all();
        $documentos = Documentos::all();
        return view('validar_documentos_fluxos', compact('unidades','documentos'));
    }

    public function documentosNoFluxo()
    {
        $idG = Auth::user()->id;
        $gestor = Gestor::where('id',$idG)->get();
        $aprovacao = DB::table('aprovacao')
            ->join('documentos','documentos.id','=','aprovacao.documento_id')
            ->select('aprovacao.*','documentos.nome as nomeDoc','documentos.unidade_id as undDoc','documentos.numeroDoc',
            'documentos.caminho as caminho')
            ->where('aprovacao.gestor_anterior_id',$idG)->where('aprovacao.fluxo',1) 
            ->get();
        $aprovacoes = Aprovacao::all();
        $gestores = Gestor::all(); 
        $unidades   = Unidades::all();
        $documentos = Documentos::all();
        return view('validar_documentos_fluxos', compact('aprovacao','gestores','aprovacoes'));
    }

    public function documentosCriados()
    {
        $unidades = Unidades::all();
        $aprovacao = Aprovacao::where('documento_id',0)->get();
        return view('documentos/documentos_criados', compact('unidades','aprovacao'));
    }

    public function documentosAprovados()
    {
        $unidades = Unidades::all();
        $aprovacao = Aprovacao::where('documento_id',0)->get();
        return view('documentos/documentos_aprovados', compact('unidades','aprovacao'));
    }

    public function pesquisaDocAprovados(Request $request)
    {
        $input = $request->all(); 
        if(empty($input['pesq'])) { $input['pesq'] = ""; }
        if(empty($input['pesq2'])) { $input['pesq2'] = ""; }
        if(empty($input['unidade_id'])) { $input['unidade_id'] == ""; }
		$pesq  = $input['pesq'];
        $pesq2 = $input['pesq2'];
        $unidade_id = $input['unidade_id'];
        if($unidade_id != ""){
            if($pesq == "Nome" ) {
                $aprovacao = DB::table('documentos')
                ->join('aprovacao','aprovacao.documento_id','=','documentos.id')
                ->select('aprovacao.fluxo','nome','numeroDoc','documentos.unidade_id','caminho','documentos.id','concluida')
                ->where('documentos.unidade_id',$unidade_id)
                ->where('documentos.concluida',1)->where('documentos.nome','like','%'.$pesq2.'%')
                ->orderby('nome')->groupby('nome','fluxo','numeroDoc','unidade_id','caminho','id','concluida')->get();
            } elseif($pesq == "Numero" ) {
                $aprovacao = DB::table('documentos')
                ->join('aprovacao','aprovacao.documento_id','=','documentos.id')
                ->select('aprovacao.fluxo','nome','numeroDoc','documentos.unidade_id','caminho','documentos.id','concluida')
                ->where('documentos.unidade_id',$unidade_id)
                ->where('documentos.concluida',1)->where('documentos.numeroDoc','like','%'.$pesq2.'%')
                ->orderby('nome')->groupby('nome','fluxo','numeroDoc','unidade_id','caminho','id','concluida')->get();
            } else {
                $aprovacao = DB::table('documentos')
                ->join('aprovacao','aprovacao.documento_id','=','documentos.id')
                ->select('aprovacao.fluxo','nome','numeroDoc','documentos.unidade_id','caminho','documentos.id','concluida')
                ->where('documentos.unidade_id',$unidade_id)->where('documentos.concluida',1)
                ->orderby('nome')->groupby('nome','fluxo','numeroDoc','unidade_id','caminho','id','concluida')->get();
            }
        } else {
            if($pesq == "Nome" ) {
                $aprovacao = DB::table('documentos')
                ->join('aprovacao','aprovacao.documento_id','=','documentos.id')
                ->select('aprovacao.fluxo','nome','numeroDoc','documentos.unidade_id','caminho','documentos.id','concluida')
                ->where('documentos.concluida',1)->where('documentos.nome','like','%'.$pesq2.'%')
                ->groupby('nome','fluxo','numeroDoc','unidade_id','caminho','id','concluida')->get();
            } elseif($pesq == "Numero" ) {
                $aprovacao = DB::table('documentos')
                ->join('aprovacao','aprovacao.documento_id','=','documentos.id')
                ->select('aprovacao.fluxo','nome','numeroDoc','documentos.unidade_id','caminho','documentos.id','concluida')
                ->where('documentos.concluida',1)->where('documentos.numeroDoc','like','%'.$pesq2.'%')
                ->orderby('nome')->groupby('nome','fluxo','numeroDoc','unidade_id','caminho','id','concluida')->get();
            } else {
                $aprovacao = Aprovacao::where('documento_id',0)->get();
            } 
        }
        $gestores   = Gestor::all();
        $aprovacoes = Aprovacao::all();
        $unidades   = Unidades::all();
        return view('documentos/documentos_aprovados', compact('aprovacao','gestores','aprovacoes','unidades'));
    }
}