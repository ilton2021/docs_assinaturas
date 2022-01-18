<!DOCTYPE HTML>
<html>
	<head>
		<title>Processo Seletivo - HCP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{ ('assets/css/main.css') }}" />
	</head>
	<body class="is-preload">
			<div id="header">
				<div class="top">
						<div id="logo">
							<p><span class=""><a href="{{ url('/') }}"><img src="{{ asset('imagens/gestao2.png') }}" alt="" /></a></span></p>
							<h1 id="title">Assinaturas de NF</h1>
							<p>HCPGestão</p>
						</div>
						<nav id="nav">
							<ul>
								<li><a href="{{ route('cadastroBasicos') }}" id="portfolio-link"><span class="icon solid fa-calendar-plus">Cadastros Básicos</span></a></li>
								<li><a href="{{ route('cadastroDoc') }}" id="about-link"><span class="icon solid fa-book-open">Cadastrar Documento</span></a></li>
								<li><a href="{{ route('escolher_unidade') }}" id="avisos-link"><span class="icon solid fa-check-square">Novo Fluxo</span></a></li>
								<li><a href="{{ route('validarDocs') }}" id="about-link"><span class="icon solid fa-calendar-check">Validar Documento</span></a></li>
								<li><a href="{{ route('visualizarFluxos') }}" id="portfolio-link"><span class="icon solid fa-th">Visualizar Fluxo</span></a></li>
                                <li>
									<a href="{{ route('logout') }}" onclick="event.preventDefault(); 
                                                     document.getElementById('logout-form2').submit();">
                                        {{ __('Sair') }}
                                    </a>

                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</li>
							</ul>
						</nav>
				</div>
			</div>

			<div id="main">
					<section id="top" class="one dark cover" style="width:100%; height: 300px">
						<div class="container">
							<header>
								<span class=""><img src="images/avatar.jpg" alt="" style="margin-top: -180px" /></span>
								<h2 class="alt">Portal de Assinaturas de Notas Fiscais</h2>
								<p>Bem Vindo ao Portal de Assinaturas de Notas Fiscais.</p>
							</header>
						</div>
					</section>
			</div>

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
	</body>
</html>