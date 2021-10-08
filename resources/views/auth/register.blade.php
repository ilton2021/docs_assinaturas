@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			@if(Session::has('mensagem'))
				 @if($text == true)
				   <div class="container">
					 <div class="alert alert-danger {{ Session::get ('mensagem')['class'] }} ">
						  {{ Session::get ('mensagem')['msg'] }}
					 </div>
				   </div>
				  @endif
			@endif
            <div class="card">
                <div class="card-header">{{ __('Cadastrar Usuário') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="funcao" class="col-md-4 col-form-label text-md-right">{{ __('Função') }}</label>
                            <div class="col-md-6">
                                <select id="funcao" class="form-control @error('funcao') is-invalid @enderror" name="funcao">
								  <option id="funcao" name="funcao" value="Gestor">Gestor</option>
								  <option id="funcao" name="funcao" value="RH">RH</option>
								  <option id="funcao" name="funcao" value="Diretoria Técnica">Diretoria Técnica</option>
								  <option id="funcao" name="funcao" value="Diretoria">Diretoria</option>
								  <option id="funcao" name="funcao" value="Superintendencia">Superintendência</option>
								</select>
                                @error('funcao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
							<div style="margin-left: 375px" class="col-md-6 offset-md-4">
							    <a href="{{ url ('/') }}" class="btn btn-warning" style="width: 100px; height: 37px;"> Voltar </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection