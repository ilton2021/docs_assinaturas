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
	  @endif <?php $qtd = sizeof($documentos); if($qtd > 0){ $id = $documentos[0]->id; }else{ $id = 0; }  ?>
	  <form action="{{ route('storeFluxo', $id) }}" method="POST">             
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <center>
		   <table class="table table-bordered" style="width: 1000px;" cellspacing="0"> 
			<tr>
			  <td colspan="3"><center><strong><h3><br>Fluxo de Assinaturas de Documentos</h3></strong></center></td>
			  <td hidden><input hidden class="form-control" type="text" id="ativo" name="ativo" value="" readonly="true" /></td>
			  <td hidden><input hidden class="form-control" type="date" id="data_aprovacao" name="data_aprovacao" value="" readonly="true" /></td>
              <td hidden><input hidden class="form-control" type="text" id="gestor_id" name="gestor_id" value="<?php echo $gestor[0]->id; ?>" readonly="true" /></td>
			  <td hidden><input hidden class="form-control" type="text" id="gestor_anterior_id" name="gestor_anterior_id" value="<?php echo Auth::user()->id; ?>" readonly="true" /></td>
              <td hidden><input hidden class="form-control" type="text" id="unidade_id" name="unidade_id" value="" readonly="true" /></td>
			  @if($qtd > 0)   
			  <td hidden><input hidden class="form-control" type="text" id="documento_id" name="documento_id" value="<?php echo $documentos[0]->id; ?>" readonly="true" /></td>
			  @endif
			</tr>
            <tr>
			  <td>Solicitante: <input readonly="true" class="form-control" type="text" id="solicitante" name="solicitante" required value="<?php echo Auth::user()->name; ?>" /></td>
              <td>Gestor Imediato: <input readonly="true" class="form-control" type="text" id="gestor_imediato" name="gestor_imediato" required value="<?php echo $gestor[0]->nome; ?>" /></td>
        	</tr>
            <tr>
              <td>Documento:
				  <select id="documento_id" name="documento_id" class="form-control" required>
					<option id="documento_id" name="documento_id" value="">Selecione..</option>  
					@foreach($documentos as $doc)
					 <option id="documento_id" name="documento_id" required="true" value="<?php echo $doc->id; ?>">{{ $doc->nome }}</option>
					@endforeach
				  </select>
				 <!--input id="arquivo" name="arquivo" class="form-control" value="" required--> 
			  </td>
              <!--td>Pesquisa:<br>
                <a href="{{ route('pesquisarDocumento') }}" class="btn btn-sm btn-info">Pesquisar Documento</a>
              </td-->
              <td>Data Prevista: <input class="form-control" type="date" id="data_prevista" name="data_prevista" required value="{{ Request::old('data_prevista') }}" /></td>
            </tr>
		   </table>
		  </center>
		  
		  <br>
		  <center>		
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
			<td width="40"><strong><h5>Justificativa/Observações:</h5></strong></td>
			<td><textarea type="text" id="observacao" name="observacao" class="form-control" required="true" rows="10" cols="60">{{ Request::old('observacao') }}</textarea></td>
		   </tr>
		  </table>
		  </center>
		  
		  <center>
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
		    <td align="right"> 
			 <a href="{{ route('escolher_unidade') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			 <input type="submit" onclick="validar()" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Concluir" id="Salvar" name="Salvar" /> 
			</td>
		   </tr>
		  </table>
		  </center>
   </form>
</body>