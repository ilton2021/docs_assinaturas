@extends('layouts.app2')
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('imagens/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Gestores - Assinaturas HCPGESTÃO</h4>
			</span>
</nav>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">CADASTRO GESTORES:</h5>
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
			<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoGest')}}"> Novo <i class="fas fa-check"></i> </a>
		</p>
		<form method="POST" action="{{ route('pesquisarGestor') }}">	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		  <table align="center">
		    <tr>
			 <td>
				<input type="text" style="width: 500px" id="pesq" name="pesq" class="form-control" value="" />
			 </td>
			 <td>&nbsp;&nbsp;&nbsp;</td>
			 <td>
			 <select id="pesq2" name="pesq2" class="form-control">
			   <option id="pesq2" name="pesq2" value="nome">Nome</option>
			   <option id="pesq2" name="pesq2" value="email">E-mail</option>
			   <option id="pesq2" name="pesq2" value="cpf">CPF</option>
			 </select>
			 </td>
			 <td>&nbsp;&nbsp;&nbsp;</td>
			 <td width="100px"> <input type="submit" class="btn btn-info btn-sm" value="Pesquisar" id="Pesquisar" name="Pesquisar" /> </td>
			</tr>
		  </table>
		</form>
		<table class="table table-sm " id="my_table">
		    <thead class="bg-success">
					<tr>
						<th scope="col">Nome</th>
						<th scope="col">E-mail</th>
						<th scope="col">Unidade</th>
						<th scope="col">Matrícula</th>
						<th scope="col">CPF</th>
						<th scope="col"><center>Alterar</center></th>
						<th scope="col"><center>Excluir</center></th>
					</tr>
			</thead>
			<tbody>
					@foreach($gestores as $gestor)
					<tr>
						<td style="font-size: 15px;">{{$gestor->nome}}</td>
						<td>{{ $gestor->email }}</td>
                        @foreach($unidades as $unidade)
                         @if($unidade->id == $gestor->unidade_id)
                          <td>{{ $unidade->nome }}</td>
                         @endif
                        @endforeach
                        <td>{{ $gestor->matricula }}</td>
						<td>{{ $gestor->cpf }}</td>
						<td><center><a class="btn btn-info btn-sm" href="{{route('alterarGest', $gestor->id)}}" ><i class="fas fa-edit"></i></center></td>
						<td><center><a class="btn btn-danger btn-sm" href="{{route('excluirGest', $gestor->id)}}" ><i class="fas fa-times-circle"></i></center></td>
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