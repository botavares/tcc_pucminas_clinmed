<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if ( !function_exists('jsonMe')){
	
   function jsonMe($data=NULL){
	   echo json_encode( $data );
   }
}

//COLOCAR O ZERO NA FRENTE DE UM NÚMERO MENOR QUE 10
if ( !function_exists('num')){
	function num($num){
			return ($num < 10) ? '0'.$num : $num;
	}
}

//GERAR ZEROS A ESQUERDA DE NUMEROS MENORES QUE 10000
if( ! function_exists('zeroEsquerda')){
	
	function zeroEsquerda($num){
		return ($num <10000) ? str_pad($num,'4','0', STR_PAD_LEFT) : $num;
	}
}

//Gerar os dias dos meses de um determinado ano
if( ! function_exists('diasMeses')){
	function diasMeses($ano){
			$retorno = array();

			for($i = 1; $i<=12;$i++){
				$retorno[$i] = cal_days_in_month(CAL_GREGORIAN, $i, $ano);
			}

			return $retorno;
	}
}

//Imprimir 
if( ! function_exists('imprimir')){
	function imprimir($dados, $nomeArquivo,$orientacao){
		$ci =& get_instance();
		if($orientacao == "R"){
			$formato = "A4";
		}else{
			$formato = "A4-L";
		}
		// Instancia a classe mPDF
				require_once APPPATH . 'vendor/autoload.php';
				$mpdf = new \Mpdf\Mpdf(['mode' => 'c','format' => $formato,]);

				$mpdf->showImageErrors = true;
				$htmlL=$ci->load->view('impressos/'.$nomeArquivo, $dados,true);
				//$mpdf->SetJS('this.print()');
				$mpdf->writeHTML($htmlL);
				$mpdf->Output();
				
	}
}

	function postFile($host=NULL,$user=NULL,$pass=NULL,$caminhoServidor=NULL,$caminhoReal=NULL,$arquivo=NULL,$novoNome=NULL,$redirect=NULL){
		$ci =& get_instance();
		
		
		
		$config['allowed_types']= 'pdf';
		
		$handle = $caminhoReal;
		$fileName = $arquivo;
		$cutName = explode('.',$fileName);
		$name = $cutName[0];
		
		//abrir library ftp
				//$this->load->library('ftp');
				$ftp_config['hostname'] 	= $host; 
				$ftp_config['username'] 	= $user;
				$ftp_config['password'] 	= $pass;
				
				$ftp_config['debug']    	= TRUE;
				//conectar com servidor ftp
				$ci->ftp->connect($ftp_config);
				//caminho completo no servidor remoto
				
				
				$fullFile = $caminhoServidor.$fileName;
				$nome = $caminhoServidor.$novoNome;

				//Upload do arquivo
				$ci->ftp->upload($handle, $fullFile,'',0775);
				$ci->ftp->rename($fullFile, $nome);
				$ci->ftp->close();
}
function removerFormatacaoNumero( $strNumero )
	/*Esse código foi retirado do site:
	https://www.dirceuresende.com/blog/escrevendo-numero-por-extenso-no-php/
	*/
    {
 
        $strNumero = trim( str_replace( "R$", null, $strNumero ) );
 
        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }
 
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
 
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;
 
        return $resultado;
 
    }


if( ! function_exists('extenso')){
/* Esse código foi retirado do site:
	https://www.dirceuresende.com/blog/escrevendo-numero-por-extenso-no-php/
*/ function extenso($valor = 0, $maiusculas = false, $bolExibirMoeda = true, $bolPalavraFeminina = false) {
	$ci =& get_instance();
	
	$valor = removerFormatacaoNumero( $valor );
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
            
            
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
    }
	/*
	
	//Vai exibir na tela "um milhão, quatrocentos e oitenta e sete mil, duzentos e cinquenta e sete e cinquenta e cinco"
echo clsTexto::valorPorExtenso("R$ 1.487.257,55", false, false);
 
//Vai exibir na tela "um milhão, quatrocentos e oitenta e sete mil, duzentos e cinquenta e sete reais e cinquenta e cinco centavos"
echo clsTexto::valorPorExtenso("R$ 1.487.257,55", true, false);
 
//Vai exibir na tela "duas mil e setecentas e oitenta e sete"
echo clsTexto::valorPorExtenso("2787", false, true);

*/
}

function mesExtenso($data){
	list($dia,$mes,$ano) = explode("/",$data);
	$meses = array('janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
	for($i=1;$i<13;$i++){
		$nmmes = $mes-1;
		$nomeMes = $meses[$nmmes];
	}
	return $dia." de ".$nomeMes. " de ".$ano;
}
	