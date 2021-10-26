@extends('layouts.app')
@section('content')

        <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" style="font-size: 16px;" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                       <center> <b>CADASTRAR DOCUMENTOS: </center></b> <i class="fas fa-check-circle"></i>
                     </a>
        </div>	
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
                                    <center> <table class="table table-sm table" style="width:1000px; align: center;">
                                    <thead>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="{{ route('novoDoc') }}" style="margin-left: 200px;" class="btn btn-sm btn-dark">Novo</a>
                                        </td>
                                    </tr>
                                    </thead>
                                    @foreach($documentos as $docs)
                                    <tr> 
                                        <td> <b>{{ $docs->nome }}</b> </td>
                                        <td > 
                                            <a href="{{route('alterarDoc',$docs->id)}}" style="margin-left: 700px;" class="btn btn-sm btn-warning">Alterar</a>
                                        </td>
                                        <td> 
                                            <a href="{{route('excluirDoc',$docs->id)}}" style="margin-left: 190px;" class="btn btn-sm btn-danger">Excluir</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </center>
                                
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection
