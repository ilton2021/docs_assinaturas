<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Documentos - Assinaturas HCPGESTÃO - DOCUMENTO CADASTRO</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-12xl mx-auto sm:px-8 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img src="{{ asset('imagens/gestao.png') }}" width="100" height="50" style="margin-left: 1075px;" />
                </div>
                @if ($errors->any())
                  <div class="alert alert-success">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                  </div>
                @endif
                <div class="mt-8 bg-white dark:bg-gray-1200 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                 <center>
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <form method="POST" action="{{ \Request::route('storeDoc') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <thead>
                                      <tr>
                                        <td colspan="2" style="width:800px;"> 
                                          <center><b>NOVO DOCUMENTO:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tr> 
                                      <td> Código do Documento: </td>
                                      <td> <input type="number" id="nome" name="nome" class="form-control" required="true" value="{{ old('nome') }}">  </td>
                                    </tr>
                                    <tr>
                                      <td>Tipo de Documento:</td>
                                      <td>
                                        <select id="tipo" name="tipo" class="form-control">
                                          <option id="tipo" name="tipo" value="">Selecione..</option>
                                          <option id="tipo" name="tipo" value="1">NOTA FISCAL</option>
                                          <option id="tipo" name="tipo" value="2">SERVIÇO/PRODUTO</option>
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Documento: </td>
                                      <td> <b>Favor anexar um único pdf com uma ou mais folhas</b> <input type="file" id="imagem" name="imagem" class="form-control" required="true">  </td>
                                    </tr>
                                    <tr> 
                                      <td> Unidade do Documento: </td>
                                      <td> 
                                          <select id="unidade_id" name="unidade_id" class="form-control" required="true">  
                                            <option id="unidade_id" name="unidade_id" value="">Selecione..</option>
                                           @foreach($unidades as $unds)
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $unds->id; ?>">{{ $unds->nome }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fornecedor:</td>
                                        <td>
                                            <select id="fornecedor_id" name="fornecedor_id" class="form-control">
                                              <option id="fornecedor_id" name="fornecedor_id" value="">Selecione..</option>
                                              @foreach($fornecedores as $fornecedor)
                                                <option id="fornecedor_id" name="fornecedor_id" value="<?php echo $fornecedor->id; ?>">{{ $fornecedor->nome }}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </table>
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                      <tr>
                                        <td colspan="2"><center><b>DEFINIR FLUXO:</b></center></td>
                                      </tr>
                                      <tr>
                                        <td><center>Setor:</center></td>
                                        <td><center>Gestor / E-mail:</center></td>
                                      </tr>
                                      <tr>
                                        <td> <input type="text" class="form-control" id="funcao" name="funcao" value="GESTOR" readonly /> </td>
                                        <td>
                                          <select id="gestor" name="gestor" class="form-control">
                                           <option id="gestor" name="gestor" value="">Selecione..</option>
                                           @foreach($gestor as $gestor)
                                            <option id="gestor" name="gestor" value="">{{ $gestor->nome }} / {{ $gestor->email }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> <input type="text" class="form-control" id="funcao" name="funcao" value="GESTOR UNIDADE" readonly /> </td>
                                        <td>
                                          <select id="gestorUnd" name="gestorUnd" class="form-control">
                                           <option id="gestorUnd" name="gestorUnd" value="">Selecione..</option>
                                           @foreach($gestorUnd as $gestor)
                                            <option id="gestorUnd" name="gestorUnd" value="">{{ $gestor->nome }} / {{ $gestor->email }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> <input type="text" class="form-control" id="funcao" name="funcao" value="PRESTAÇÃO DE CONTAS" readonly /> </td>
                                        <td>
                                          <select id="gestorPrC" name="gestorPrC" class="form-control">
                                           <option id="gestorPrC" name="gestorPrC" value="">Selecione..</option>
                                           @foreach($gestorPrC as $gestor)
                                            <option id="gestorPrC" name="gestorPrC" value="">{{ $gestor->nome }} / {{ $gestor->email }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> <input type="text" class="form-control" id="funcao" name="funcao" value="CONTABILIDADE" readonly /> </td>
                                        <td>
                                          <select id="gestorCon" name="gestorCon" class="form-control">
                                           <option id="gestorCon" name="gestorCon" value="">Selecione..</option>
                                           @foreach($gestorCon as $gestor)
                                            <option id="gestorCon" name="gestorCon" value="">{{ $gestor->nome }} / {{ $gestor->email }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> <input type="text" class="form-control" id="funcao" name="funcao" value="FINANCEIRO" readonly /> </td>
                                        <td>
                                          <select id="gestorFin" name="gestorFin" class="form-control">
                                           <option id="gestorFin" name="gestorFin" value="">Selecione..</option>
                                           @foreach($gestorFin as $gestor)
                                            <option id="gestorFin" name="gestorFin" value="">{{ $gestor->nome }} / {{ $gestor->email }}</option>
                                           @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    <td> <br /> <a href="{{ route('cadastroDoc') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
                                    <td> <br /> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
                                    <td hidden><input hidden type="text" id="solicitante_id" name="solicitante_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                    <td hidden><input hidden type="text" id="tipo" name="tipo" value="" /> </td>
                                    <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                    <td hidden><input hidden type="text" id="acao" name="acao" value="cadastrar_novo_documento" /> </td>
                                    <td hidden><input hidden type="date" id="data_prevista" name="data_prevista" class="form-control" value="<?php echo date('Y-m-d', strtotime('now')); ?>" /></td>
                                    </tr>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>