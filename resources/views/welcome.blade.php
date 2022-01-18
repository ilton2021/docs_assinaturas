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
							<p><span class=""><a href="{{ url('/') }}"><img src="imagens/gestao2.png" alt="" /></a></span></p>
							<h1 id="title">Assinaturas de NF</h1>
							<p>HCPGestão</p>
						</div>
				</div>
			</div>

			<div id="main">
					<section id="top" class="one dark cover" style="width:100%; height: 300px">
						<div class="container">
							<header>
								<span class=""><img src="{{ asset('imagens/avatar.jpg') }}" alt="" style="margin-top: -180px" /></span>
								<h2 class="alt">Portal de Assinaturas de Notas Fiscais</h2>
								<p>Bem Vindo ao Portal de Assinaturas de Notas Fiscais.</p>
							</header>
						</div>
					</section>
					
					<section id="portfolio1" class="two">
						<div class="container">
							<form method="get" action="{{ route('login') }}">	
							  <center><button id="div" href="" target="_blank">Iniciar</button></center>
							</form>
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