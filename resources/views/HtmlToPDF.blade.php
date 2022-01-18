<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Documentos - Assinaturas HCPGESTÃO</title>
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
		.navbar .dropdown-menu .form-control {
			width: 300px;
		}
        </style>
    </head>
    <body>
<h1>Lista de Unidades:</h1>
 
<table border="1" width="100%" cellpadding="10" >
 <tr>
 <th width="10%">Id</th>
 <th width="40%">Name</th>
 <th width="50%">Imagem</th>
 </tr>
 @foreach($unidades as $unidade)
 
 <tr>
 <td align="center">{{$unidade->id}}</td>
 <td> {{$unidade->nome}}</td>
 <td> 
 <img id="img-unity" src="{{public_path($unidade->imagem)}}" class="rounded-sm" alt="..." style="width:150px; height: 80px">
 </td>
 </tr>
 
 @endforeach
 
</table>

</body>
</html>