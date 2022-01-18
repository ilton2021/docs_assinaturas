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
	  <form action="{{ route('storeValidar_fluxo', $documentos[0]->id) }}" method="POST">             
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
			<tr>
             <td>Documento: 
             <br><a href="{{asset('storage')}}/{{$documentos[0]->caminho}}" target="_blank" class="btn btn-sm btn-success" width="100px"><?php echo $documentos[0]->nome; ?></a> 
			 </td>
             <td>Data Prevista: <input class="form-control" readonly="true" type="text" id="data_prevista" name="data_prevista" required value="<?php echo date('d-m-Y',strtotime($aprovacao[0]->data_prevista)); ?>" /></td>
            </tr>
            <tr>
              <td>Solicitante: <input readonly="true" class="form-control" type="text" id="solicitante" name="solicitante" required value="<?php echo Auth::user()->name; ?>" /></td>
              <td>Gestor Imediato: <input readonly="true" class="form-control" type="text" id="gestor_imediato" name="gestor_imediato" required value="<?php echo $gestor[0]->nome; ?>" /></td>
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
			<td width="40"><strong><h5>Justificativa/Observações:</h5></strong></td>
			<td><textarea type="text" id="observacao" name="observacao" class="form-control" required="true" rows="6" cols="60">{{ Request::old('observacao') }}</textarea></td>
		   </tr>
		  </table>
		  </center>
		  
		  <center>
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
            <td align="left"><a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a></td>
		    <td align="right"> 
			 <a href="{{ route('validar_nfluxo', $documentos[0]->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-danger btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Reprovar <i class="fas fa-undo-alt"></i> </a>
             <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Aprovar" id="Salvar" name="Salvar" /> 
			</td>
		   </tr>
		  </table>
		  </center>
   </form>
</body>