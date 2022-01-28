<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal de Assinaturas de NF - HCPGESTÃO</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-12xl mx-auto sm:px-8 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
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
			  </td>
              <td>Data Prevista: <input class="form-control" type="date" id="data_prevista" name="data_prevista" required value="{{ Request::old('data_prevista') }}" /></td>
            </tr>
		   </table>
		  </center>
		  
		  <br>
		  <center>		
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
			<td width="40"><strong><h5>Justificativa/Observações:</h5></strong></td>
			<td><textarea type="text" id="observacao" name="observacao" class="form-control" required="true" rows="8" cols="60">{{ Request::old('observacao') }}</textarea></td>
		   </tr>
		  </table>
		  </center>
		  
		  <center>
		  <table class="table table-bordered" style="width: 1000px;" cellspacing="0">
		   <tr>
		    <td align="right"> 
			 <a href="{{ route('escolher_unidade') }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			 <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Concluir" id="Salvar" name="Salvar" /> 
			</td>
		   </tr>
		  </table>
		  </center>
   </form>
</body>