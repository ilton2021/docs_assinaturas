@extends('layouts.app2')
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
  	    <img src="{{asset('imagens/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
			<span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
				<h4 class="d-none d-sm-block">Cadastro Usuários - Assinaturas HCPGESTÃO</h4>
			</span>		
</nav>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">EXCLUIR USUÁRIO:</h5>
		</div>
	</div>	<br>
	@if ($errors->any())
		<div class="alert alert-danger">
		  <ul>
		    @foreach ($errors->all() as $error)
		      <li>{{ $error }}</li>
			@endforeach
		  </ul>
		</div>
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-8">
		  <form action="{{\Request::route('deleteUsuario', $users[0]->id) }}" method="post" >
		  <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table class="table table-sm" style="margin-left: 200px;"> 
					<tr>
						<td>Nome:</td>
						<td> <input readonly="true" type="text" id="name" name="name" class="form-control" value="<?php echo $users[0]->name; ?> " /> </td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td> <input readonly="true" type="text" id="email" name="email" class="form-control" value="<?php echo $users[0]->email; ?>" /> </td>
					</tr>
					<tr>
						<td><b><br>Deseja Realmente Excluir este Usuário??</b></td>
					</tr>
					<tr>
						<td> <input hidden type="text" id="acao" name="acao" value="excluir_usuario" class="form-control" /> </td>
						<td> <input hidden type="text" id="user_id" name="user_id" value="<?php echo Auth::user()->id; ?>" class="form-control" /> </td>
					</tr>
					<tr>
                      <td colspan="2"> <br> 
					    <p align="right"><a class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{ route('cadastroUsuario') }}"> Voltar <i class="fas fa-undo-alt"></i> </a>
						<input type="submit" class="btn btn-danger btn-sm" value="Excluir" id="Salvar" name="Salvar" /></p>
					  </td>
					</tr> 
			</table> </center>
		  </form>	
		</div>
	</div> 
</div>
</div>
</div>
</body>