<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Documentos - Assinaturas HCPGESTÃO - FORNECEDOR CADASTRO</title>
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
                                <form action="{{ \Request::route('updateForn') }}" method="POST">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <thead>
                                      <tr>
                                        <td style="width:600px;" colspan="2"> 
                                          <center><b>ALTERAR FORNECEDOR:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    @foreach($fornecedores as $fornecedor)
                                    <tr> 
                                      <td> Nome do Fornecedor: </td>
                                      <td> <input type="text" id="nome" name="nome" class="form-control" required="true" value="<?php echo $fornecedor->nome; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> Tipo do Contrato: </td>
                                      <td> 
                                        <select id="tipo_contrato" name="tipo_contrato" class="form-control">
                                          @if($fornecedor->tipo_contrato == "OBRAS")
                                           <option id="tipo_contrato" name="tipo_contrato" value="OBRAS" selected>Obras</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="SERVICOS">Serviços</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="AQUISICAO">Aquisição de Bens</option>
                                          @elseif($fornecedor->tipo_contrato == "SERVICOS")
                                           <option id="tipo_contrato" name="tipo_contrato" value="OBRAS">Obras</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="SERVICOS" selected>Serviços</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="AQUISICAO">Aquisição de Bens</option>
                                          @else
                                           <option id="tipo_contrato" name="tipo_contrato" value="OBRAS">Obras</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="SERVICOS">Serviços</option>
                                           <option id="tipo_contrato" name="tipo_contrato" value="AQUISICAO" selected>Aquisição de Bens</option>
                                          @endif
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Tipo da Pessoa: </td>
                                      <td> 
                                        <select id="tipo_pessoa" name="tipo_pessoa" class="form-control">
                                          @if($fornecedor->tipo_pessoa == "F")
                                           <option id="tipo_pessoa" name="tipo_pessoa" value="F" selected>PESSOA FÍSICA</option>
                                           <option id="tipo_pessoa" name="tipo_pessoa" value="J">PESSOA JURÍDICA</option>
                                          @else
                                           <option id="tipo_pessoa" name="tipo_pessoa" value="F">PESSOA FÍSICA</option>
                                           <option id="tipo_pessoa" name="tipo_pessoa" value="J" selected>PESSOA JURÍDICA</option>
                                          @endif
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> CNPJ/CPF: </td>
                                      <td> <input type="text" id="cnpj_cpf" name="cnpj_cpf" class="form-control" required="true" value="<?php echo $fornecedor->cnpj_cpf; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> Email do Fornecedor: </td>
                                      <td> <input type="text" id="email" name="email" class="form-control" required="true" value="<?php echo $fornecedor->email; ?>"> </td>
                                    </tr>
                                    @endforeach
                                    <table>
                                    <tr>
                                     <td> 
                                        <a href="{{ route('cadastroForn') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
                                        <input type="submit" class="btn btn-success btn-sm" value="Salvar" id="Salvar" name="Salvar" /> </p>
                                        <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                        <td hidden><input hidden type="text" id="acao" name="acao" value="alterar_fornecedor" /> </td>
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