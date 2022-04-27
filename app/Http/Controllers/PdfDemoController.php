<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Unidades;
use PDF;

class PdfDemoController extends Controller
{
    public function index(){
    	return view('PdfDemo');
    }
 
    public function samplePDF()
    {
        $html_content = Unidades::all();
      
        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
 
        PDF::Output('SamplePDF.pdf'); 
    }
 
 
    public function savePDF()
    {    
        $html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
         <h4>by<br/>Learn Infinity</h4>';
      
        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
 
        PDF::Output(public_path(uniqid().'_SamplePDF.pdf'), 'F');
    }
 
    public function downloadPDF()
    {    
        $html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
         <h4>by<br/>Learn Infinity</h4>';
      
 
        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
 
        PDF::Output(uniqid().'_SamplePDF.pdf', 'D');
    }
 
 
    public function HtmlToPDF()
    {    
        $unidades = Unidades::orderBy('id','asc')->get();
        $view = \View::make('HtmlToPDF', ['unidades'=>$unidades]);
        $html_content = $view->render();
        PDF::SetTitle("List of users");
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::Output('HtmlToPDF.pdf', 'D'); 
    }

    public function HtmlToPDF_cadastro()
    {
        return view('HtmlToPDF_cadastro');
    }

    public function cadastrarPDF(Request $request)
    {
        $input = $request->all();
		$nome = $_FILES['imagem']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('imagem') === NULL) {	
			$validator = 'Selecione um PDF!';
			return view('HtmlToPDF_cadastro')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao == 'jpg' || $extensao == 'png' || $extensao == 'jpeg') {
				$request->file('imagem')->move('../public/storage/unidade/', $nome);
				$input['imagem'] = $nome; 
				$input['caminho'] = 'unidade/'.$nome; 
				$unidade = Unidade::create($input);
				$unidades = Unidade::all();
				$validator = 'Unidade Cadastrada com Sucesso!';
				return view('unidade.unidade_cadastro', compact('unidades'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$validator = 'Só é permitido imagens: .jpg, .jpeg ou .png!';		
				return view('unidade.unidade_novo')
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
		}
    }
}