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
			#titulo{width:65%;float:left;}
			#titulo h1, #titulo h2,{text-align:center;margin:1px;}
			#titulo h1{font-size: 26px;}
			#titulo h2{font-size: 16px; margin-top: 50px;}
			#dadosEmpresa{float:right;height:80px;position:relative;}
			#dadosEmpresa h5{font-size:10px;margin:0;text-align:right;}
			
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
			#informacao p{
				text-indent: 2em;
				text-align:justify;
			}
			  table{
				  border-collapse: collapse;
				  margin-top:20px;
				  padding:0;
			  }
			  table, th, td {
  				border: 1px solid black; padding:3px;
				}
			  table tr th{
				  font-size:14px;
			  }
			  table tr td{
				  font-size:12px;
			  }
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
			  <h1>CLINMED - CLÍNICA MÉDICA</h1>
				
			</div>
			<div id="dadosEmpresa">
				<h5>Clínica Médica TCC Ltda.</h5>
				<h5>CNPJ: 46.901.515/0001-63</h5>
				<h5>Rua Carl Sagan, 1089</h5>
				<h5>Centro</h5>
				<h5>Divinópolis - MG</h5>
				<h5>(37) 3215 - 5555</h5>
			
			
			</div>
		</div>
		
		
		<h3>Relação de Clientes - <?php echo $profissional?></h3>
		
		<table>
			<thead>
				<tr>
					<th>Nome</th>
					<th>Endereço</th>
					<th>Telefone</th>
					<th>Celular</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($relacaoClientes as $cliente){?>
				<tr>
					<td><?php echo $cliente["ds_nome_cliente"]?></td>
					<td><?php echo $cliente["ds_logradouro"].", ".$cliente["ds_numresidencia"].", ".$cliente["ds_complemento"].", ".$cliente["ds_bairro"].", ".$cliente["ds_cidade"]?></td>
					<td><?php echo $cliente["ds_telfixo"]?></td>
					<td><?php echo $cliente["ds_telcel"]?></td>
					<td><?php echo $cliente["ds_email"]?></td>
				</tr>
				<?php } ?>
			</tbody>
		
		
		</table>
		
		
</body>
</html>