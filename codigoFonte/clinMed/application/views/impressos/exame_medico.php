<?php
	ob_start();
?>
<!DOCTYPE html>
	<html>
		<head>
            <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
          <style type="text/css">
			 
			body{font-family:Arial;font-size:20px;padding:0;}
				
			#brasao img{margin-left:20%;}
			#pagina,#ladoD{margin-top:0;}
			#pagina{width:100%;position:relative; clear:left;margin-left:0px;z-index:99;}
			#ladoD{width:100%;position:relative; clear:right;z-index:99;}
			.cabecalho{width:100%; height:45px;}
			.rodape{height:45px;}
			h3{text-align:center; font-size:20px; margin:20px 0 20px 0;}
			
			#titulo,#brasao{height:80px; float:left; position: relative;}
			#brasao{width: 86px;}
			#titulo{width:80%;float:left;}
			#titulo h1, #titulo h2,{text-align:center;margin:1px;}
			#titulo h1{font-size: 26px;}
			#titulo h2{font-size: 16px; margin-top: 50px;}
			
			  #tituloPaciente,#tituloMedico{
				  font-size:18px;
				  font-weight:bold;
				  margin:0;
			  }
			  #nomePaciente,#nomeMedico{
				  font-size:16;
				  font-style: italic;
				  margin:0;
			  }
			#informacao div{
				font-size: 14px; text-align:left; /*border-bottom: thin solid #000000;*/
				margin-bottom:0;
			}
			  .item{font-weight: bold;margin:0; }
			  .descricao{font-style: italic; margin-top:5px;}
			  #assinatura{margin-top:60px;}
			  #assinatura p{text-align:center; font-size:14;margin:0;}
			
            </style>
            
		</head>


	<div style="width:70%; position: absolute; left:15%; right: 0; top: 0; bottom: 0;z-index:-99;">
		<img src="<?php echo $fundo?>" style="width: 300mm; height: 225mm; margin: 300px auto; opacity:0.2;z-index:-99;"/>
	</div>
	<div id="pagina" style="z-index:99;">
		<div class="cabecalho">

			<div id="brasao">
			
				<img src="<?php echo $brasao?>"/>
				
			</div>
			<div id="titulo">
			  <h1>CLINMED - PEDIDO DE EXAME MÉDICO</h1>
			</div>

		</div>
		
		
		<h3>EXAMES MÉDICOS -  <?php // echo $tipoEmpresa?></h3>
		<div>
			<p id="tituloPaciente">PACIENTE:</p>
			<P id="nomePaciente"><?php echo $dadosPaciente[0]["ds_nome_cliente"]?></P>
		</div>
		<div>
			<p id="tituloMedico">MÉDICO</p>
			<p id="nomeMedico"><?php echo $dadosMedico[0]["ds_nome_profissional"]?> - <?php echo $especialidade[0]["ds_nome_especialidade"]?> - CRM: <?php echo $dadosMedico[0]["ds_crm"]?></p>
		</div>
		<div id="informacao">
			<h3> Exames a serem providenciados</h3>
			<?php foreach($exameMedico as $exame){?>
				<div>
					<p class="item"><?php echo $exame["ds_nome_exame"]?></p>
					<p class="descricao"><?php echo $exame["ds_resultado_exame"]?></p>
				</div>
			<?php } ?>
			
		</div>
		<div id="assinatura">
			<p><?php echo $dadosMedico[0]["ds_nome_profissional"]?></p>
			<p>CRM: <?php echo $dadosMedico[0]["ds_crm"]?></p>
		</div>
		
		
</body>
</html>