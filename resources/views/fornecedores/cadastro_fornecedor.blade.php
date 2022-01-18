@extends('layouts.app2')
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('imagens/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Fornecedores - Assinaturas HCPGESTÃO</h4>
			</span>
</nav>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">CADASTRO FORNECEDORES:</h5>
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
			<a class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{ url('cadastrosBasicos') }}"> Voltar <i class="fas fa-undo-alt"></i> </a> &nbsp;
			<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoForn')}}"> Novo <i class="fas fa-check"></i> </a>
		</p>
			<table class="table table-sm " id="my_table">
			    <thead class="bg-success">
					<tr>
						<th scope="col" width="500px">Nome</th>
						<th scope="col">E-mail</th>
						<th scope="col">Tipo de Contrato</th>
						<th scope="col">Tipo de Pessoa</th>
						<th scope="col">CNPJ/CPF</th>
						<th scope="col"><center>Alterar</center></th>
						<th scope="col"><center>Excluir</center></th>
					</tr>
				</thead>
				<tbody>
					@foreach($fornecedores as $fornecedor)
					<tr>
						<td style="font-size: 15px;">{{$fornecedor->nome}}</td>
						<td>{{ $fornecedor->email }}</td>
						@if($fornecedor->tipo_contrato == "OBRAS")
						<td> {{ 'OBRAS' }} </td>
						@elseif($fornecedor->tipo_contrato == "SERVICOS")
						<td> {{ 'SERVIÇOS' }} </td>
						@else
						<td> {{ 'AQUISIÇÃO DE BENS' }} </td>
						@endif
						@if($fornecedor->tipo_pessoa == "F")
						<td>{{ 'PESSOA FÍSICA' }}</td>
						@else
						<td>{{ 'PESSOA JURÍDICA' }}</td>
						@endif
						<td>{{ $fornecedor->cnpj_cpf }}</td>
						<td><center><a class="btn btn-info btn-sm" href="{{route('alterarForn', $fornecedor->id)}}" ><i class="fas fa-edit"></i></center></td>
						<td><center><a class="btn btn-danger btn-sm" href="{{route('excluirForn', $fornecedor->id)}}" ><i class="fas fa-times-circle"></i></center></td>
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