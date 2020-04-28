<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Recepcao";
	$chavePrimaria = "pk_id_consulta";
	$refer =  base_url()."Home/iniciar/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Imprimir Recibos de consultas</h2>
				<div class="clearfix"></div>
			</div>
			<?php
				if($this->session->flashdata('mensagemok')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-success alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemok')?>
						</div>
					</div>
			<?php endif;?>
			<?php
				if($this->session->flashdata('mensagemerror')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-danger alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemerror')?>
						</div>
					</div>
			<?php endif;?>
                  
				<form method="POST" action="<?php echo base_url($controler.'/imprimirRecibo')?>" target="_blank">
					<table id="datatable-fixed-header" class="table table-striped table-bordered">
							<thead>
								<tr>
									<?php

									for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
								?>
								  <th><?php echo $titulosTabela[$i]?></th>

								<?php 
									}
								?>	
									<th>Valor da consulta</th>
									<th>Imprimir</th>

								</tr>
							</thead>
							<tbody>

									<?php foreach($consultasFinalizadas as $consulta){
											$diaConsulta = date('d/m/Y', strtotime($consulta['ds_data_consulta']));
									?>

												<tr>
													<td><?php echo $consulta['pk_id_consulta'].'-'.$consulta['ds_nome_cliente']?></td>
													<td align="center"><?php echo $diaConsulta?></td>
													<td align="center"><?php echo $consulta['ds_nome_profissional']?></td>
													<td align="center">

															<input type="hidden" name="idConsulta" value="<?php echo $consulta['pk_id_consulta']?>" />
															<input type="text" class="dinheiro form-control" name="valor" required>

													</td>
													<td align="center">
														<button type="submit" class="btn btn-success botao-refresh">Imprimir</button>
													</td>

												</tr>
									<?php 	
										}
									?>
								
							</tbody>
						</table>
						<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
					</form>
				</div>
        	</div> 
		</div>
    </div>
</div>

