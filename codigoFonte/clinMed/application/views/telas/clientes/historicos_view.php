<?php
$controler = "Medicos";
$refer =  base_url()."Medicos/formPacienteHistorico/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Prontuário do paciente <?php echo $paciente[0]["ds_nome_cliente"]?></h2>
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
			
			
			<p>
		
			
			</p>
			<a class="btn btn-primary" href="<?php echo base_url()."Medicos/historicoPaciente/".$paciente[0]["pk_id_cliente"]."/".$medico[0]["pk_id_profissional"]."/"."imprimir"?>"><i class="fas fa-print"></i> Imprimir Prontuário</a>
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
													<p  class="m-0"><span class="green">Exame: </span> <?php echo $valueExames['ds_nome_exame'].":"?></p>
													<p><span class="blue">Resultado: </span><?php echo $valueExames['ds_resultado_exame']?></p>
													
											<?php }?>
											</td>
										<td>
											<?php
												foreach($valueHistorico['receita'] as $keyReceita => $valueReceita){?>
													<p  class="m-0"><span class="green">Medicamento: </span> <?php echo $valueReceita['ds_nome_generico']." (".$valueReceita['ds_nome_medicamento']."):"?></p>
													<p><span class="blue">posologia: </span><?php echo $valueReceita['ds_posologia']?></p>
													
											<?php }?>
										</td>
										<td><?php echo $valueHistorico['parecer']?></td>
									
									
								</tr>
						<?php } ?>
				</tbody>
			</table>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
		</div>
	</div>
</div>
<div class="modal fade" id="modalErros" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 id="nome-erro" class="modal-title font25 red bold ta-center"> </h5>

					</div>
					<div class="modal-body">
						<p id="descricao-erro" class="font20 "></p>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal"><strong>Retornar</strong></button>

					</div>	
				</div>
			</div>
		</div>      