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
				<h2>Confirmar Consultas Agendadas</h2>
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
                  
				
				<table id="datatable-fixed-header" class="table table-striped table-bordered  nowrap">
						<thead>
							<tr>
								<?php
								
								for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
							?>
							  <th><?php echo $titulosTabela[$i]?></th>
								  
							<?php 
								}
							?>
								<th>Confirmar Consulta</th>
								<th>Cancelar Consulta</th>
								
							</tr>
						</thead>
						<tbody>
							
								<?php foreach($consultasAgendadas as $consulta){
										$diaConsulta = date('d/m/Y', strtotime($consulta['ds_data']));
										$horaConsulta = date('H:i', strtotime($consulta['ds_hora']));
										if($consulta['ds_status']!=3){
								?>
							
											<tr>
												<td><?php echo $consulta['ds_nome_cliente']?></td>
												<td align="center"><?php echo $diaConsulta?></td>
												<td align="center"><?php echo $horaConsulta?></td>
												<td align="center"><?php echo $consulta['ds_nome_profissional']?></td>
												<td align="center"><?php echo $consulta['ds_telefone']?></td>

												<?php 
													if($consulta['ds_status']==2){
												?>
												<td align="center"><a class="green pointer" data-id="<?php	echo '1'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> CONFIRMADO </a>
												</td>
												<?php
													}else{
												?>
												<td align="center"><a class="servicoConsulta pointer" data-id="<?php	echo '1'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> <i class="fa fa-check"></i></a>
												</td>
												<?php
													}
												?>
												<td align="center"><a class="servicoConsulta pointer" data-id="<?php	echo '2'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> <i class="far fa-times-circle red"></i></a>
												</td>
											</tr>
								<?php 	}
									}
								?>
						</tbody>
					</table>
					<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
				</div>
        	</div> 
		</div>
    </div>
</div>


<div class="modal fade" id="modalConfirmarConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Confirmar agendamento de consulta</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30"><i class="font35 amarelo fas fa-question-circle"></i>  Confirmar a Consulta de:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/confirmarConsulta/true')?>">
					<input class ="input-id"type="hidden" name="chavePrimaria" />
					<label class="label-nome font25 black"></label>
					<label class="label-dia font25 black"></label>
					<label class="label-hora font25 black"></label>
					<div class="modal-footer">
		        	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success botao-refresh">Confirmar</button>
					</div>	
				</form>
			</div>
    	</div>
  	</div>
</div>
<div class="modal fade" id="modalCancelarConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Cancelar o agendamento da consulta</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30 green"><i class="font35 amarelo fas fa-question-circle"></i>  Cancelar a consulta de:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/cancelarConsulta/true')?>">
					<input class ="input-id"type="hidden" name="chavePrimaria" />
					<label class="label-nome font25 black"></label>
					<label class="label-dia font25 black"></label>
					<label class="label-hora font25 black"></label>
					<div class="modal-footer">
		        	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success botao-refresh">Confirmar</button>
					</div>	
				</form>
			</div>
    	</div>
  	</div>
</div>
