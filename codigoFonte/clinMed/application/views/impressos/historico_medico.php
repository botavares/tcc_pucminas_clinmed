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
	
<htmlpageheader name="otherpages" style="display:none">
   	<div style="text-align:center">HISTÓRICO MÉDICO - <?php echo $paciente[0]["ds_nome_cliente"]?> </div>
</htmlpageheader>
<sethtmlpageheader name="otherpages" value="on" />
		
	<div style="width:70%; position: absolute; left:40%; right: 0; top: 0; bottom: 0;z-index:-99;">
		<img src="<?php echo $fundo?>" style="width: 590mm; height: 492mm; margin: 300px auto; opacity:0.2;z-index:-99;"/>
	</div>
	<div id="pagina" style="z-index:99;">
		<div class="cabecalho">

			<div id="brasao">
			
				<img src="<?php echo $brasao?>"/>
				
			</div>
			<div id="titulo">
			  <h1>CLINMED - CLÍNICA MÉDICA</h1>
			</div>

		</div>
		
		
		<h3>HISTÓRICO MÉDICO <?php // echo $tipoEmpresa?></h3>
		<div>
			<p id="tituloPaciente">PACIENTE:</p>
			<P id="nomePaciente"><?php echo $paciente[0]["ds_nome_cliente"]?></P>
		</div>
		<div>
			<p id="tituloMedico">MÉDICO</p>
			<p id="nomeMedico"><?php echo $medico[0]["ds_nome_profissional"]?> - CRM: <?php echo $medico[0]["ds_crm"]?></p>
		</div>
		
		<table id="datatable-fixed-header" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php
							for($i = 0,$j=count($titulosHistorico);$i<$j;$i++){
						?>
						<th><?php echo $titulosHistorico[$i]?></th>
						<?php 
							}
						?>
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($historico as $keyHistorico => $valueHistorico){?>
								<tr>
									<td class="red"><?php echo $valueHistorico['idConsulta']?></td>
									<td><?php echo $valueHistorico['data']?></td>
									<td><?php echo $valueHistorico['queixa']?></td>
									
										
											<td>
											<?php
												foreach($valueHistorico['exames'] as $keyExames => $valueExames){?>
													<p><strong>Exame:</strong> <?php echo $valueExames['ds_nome_exame'].":"?></p>
													<p><strong>Resultado:</strong> <?php echo $valueExames['ds_resultado_exame']?></p>
													<br>
											<?php }?>
											</td>
										<td>
											<?php
												foreach($valueHistorico['receita'] as $keyReceita => $valueReceita){?>
													<p><strong>Medicamento:</strong> <?php echo $valueReceita['ds_nome_generico']." (".$valueReceita['ds_nome_medicamento']."):"?></p>
													<p><strong>posologia:</strong><?php echo $valueReceita['ds_posologia']?></p>
													<br>
											<?php }?>
										</td>
									
									
								</tr>
						<?php } ?>
				</tbody>
			</table>
		
		
		
		<div id="assinatura">
			<p><?php echo $medico[0]["ds_nome_profissional"]?></p>
			<p>CRM: <?php echo $medico[0]["ds_crm"]?></p>
		</div>
		
		
</body>
</html>