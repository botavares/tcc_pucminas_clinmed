<?php
$controler = "Consultas";
$assunto = "Agendar Consultas Médicas";
$anoAtual = date('Y');
$refer =  base_url()."Home/iniciar/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Consultas Confirmadas <small class="red"u>Para o dia de hoje</small></h2>
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
			<div class="x_panel">
				<div class="x_content">
					<table id="datatable-fixed-header" class="table table-striped table-bordered">
						<thead>
							<tr>
								<?php
									for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
								?>
								<th ><?php echo $titulosTabela[$i]?></th>
								<?php 
									}
								?>

								<th>Vincular Cliente</th>

							</tr>
						</thead>
						<tbody>
								<?php
									foreach($consultasHoje as $keyConsultas){?>
							<tr>
								<td align="center" class="red"><?php echo  $keyConsultas['fk_id_cliente'] > 0 ? $keyConsultas['ds_numero_consulta'] : '0'?></td>
								<td><?php echo $keyConsultas['ds_nome_cliente']?></td>
								<td align="center"><?php echo date('d/m/Y',strtotime($keyConsultas['ds_data']))?></td>
								<td align="center"><?php echo date('H:i',strtotime($keyConsultas['ds_hora']))?></td>
								<td align="center"><?php echo $keyConsultas['ds_tipo_atendimento'] == 1 ? "CONSULTA" : "RETORNO" ?></td>
								<td><?php echo $keyConsultas['ds_nome_plano'] ?></td>
								<td><?php echo $keyConsultas['ds_nome_profissional']?></td>


								<?php 
										if($keyConsultas['fk_id_cliente'] > 0){
								?>
											<td align="center"><a class="desvincularCliente btn btn-success pointer" data-id="<?php	echo  $keyConsultas['pk_id_agendaconsulta'].'|'.$keyConsultas['ds_nome_cliente'].'|'.$keyConsultas['pk_id_profissional']?>">VINCULADO</a>
											</td>			
								<?php
										}else{
								?>
											<td align="center"><a class="vincularCliente btn btn-primary pointer" data-id="<?php	echo  $keyConsultas['pk_id_agendaconsulta'].'|'.$keyConsultas['ds_nome_cliente'].'|'.$keyConsultas['pk_id_profissional']?>">VINCULAR</a>
											</td>
								<?php
										}
								?>
							</tr>
								<?php } ?>
						</tbody>
					</table>
					<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalprocurarClienteCadastrado" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 blue bold ta-center">Vincular agendamento ao cliente</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font20">Vincular agendamento de:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/confirmarConsulta/true')?>">
					<input type="hidden" id="idAgendamento"	name="idAgendamento" />
		   			<input type="hidden" id="nomeCliente"	name="nomeCliente" />
					
					<input type="text" name="cpfCliente" id="input-cpfCliente" class="form-control col-md-10 cpf" placeholder="Digite o CPF a procurar" required/>
                    <?php echo form_error('cpfCliente', '<div class="error">', '</div>'); ?>
				</form>
				<div class="modal-footer">
		        		<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
						<button type="button" id="procurarClienteCadastrado" class="btn btn-success">Procurar</button>
					</div>
			</div>
    	</div>
  	</div>
</div>
<div class="modal fade" id="modalVincularCliente" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
				<h5 class="modal-title font25 red bold ta-center">Vínculos de Agendamento</h5>
      		</div>
      		<div class="modal-body">
        		<form method="POST" action="<?php echo base_url()."Recepcao/VincularAgendamentoConsulta"?>">
					<h5 class="modal-title font30 black" id="modalLabel"></h5>
					<input id="idCliente"type="hidden" name="idCliente" />
					<input id="idAgendar"type="hidden" name="idAgendar" />
					<input id="idMedico"type="hidden" name="idMedico" />
					
					<label class="font20 green" id="nomeClienteCadastrado"></label>
					<div class="modal-footer">
		        		<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
						<button type="submit" id="btnVinculos" class="btn btn-success"></button>
					</div>	
        		</form>
      		</div>
    	</div>
  </div>
</div>

<div class="modal fade" id="modalCadastrarCliente" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Cliente para vínculo não encontrado</h5>
      		</div>
				<div class="modal-body">
						<p class="font25" id="modalLabel"><i class="font35 amarelo fas fa-question-circle"></i>  Cliente Não Encontrado. Deseja Cadastrá-lo?</p>
						<h5 class="modal-title" ></h5>
				</div>
			<div class="modal-footer">
		    	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
				<a class="btn btn-success" href="<?php echo base_url()."Clientes/formClientes/vincular"?>">Cadastrar</a>
			</div>	
        		
      	</div>
	</div>
</div>

