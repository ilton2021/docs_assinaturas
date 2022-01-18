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
                            <div class="flex items-center"></div>
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <center>
                                 <form action="{{ \Request::route('destroyGest') }}" method="POST">
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-sm table-bordered" style="width:1000px; align: center;">
                                    <thead>
                                      <tr>
                                        <td style="width:600px;" colspan="2"> 
                                         <center><b>EXCLUIR GESTOR:</b></center>
                                        </td>
                                    </tr>
                                    </thead>
                                    @foreach($gestores as $gestor)
                                    <tr> 
                                      <td> Nome do Gestor: </td>
                                      <td> <input type="text" disabled id="nome" name="nome" class="form-control" required="true" value="<?php echo $gestor->nome; ?>"> </td>
                                    </tr>
                                    <tr> 
                                      <td> CPF do Gestor: </td>
                                      <td> <input readonly="true" type="text" id="cpf" name="cpf" class="form-control" required="true" value="<?php echo $gestor->cpf; ?>"></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                        <center><b>Deseja Realmente Excluir este Gestor?</b></center>
                                      </td>
                                    </tr>
                                    @endforeach
                                    <table>
                                    <tr>
                                     <td> 
                                      <a href="{{ route('cadastroGest') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style=" color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
                                      <input type="submit" class="btn btn-danger btn-sm" value="Excluir" id="Excluir" name="Excluir" /> </p>
                                      <td hidden><input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" /> </td>
                                      <td hidden><input hidden type="text" id="acao" name="acao" value="excluir_gestor" /> </td>
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
    </body>
</html>