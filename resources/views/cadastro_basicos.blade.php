@extends('layouts.app2')
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('imagens/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Cadastro Básicos - Assinaturas HCPGESTÃO</h4>
			</span>
</nav>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">CADASTRO BÁSICOS:</h5>
		</div>
	</div> <br>	
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
		</p>
			<table class="table table-sm " id="my_table">
			    <thead class="bg-success">
					<tr>
						<th scope="col" width="500px" colspan="2">Cadastros</th>
					</tr>
              	</thead>
				<tbody>
					<tr>
                        <td>Gestor: </td>
                        <td> <a href="{{ route('cadastroGest') }}" class="btn btn-sm btn-info">Cadastrar Gestor</a> </td>
                    </tr>
                    <tr>
                        <td>Usuário: </td>
                        <td> <a href="{{ route('cadastroUsuario') }}" class="btn btn-sm btn-info">Cadastrar Usuário</a> </td>
                    </tr>
                    <tr>  
                        <td>Fornecedores: </td>
                        <td> <a href="{{ route('cadastroForn') }}" class="btn btn-sm btn-info">Cadastrar Fornecedor</a> </td>
                    </tr>
                    <tr>
                        <td>Cargos: </td>
                        <td> <a href="{{ route('cadastroCarg') }}" class="btn btn-sm btn-info">Cadastrar Cargo</a> </td>
                    </tr>
                    <tr>
                        <td>Funções: </td>
                        <td> <a href="{{ route('cadastroFuncoes') }}" class="btn btn-sm btn-info">Cadastrar Função</a> </td>
					</tr>
					<tr>
						<td>Unidades: </td>
						<td> <a href="{{ route('cadastroUnd') }}" class="btn btn-sm btn-info">Cadastrar Unidade </a></td>
					</tr>
					<tr>
						<td>Respostas:</td>
						<td> <a href="{{ route('cadastroRespostas') }}" class="btn btn-sm btn-info">Cadastrar Respostas</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	  </div> 
   </div>
 </div>
</div>
</body>