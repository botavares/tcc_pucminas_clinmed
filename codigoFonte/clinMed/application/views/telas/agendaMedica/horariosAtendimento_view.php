<?php
$controler = "HorariosAtendimento";
$chavePrimaria = 'pk_id_horarios';
$nomeItem = 'ds_nome_profissional';
$assunto = "Horários de atendimento";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2><?php echo $assunto." dos médicos"?></h2>
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
			<a href="<?php echo base_url()."HorariosAtendimento/formHorariosAtendimento"?>" id="addItem" class="btn btn-primary"><?php echo "Adicionar ".$assunto?> <i class="fa fa-plus"></i></a>
	
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
                       		<th>Alterar</th>
							<th>Excluir</th>
                        </tr>
                      </thead>
                      <tbody>
                      	
						<?php
						  foreach($dados as $keyDados){?>
						  <tr>
							<td><?php echo $keyDados['ds_nome_profissional']?></td>
                            <td><?php echo date('H:i',strtotime($keyDados['ds_horarioini_matutino']))."h"." às ".
							date('H:i',strtotime($keyDados['ds_horariofim_matutino']))."h"?></td>
							<td><?php echo date('H:i',strtotime($keyDados['ds_horarioini_vespertino']))."h"." às ".
							date('H:i',strtotime($keyDados['ds_horariofim_vespertino']))."h"?></td>
						  	<td align="center"><a class="editItemHorariosAtendimento pointer" data-id="<?php	echo $keyDados['pk_id_horarios']?>"> <i class="fa fa-edit"></i></a>
							</td>
							<td align="center"><a class="deleteItem pointer" data-id="<?php	echo $keyDados['fk_id_profissional'].'|'.$keyDados['ds_nome_profissional']?>"> <i class="fa fa-trash"></i></a>
							</td>
						</tr>
						  <?php } ?>
                     

			</table>
		</div>
	</div>
</div>
        <!-- /page content -->
		<!-- modals-->
		<!-- MODAL PARA EDIÇÃO DE ITENS-->
		<div class="modal fade" id="modalEditHorariosAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="x_title">
						<h2>Alterar horários de atendimento</h2>
						<div class="clearfix"></div>
					</div>
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."HorariosAtendimento/registrarHorariosAtendimento"?>" >
					<div class="form-group">
						
						<input type="hidden" name="action" value="update"/>
						<input type="hidden" id="input-id" name="id" />
						<input type="hidden" id="input-medico" name="selectMedico" />
						
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Médico</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" id="input-nome" class="form-control" name="nome" value="<?php echo set_value('nome'); ?>" readonly/>
							<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Atendimento Matutino</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="mb-10 ">
								<label for="entrada-matutino" class="control-label  green mr-10">Entrada:</label>
								<input type="text" class="horas form-control" name="entradaMatutino" id="entrada-matutino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('entradaMatutino'); ?>"/>
								<?php echo form_error('entradaMatutino', '<div class="error">', '</div>'); ?>
								
								<label for="saida-matutino" class="control-label red mr-10">Saída:</label>
								<input type="text" class="horas form-control" name="saidaMatutino" id="saida-matutino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('saidaMatutino'); ?>"/>
								<?php echo form_error('saidaMatutino', '<div class="error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Atendimento Vespertino</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="mb-10 ">
								<label for="entrada-vespertino" class="control-label  green mr-10">Entrada:</label>
								<input type="text" class="horas form-control" name="entradaVespertino" id="entrada-vespertino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('entradaVespertino'); ?>"/>
								<?php echo form_error('entradaVespertino', '<div class="error">', '</div>'); ?>
								
								<label for="saida-vespertino" class="control-label red mr-10">Saída:</label>
								<input type="text" class="horas form-control" name="saidaVespertino" id="saida-vespertino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('saidaVespertino'); ?>"/>
								<?php echo form_error('saidaVespertino', '<div class="error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Tempo Médio de Consulta</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" id="input-tmpConsulta" class="form-control" name="tmpConsulta" value="<?php echo set_value('tmpConsulta'); ?>"/>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
			  </div>
			</div>
		  </div>
		</div>

		
		<div class="modal fade" id="modalDeleteItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title font25 red bold ta-center">Exclusão de Horários de Atendimento</h5>

					</div>
					<div class="modal-body">
						<p class="font25 blue"><i class="font35 amarelo fas fa-question-circle"></i>   Deseja excluir os horários de atendimento de:</p>
						<form method="POST" action="<?php echo base_url('HorariosAtendimento/deletarHorariosAtendimento/')?>">
							<input id="chavePrimaria"type="hidden" name="chavePrimaria" />
							<label class="font25 black " id="nomeItem"></label>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal"><strong>Cancelar</strong></button>
								<button type="submit" class="btn btn-success botao-refresh"><strong>Excluir</strong></button>
							</div>	
						</form>
					</div>
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
		
