<!DOCTYPE html>
@section('content')
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Documentos - Assinaturas HCPGESTÃO</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<body> 
	  @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	  @endif

	  <center>
	   <table class="table table-bordered" style="width: 1000px;" cellspacing="0"> 
		<tr>
  	     <td colspan="2"><center><strong><h3><br>Validar - Fluxo de Assinaturas de NF</h3></strong></center></td>
	     <td hidden><input hidden class="form-control" type="text" id="ativo" name="ativo" value="" readonly="true" /></td>
		 <td hidden><input hidden class="form-control" type="date" id="data_aprovacao" name="data_aprovacao" value="" readonly="true" /></td>
         <td hidden><input hidden class="form-control" type="text" id="gestor_id" name="gestor_id" value="<?php echo $gestor[0]->id; ?>" readonly="true" /></td>
		 <td hidden><input hidden class="form-control" type="text" id="gestor_anterior_id" name="gestor_anterior_id" value="<?php echo Auth::user()->id; ?>" readonly="true" /></td>
         <td hidden><input hidden class="form-control" type="text" id="unidade_id" name="unidade_id" value="" readonly="true" /></td>
         <td hidden><input hidden class="form-control" type="text" id="documento_id" name="documento_id" value="<?php echo $documentos[0]->id; ?>" readonly="true" /></td>
		</tr>
	   </table>
	   
	  <table class="table" style="width: 500px;" cellspacing="0">
	   <tr>
		 <td>
	   		<iframe src="{{asset('storage')}}/{{$documentos[0]->caminho}}" width="1000px" height="600px"></iframe>
		 </td>
	   </tr>
	   <tr>
	   <td>
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><b>APROVAR DOCUMENTO:</b></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						@foreach($respostas as $resposta)
						  <input type="checkbox" id="resposta_id" name="resposta_id" /> {{ $resposta->descricao }} <br>
						@endforeach
						<br>
						Justificativa/Observações: <textarea id="justificativa" name="justificativa" rows="10" class="form-control"></textarea>
						<center><b>Deseja Aprovar este Documento!?</b></center>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">FECHAR</button>
						<input type="submit" class="btn btn-success btn-sm" value="APROVAR" id="Salvar" name="Salvar" /> 
					</div>
				  </div>
				</div>
			</div>
			<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><b>REPROVAR DOCUMENTO:</b></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						@foreach($respostas as $resposta)
						  <input type="checkbox" id="resposta_id" name="resposta_id" /> {{ $resposta->descricao }} <br>
						@endforeach
						<br>
						Justificativa/Observações: <textarea id="justificativa" name="justificativa" rows="10" class="form-control"></textarea>
						<center><b>Deseja Reprovar este Documento? E voltar para correção do Solicitante!?</b></center>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">FECHAR</button>
						<a href="{{ route('validar_nfluxo', $documentos[0]->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> REPROVAR <i class="fas fa-undo-alt"></i> </a>
					</div>
				  </div>
				</div>
			</div>
			<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><b>CANCELAR DOCUMENTO:</b></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						@foreach($respostas as $resposta)
						  <input type="checkbox" id="resposta_id" name="resposta_id" /> {{ $resposta->descricao }} <br>
						@endforeach
						<br>
						Justificativa/Observações: <textarea id="justificativa" name="justificativa" rows="10" class="form-control"></textarea>
						<center><b>Deseja Cancelar este Documento!?</b></center>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">FECHAR</button>
						<a href="{{ route('validar_nfluxo', $documentos[0]->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-danger btn-sm" style="color: #FFFFFF;"> CANCELAR <i class="fas fa-undo-alt"></i> </a>
					</div>
				  </div>
				</div>
			</div>
		 </td>
	   </tr>
	  </table>		 
	  </center>
	 
	  <form action="{{ route('storeValidar_fluxo', $documentos[0]->id) }}" method="POST">             
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
	  	  <center>		
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		       <tr>
              <td>Aprovador: <input readonly="true" class="form-control" type="text" id="solicitante" name="solicitante" required value="<?php echo Auth::user()->name; ?>" /></td>
              <td>Próximo Aprovador: <input readonly="true" class="form-control" type="text" id="gestor_imediato" name="gestor_imediato" required value="<?php echo $gestor[0]->nome; ?>" /></td>
            </tr>
		   </table>
		  </center>
		
		  <center>		
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
			<td width="40"><strong><h5>Justificativa/Observações:</h5></strong></td>
			<td><textarea type="text" id="observacao_gestor_ant" name="observacao_gestor_ant" class="form-control" required="true" rows="6" cols="60" readonly="true">{{ $aprovacao[0]->observacao }}</textarea></td>
		   </tr>
		  </table>
		  </center>

		  <center>
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
            <td align="left"><a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-primary" style="color: #FFFFFF;"> VOLTAR <i class="fas fa-undo-alt"></i> </a></td>
		    <td align="right"> 
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal3">
			 CANCELAR
			</button> &nbsp;&nbsp;
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal2">
			 REPROVAR
			</button> &nbsp;&nbsp;
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
			 APROVAR
			</button>
			</td>
		   </tr>
		  </table>
		  </center>
   </form>
</body>