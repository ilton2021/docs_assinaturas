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
                                <form action="{{ \Request::route('updateGest') }}" method="POST">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <thead>
                                      <tr>
                                        <td style="width:600px;" colspan="2"> 
                                          <center><b>ALTERAR GESTOR:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    @foreach($gestores as $gestor)
                                    <tr> 
                                      <td> Nome do Gestor: </td>
                                      <td> <input type="text" id="nome" name="nome" class="form-control" required="true" value="<?php echo $gestor->nome; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> Matrícula do Gestor: </td>
                                      <td> <input type="text" id="matricula" name="matricula" class="form-control" required="true" value="<?php echo $gestor->matricula; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> Email do Gestor: </td>
                                      <td> <input type="text" id="email" name="email" class="form-control" required="true" value="<?php echo $gestor->email; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> CPF do Gestor: </td>
                                      <td> <input type="text" id="cpf" name="cpf" class="form-control" required="true" value="<?php echo $gestor->cpf; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> Cargo do Gestor: </td>
                                      <td> 
                                        <select id="cargo_id" name="cargo_id" class="form-control">
                                          @foreach($cargos as $cargo)
                                           @if($cargo->id == $gestor->cargo_id)
                                            <option id="cargo_id" name="cargo_id" value="<?php echo $cargo->id; ?>" selected>{{ $cargo->nome }}</option>
                                           @else
                                            <option id="cargo_id" name="cargo_id" value="<?php echo $cargo->id; ?>">{{ $cargo->nome }}</option>    
                                           @endif
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Função do Gestor: </td>
                                      <td> 
                                        <select id="funcao_id" name="funcao_id" class="form-control">
                                          @foreach($funcoes as $funcao)
                                           @if($funcao->id == $gestor->funcao_id)
                                            <option id="funcao_id" name="funcao_id" selected value="<?php echo $funcao->id; ?>">{{ $funcao->descricao }}</option>
                                           @else
                                            <option id="funcao_id" name="funcao_id" value="<?php echo $funcao->id; ?>">{{ $funcao->descricao }}</option>
                                           @endif
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Carimbo do Gestor: </td>
                                      <td> 
                                      <input readonly="true" type="text" id="carimbo_" name="carimbo_" class="form-control" required="true" value="<?php echo $gestor->caminho; ?>">
                                      <input type="file" id="carimbo" name="carimbo" class="form-control">
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Usuário do Gestor: </td>
                                      <td> 
                                        <select id="user_id" name="user_id" class="form-control">
                                       @foreach($users as $user)
                                        @if($user->id == $gestor->user_id)
                                         <option id="user_id" name="user_id" value="<?php echo $gestor->user_id; ?>" selected>{{ $user->name }}</option> 
                                        @else
                                         <option id="user_id" name="user_id" value="<?php echo $gestor->user_id; ?>">{{ $user->name }}</option> 
                                        @endif
                                       @endforeach
                                       </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Gestor Imediato do Gestor: </td>
                                      <td> 
                                        <select id="gestor_imediato_id" name="gestor_imediato_id" class="form-control">
                                       @foreach($users as $user)
                                        @if($user->id == $gestor->gestor_imediato_id)
                                         <option id="gestor_imediato_id" name="gestor_imediato_id" value="<?php echo $gestor->user_id; ?>" selected>{{ $user->name }}</option> 
                                        @else
                                         <option id="gestor_imediato_id" name="gestor_imediato_id" value="<?php echo $gestor->user_id; ?>">{{ $user->name }}</option> 
                                        @endif
                                       @endforeach
                                       </select>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td> Unidade do Gestor: </td>
                                      <td> 
                                        <select id="unidade_id" name="unidade_id" class="form-control">
                                          @foreach($unidades as $unidade)
                                           @if($unidade->id == $gestor->unidade_id)
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" selected>{{ $unidade->nome }}</option>
                                           @else
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>">{{ $unidade->nome }}</option>
                                           @endif
                                          @endforeach
                                        </select>
                                      </td>
                                    </tr>
                                    @endforeach
                                    <table>
                                    <tr>
                                     <td> 
                                        <a href="{{ route('cadastroGest') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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