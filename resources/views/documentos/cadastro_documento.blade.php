@extends('layouts.app2')
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('imagens/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Documentos - Assinaturas HCPGESTÃO</h4>
			</span>
</nav>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">CADASTRO DOCUMENTOS:</h5>
		</div>
	</div>	<br>
	@if ($errors->any())
		<div class="alert alert-success">
		  <ul>
		    @foreach ($errors->all() as $error)
		      <li>{{ $error }}</li>
			@endforeach
		  </ul>
		</div>
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12">
		<p align="right">
			<a class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{ url('home') }}"> Voltar <i class="fas fa-undo-alt"></i> </a> &nbsp;
			<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoDoc')}}"> Novo <i class="fas fa-check"></i> </a>
		</p>
			<table class="table table-sm " id="my_table">
			    <thead class="bg-success">
					<tr>
						<th scope="col" width="500px">Número</th>
						<th scope="col">Fornecedor</th>
						<th scope="col">Tipo</th>
						<th scope="col">Unidade</th>
						<th scope="col"><center>Alterar</center></th>
						<th scope="col"><center>Excluir</center></th>
					</tr>
				</thead>
				<tbody>
					@foreach($documentos as $documento)
					<tr>
						<td style="font-size: 15px;">{{$documento->nome}}</td>
						@foreach($fornecedores as $fornecedor)
						@if($fornecedor->id == $documento->fornecedor_id)
						<td>{{ $fornecedor->nome }}</td>
						@endif
						@endforeach
						@if($documento->tipo == 1)
						<td>{{ 'NOTA FISCAL' }}</td>
						@else
						<td>{{ 'SERVIÇO/PRODUTO' }}</td>
						@endif
						@if($documento->unidade_id == 1)
						<td>{{ 'HCPGESTÃO' }}</td>
						@elseif($documento->unidade_id == 2)
						<td>{{ 'HMR' }}</td>
						@elseif($documento->unidade_id == 3)
						<td>{{ 'UPAE BELO JARDIM' }}</td>
						@elseif($documento->unidade_id == 4)
						<td>{{ 'UPAE ARCOVERDE' }}</td>
						@elseif($documento->unidade_id == 5)
						<td>{{ 'UPAE ARRUDA' }}</td>
						@elseif($documento->unidade_id == 6)
						<td>{{ 'UPAE CARUARU' }}</td>
						@elseif($documento->unidade_id == 7)
						<td>{{ 'HSS' }}</td>
						@elseif($documento->unidade_id == 8)
						<td>{{ 'HCA' }}</td>
						@elseif($documento->unidade_id == 9)
						<td>{{ 'UPA IGARASSU' }}</td>
						@endif
						<td><center><a class="btn btn-info btn-sm" href="{{route('alterarDoc', $documento->id)}}" ><i class="fas fa-edit"></i></center></td>
						<td><center><a class="btn btn-danger btn-sm" href="{{route('excluirDoc', $documento->id)}}" ><i class="fas fa-times-circle"></i></center></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	  </div> 
   </div>
 </div>
</div>
</body>