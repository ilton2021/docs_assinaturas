<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Documentos - Assinaturas HCPGESTÃO - GESTOR CADASTRO</title>
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
                  <div class="alert alert-danger">
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
                                    <form method="POST" action="{{ \Request::route('storeGest') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <thead>
                                      <tr>
                                        <td colspan="2" style="width:800px;"> 
                                          <center><b>NOVO GESTOR:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tr> 
                                      <td> Nome do Gestor: </td>
                                      <td> <input type="text" id="nome" name="nome" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> Matrícula do Gestor: </td>
                                      <td> <input type="text" id="matricula" name="matricula" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> Email do Gestor: </td>
                                      <td> <input type="text" id="email" name="email" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> CPF do Gestor: </td>
                                      <td> <input type="text" id="cpf" name="cpf" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> Cargo do Gestor: </td>
                                      <td> 
                                        <select id="cargo_id" name="cargo_id" class="form-control">
                                          @foreach($cargos as $cargo)
                                           <option id="cargo_id" name="cargo_id" value="<?php echo $cargo->id; ?>">{{ $cargo->nome }}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Função do Gestor: </td>
                                      <td> 
                                        <select id="funcao_id" name="funcao_id" class="form-control">
                                          @foreach($funcoes as $funcao)
                                           <option id="funcao_id" name="funcao_id" value="<?php echo $funcao->id; ?>">{{ $funcao->descricao }}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Carimbo do Gestor: </td>
                                      <td> <input type="file" id="carimbo" name="carimbo" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> Vínculo Gestor/Usuário: </td>
                                      <td> 
                                        <select id="user_id" name="user_id" class="form-control">
                                          @foreach($users as $user)
                                           <option id="user_id" name="user_id" value="<?php echo $user->id; ?>">{{ $user->name }}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td> Gestor Imediato do Gestor: </td>
                                      <td>
                                        <select id="gestor_imediato_id" name="gestor_imediato_id" class="form-control">
                                          @foreach($users as $user)
                                           <option id="gestor_imediato_id" name="gestor_imediato_id" value="<?php echo $user->id; ?>">{{ $user->name }}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Unidade do Gestor: </td>
                                      <td> 
                                        <select id="unidade_id" name="unidade_id" class="form-control">
                                          @foreach($unidades as $unidade)
                                           <option id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>">{{ $unidade->nome }}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    <td> <br /> <a href="{{ route('cadastroGest') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
                                    <td> <br /> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
                                    <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                    <td hidden><input hidden type="text" id="acao" name="acao" value="cadastrar_novo_gestor" /> </td>
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