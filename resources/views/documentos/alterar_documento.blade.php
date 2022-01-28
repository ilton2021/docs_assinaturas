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
                    <img src="{{ asset('imagens/gestao.png') }}" width="100" height="50" style="margin-left: 1080px;" />
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
                                <form action="{{ \Request::route('updateDoc') }}" method="POST" enctype="multipart/form-data">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <thead>
                                      <tr>
                                        <td style="width:600px;" colspan="2"> 
                                          <center><b>ALTERAR DOCUMENTO:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    @foreach($documentos as $docs)
                                    <tr> 
                                      <td> Número do Documento: </td>
                                      <td> <input type="text" id="nome" name="nome" class="form-control" required="true" value="<?php echo $docs->nome; ?>"> </td>
                                    </tr>
                                    <tr>
                                      <td>Tipo de Documento:</td>
                                      <td>
                                        <select id="tipo" name="tipo" class="form-control">
                                          @if($docs->tipo == 1)
                                          <option id="tipo" name="tipo" value="1" selected>Nota Fiscal</option>
                                          <option id="tipo" name="tipo" value="2">Serviço/Produto</option>
                                          @else
                                          <option id="tipo" name="tipo" value="1">Nota Fiscal</option>
                                          <option id="tipo" name="tipo" value="2" selected>Serviço/Produto</option>
                                          @endif
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Documento: </td>
                                      <td> <input readonly="true" type="text" id="imagem_" name="imagem_" class="form-control" required="true" value="<?php echo $docs->caminho; ?>">
                                      <input type="file" id="imagem" name="imagem" class="form-control"> </td> </td>
                                    </tr>
                                    <tr> 
                                      <td> Unidade do Documento: </td>
                                      <td> 
                                        <select id="unidade_id" name="unidade_id" class="form-control" width="200px">
                                         @foreach($unidades as $und)
                                          @if($und->id == $documentos[0]->unidade_id)
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $und->id; ?>" selected>{{ $und->nome }}</option>
                                          @else
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $und->id; ?>">{{ $und->nome }}</option>
                                          @endif
                                         @endforeach
                                        </select>    
                                      </td>
                                    </tr>
                                    <tr>
                                        <td>Fornecedor:</td>
                                        <td>
                                            <select id="fornecedor_id" name="fornecedor_id" class="form-control">
                                              @foreach($fornecedores as $fornecedor)
                                                @if($fornecedor->id == $documentos[0]->fornecedor_id)
                                                 <option id="fornecedor_id" name="fornecedor_id" value="<?php echo $fornecedor->id; ?>" selected>{{ $fornecedor->nome }}</option>
                                                @else
                                                 <option id="fornecedor_id" name="fornecedor_id" value="<?php echo $fornecedor->id; ?>">{{ $fornecedor->nome }}</option>
                                                @endif
                                              @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <table>
                                    <tr>
                                     <td> 
                                        <a href="{{ route('cadastroDoc') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
                                        <input type="submit" class="btn btn-success btn-sm" value="Salvar" id="Salvar" name="Salvar" /> </p>
                                        <td hidden><input hidden type="text" id="solicitante_id" name="solicitante_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                        <td hidden><input hidden type="text" id="tipo" name="tipo" value="" /> </td>
                                        <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                        <td hidden><input hidden type="text" id="acao" name="acao" value="alterar_documento" /> </td>
                                     </td>
                                    </tr>
                                    </table>
                                  </form>
                                </center> 
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