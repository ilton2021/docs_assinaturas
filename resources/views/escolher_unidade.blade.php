@extends('layouts.app2')
<body> <br><br>
<section id="unidades">
    <div class="container" style="margin-top:40px; margin-bottom:20px;">
		<p align="right"><a href="{{ url('/home') }}" class="btn btn-warning btn-sm" style="margin-top: -50px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a></p>
        <div class="row" style="margin-top: -50px;">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">Escolha uma Unidade</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
		<div class="container d-flex justify-content-between">
        <div class="row">
            @foreach($unidades as $unidade)
            @if((!isset($unidade->cnes) || $unidade->cnes === null) && $unidade->id != 8)
            <div class="col-sm-4" style="width: 200px;">
                <div id="img-body" class="sborder-0 text-white text-center">
                    <img id="img-unity" src="{{asset('storage')}}/{{$unidade->caminho}}" class="rounded-sm" alt="..." style="width:180px; height: 80px">
                    <div class="card-body text-center">
                  	   <a href="{{ route('fluxo', $unidade->id) }}" class="btn btn-outline-success">Clique Aqui</a>
                       <span class="font-weight-bold" style="margin-left: 400px;">{{$unidade->nome}}</span>
                    </div>
                </div>
            </div>  
            @endif
            @endforeach
        </div>
    </div>
    </div>
    </section >
    </body>
</html>