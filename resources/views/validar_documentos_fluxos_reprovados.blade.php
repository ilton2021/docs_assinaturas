<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Documentos - Assinaturas HCPGESTÃO</title>
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
       <style>
		.navbar .dropdown-menu .form-control {
			width: 300px;
		}
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('img/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Documentos - Assinaturas HCPGESTÃO</h4>
			</span>
    </nav>
        
    <section id="unidades">
    	<p align="right"><a href="{{ url('/home') }}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a></p>
        <div class="row">
        
        <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">Escolha uma opção:</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
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
		<div class="container d-flex justify-content-between" style="margin-left: 10px;">
         <div class="row"> 
          <table class="table table-sm table-bordered" style="font-size: 12px;">
            <?php $qtdApr = sizeof($aprovacao); ?>
              @if($qtdApr > 0) 
              <tr><td colspan="10"><br><b><font size="04px">Documentos Validação:</font></b></td></tr>
              <tr>
                <td><center>UNIDADE</center></td>  
                <td><center>NOME DOCUMENTO</center></td>
                <td><center>NÚMERO DOCUMENTO</center></td>
                <td><center>FLUXO</center></td>
                <td><center>ARQUIVO</center></td>
                <td><center>STATUS</center></td>
              </tr> <?php $a = 1; ?>
             	@foreach($aprovacao as $docs)
              	<tr> 
              	 <td> <br><center> <b> @if($docs->unidade_id == 1) <?php echo "HCP GESTÃO"; ?>  
                      @elseif($docs->undDoc == 2) <?php echo "HMR"; ?>  
                      @elseif($docs->undDoc == 3) <?php echo "BELO JARDIM"; ?>  
                      @elseif($docs->undDoc == 4) <?php echo "ARCOVERDE"; ?>  
                      @elseif($docs->undDoc == 5) <?php echo "ARRUDA"; ?>  
                      @elseif($docs->undDoc == 6) <?php echo "CARUARU"; ?>  
                      @elseif($docs->undDoc == 7) <?php echo "HSS"; ?>  
                      @elseif($docs->undDoc == 8) <?php echo "HPR"; ?>  
                      @endif </b> </center> </td>
                 <td title="<?php echo $docs->nomeDoc; ?>"> <p><center>  {{ $docs->nomeDoc }} </center></p></td> 
                 <td title="<?php echo $docs->numeroDoc; ?>"> <p><center> {{ $docs->numeroDoc }} </center> </p>  </td>
                 <td> <?php $qtdA = sizeof($aprovacoes); ?>
                 <center>
                 <?php for($ap = 0; $ap < $qtdA; $ap++) { ?>
                 @if($aprovacoes[$ap]->documento_id == $docs->documento_id)
                  <?php $idG = $aprovacoes[$ap]->gestor_anterior_id; ?> 
                  @foreach($gestores as $g)
                      @if($g->id == $idG) 
                        <center><input readonly="true" type="text" id="gestor" name="gestor" value="<?php echo substr($g->nome, 0, 20); ?>" title="<?php echo $g->nome; ?>" style="width: 100px" /></center> 
                      @endif  
                  @endforeach
                 @endif 
                 <?php } ?>                
                 </td>
                 <td><p><center> <a href="{{asset('storage')}}/{{$docs->caminho}}" target="_blank" class="btn btn-sm btn-success" width="100px">Arquivo</a></center></p></td>
                 <td> <?php $qtdA = sizeof($aprovacoes); ?>
                 <center>
                 <?php for($ap = 0; $ap < $qtdA; $ap++) { ?>
                 @if($aprovacoes[$ap]->documento_id == $docs->documento_id)
                  <?php $idG = $aprovacoes[$ap]->gestor_anterior_id; ?> 
                      @if($aprovacoes[$ap]->fluxo == 2) 
                        <center><font color="green"><b>APROVAÇÃO FINAL</b></font></center> 
                      @else
                        @if($aprovacoes[$ap]->resposta == 1)
                        <center><font color="blue"><b>APROVADO</b></font></center> 
                        @else
                        <center><font color="red"><b>REPROVADO</b></font></center> 
                        @endif
                      @endif  
                 @endif 
                 <?php } ?>                
                 </td>
                 </td> 
                 <?php $a += 1; ?>
                @endforeach
               @endif
               </tr>
          </table>
          <table style="width: 1340px;">
            <tr>
                <td> <a href="{{ url('/home') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>  </td>
          </table>
          <input hidden type="text" id="resposta" name="resposta" value="" /> 
          <input hidden type="text" id="data_aprovacao" name="data_aprovacao" value="" /> 
          <input hidden type="text" id="gestor_anterior" name="gestor_anterior" value="" /> 
          <input hidden type="text" id="mp_id" name="mp_id" value="" /> 
          <input hidden type="text" id="unidade_id" name="unidade_id" value="" /> 
          <input hidden type="text" id="motivo" name="motivo" value="" /> 
          <input hidden type="text" id="ativo" name="ativo" value="" /> 
          </form>
		 </div>
		</div>
    </div>
    </div>
    </section >
    </footer>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    </body>
</html>