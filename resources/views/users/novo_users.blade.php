@extends('layouts.app2')
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-12xl mx-auto sm:px-8 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img src="{{ asset('imagens/gestao.png') }}" width="100" height="50" style="margin-left: 1080px;" />
                </div>
                <div class="mt-8 bg-white dark:bg-gray-1200 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                          @if ($errors->any())
                            <div class="alert alert-danger">
                              <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                              </ul>
                            </div>
                          @endif
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                 <center>
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <form method="POST" action="{{ \Request::route('store') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <thead>
                                      <tr>
                                        <td colspan="2" style="width:800px;"> 
                                          <center><b>NOVO USUÁRIO:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tr> 
                                      <td> Nome do Usuário: </td>
                                      <td> <input type="text" id="name" name="name" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> E-mail do Usuário: </td>
                                      <td> <input type="text" id="email" name="email" class="form-control" required="true" value=""> </td>
                                    </tr>
                                    <tr> 
                                      <td> Unidade do Usuário: </td>
                                      <td> 
                                        <select id="unidade_id" name="unidade_id" class="form-control">
                                          @foreach($unidades as $unidade)
                                            <option id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>">{{ $unidade->nome }}</option>
                                          @endforeach 
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Senha do Usuário:</td>
                                      <td> <input type="password" id="password" name="password" class="form-control" required /> </td>
                                    </tr>
                                    <tr>
                                      <td>Confirmar Senha do Usuário:</td>
                                      <td> <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required /> </td>
                                    </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    <td> <br /> <a href="{{ route('cadastroUsuario') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
                                    <td> <br /> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
                                    <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                    <td hidden><input hidden type="text" id="acao" name="acao" value="cadastrar_novo_fornecedor" /> </td>
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