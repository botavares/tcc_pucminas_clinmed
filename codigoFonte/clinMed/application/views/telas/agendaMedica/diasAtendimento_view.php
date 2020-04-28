<?php
$controler = "DiasAtendimento";
$nomeItem = 'ds_nome_profissional';
$assunto = "Dias de Atendimento";
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
			<a href="<?php echo base_url()."DiasAtendimento/formDiasSemana"?>" id="addItem" class="btn btn-primary"><?php echo "Adicionar ".$assunto?> <i class="fa fa-plus"></i></a>

			<table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                        	<?php
								for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
							?>
							  <th align="center"><?php echo $titulosTabela[$i]?></th>
								  
							<?php 
								}
							?>

							<th>Excluir</th>
                        </tr>
                      </thead>
                      <tbody>
                      	
						<?php
						  foreach($dados as $keyDados){
							switch($keyDados['ds_segunda']){
								case 1:
									$segunda = "Dia todo";
									break;
								case 2:
									$segunda = "Manhã";
									break;
								case 3:
									$segunda = "Tarde";
									break;
								default:
									$segunda = "Não atende";
									  break;
							  }
							  switch($keyDados['ds_terca']){
								case 1:
									$terca = "Dia todo";
									break;
								case 2:
									$terca = "Manhã";
									break;
								case 3:
									$terca = "Tarde";
									break;
								default:
									$terca = "Não atende";
									  break;
							  }
							  switch($keyDados['ds_quarta']){
								case 1:
									$quarta = "Dia todo";
									break;
								case 2:
									$quarta = "Manhã";
									break;
								case 3:
									$quarta = "Tarde";
									break;
								default:
									$quarta = "Não atende";
									break;
							  }
							  switch($keyDados['ds_quinta']){
								case 1:
									$quinta = "Dia todo";
									break;
								case 2:
									$quinta = "Manhã";
									break;
								case 3:
									$quinta = "Tarde";
									break;
								default:
									$quinta = "Não atende";
									  break;
							  }
							  switch($keyDados['ds_sexta']){
								case 1:
									$sexta = "Dia todo";
									break;
								case 2:
									$sexta = "Manhã";
									break;
								case 3:
									$sexta = "Tarde";
									break;
								default:
									$sexta = "Não atende";
									  break;
							  }
						?>
						  <tr>
							<td><?php echo $keyDados['ds_nome_profissional']?></td>
                            <td align="center"><a class="editItemDiasAtendimento pointer" 
												  data-id="<?php echo $keyDados['pk_id_profissional']."|"."1"?>" title="clique para alterar"><?php echo $segunda?></a></td>
							<td align="center"><a class="editItemDiasAtendimento pointer" 
												  data-id="<?php echo $keyDados['pk_id_profissional']."|"."2"?>"><?php echo $terca?></a></td>
                            <td align="center"><a class="editItemDiasAtendimento pointer" 
												  data-id="<?php echo $keyDados['pk_id_profissional']."|"."3"?>"><?php echo $quarta?></a></td>
                            <td align="center"><a class="editItemDiasAtendimento pointer" 
												  data-id="<?php echo $keyDados['pk_id_profissional']."|"."4"?>"><?php echo $quinta?></a></td>
                            <td align="center"><a class="editItemDiasAtendimento pointer" 
												  data-id="<?php echo $keyDados['pk_id_profissional']."|"."5"?>"><?php echo $sexta?></a></td>
								
						  
							<td align="center"><a class="deleteItem pointer" data-id="<?php	echo $keyDados['pk_id_profissional'].'|'.$keyDados['ds_nome_profissional']?>"> <i class="fa fa-trash"></i></a>
							</td>
						</tr>
						  <?php } ?>
                     
                      </tbody>
			</table>
		</div>
	</div>
</div>
        <!-- /page content -->
		<!-- modals-->
		<!-- MODAL PARA EDIÇÃO DE ITENS-->
		<div class="modal fade" id="modalEditDiasAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="x_title">
						<h2>Alterar dias de atendimento</h2>
						<div class="clearfix"></div>
					</div>
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."DiasAtendimento/alterarDiasAtendimento"?>" >
					<div class="form-group">
						
						<input type="hidden" name="action" value="update"/>
						<input type="hidden" name="id" id="input-id"/>
						<input type="hidden" name="selectMedico" id="input-medico"/>
						
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Médico</label>
                        <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
							<input type="text" name="nome" class="form-control" id="input-nome"value="<?php echo set_value('nome'); ?>" readonly/>
							<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
						</div>
						
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Dia da semana</label>
						<div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
							<input type="hidden" name ="diaSemana" id="input-diaSemana" class="form-control" readonly/>
							<input type="text" name ="nomeDia" id="input-nomeDia" class="form-control" readonly/>
							<?php echo form_error('diaSemana', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Período de atendimento</label>
						<div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
							<select name ="turno" id="input-turno" class="form-control">
								<option value="0" <?php echo set_select('turno',"0"); ?> >Não atende</option>
								<option value="1" <?php echo set_select('turno',"1"); ?> >Dia Todo</option>
								<option value="2" <?php echo set_select('turno',"2"); ?> >Manhã</option>
								<option value="3" <?php echo set_select('turno',"3"); ?> >Tarde</option>
							</select>
							<?php echo form_error('turno', '<div class="error">', '</div>'); ?>
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
						<h5 class="modal-title font25 red bold ta-center">Exclusão de Dias de Atendimento</h5>

					</div>
					<div class="modal-body">
						<p class="font25 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Deseja excluir os dias de atendimento de:</p>
						<form method="POST" action="<?php echo base_url($controler.'/deletarDiasAtendimento/')?>">
							<input id="chavePrimaria"type="hidden" name="chavePrimaria" />
							<label class="font25 black " id="nomeItem"></label>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal"><strong>cancelar</strong></button>
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