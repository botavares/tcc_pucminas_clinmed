<?php
$controler 		= "PlanosSaude";
$chavePrimaria	= 'pk_id_profissional';
$nomeItem		= 'ds_nome_profissional';
$assunto		= "Vincular Médicos a Plano de Saúde";
?>

<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Vincular Médicos a Plano de Saúde</h2>
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
					<div id="mensagemErro" class="mensagem alert alert-danger alert-block alert-aling" role="alert">
						<?php echo $this->session->flashdata('mensagemerror')?>
					</div>
				</div>
			<?php endif;?>

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
						<th>Vincular</th>
						<th>Desvincular</th>
						
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($dadosMedicos as $dadosMedico){?>
					<tr>
						<td><?php echo $dadosMedico['ds_nome_profissional']?></td>
						<td><?php echo $dadosMedico['ds_nome_especialidade']?></td>
						<td align="center"><a class="pointer vincularPlanoSaude" data-id="<?php	echo $dadosMedico[$chavePrimaria]?>" > <i class="fas fa-link"></i></a>
						</td>
						<td align="center"><a class="pointer desvincularPlanoSaude" data-id="<?php	echo $dadosMedico[$chavePrimaria]?>" > <i class="fas fa-unlink"></i></a>
						</td>
						
					</tr>
						<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
        <!-- /page content -->
		<!-- /modals-->
		<!-- /MODAL PARA EDIÇÃO DE ITENS-->
<div class="modal fade" id="modalVincularPlanos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_title">
					<h2>Vincular Médico aos seus Planos de Saúde</h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().$controler.'/registrarVinculoMedicoPlano'?>">
					<input type="hidden" id="idMedico" name="idMedico">
					
					<input type="hidden" name="action" value="create">
					<h3 class="green">Escolha o(s) plano(s):</h3>
					<div class="overflowY">
						 <div class="table-responsive">
                      		<table class="table table-striped jambo_table bulk_action">
                        		<thead>
                         			<tr class="headings">
                            			<th>
                              				<input type="checkbox" id="check-all" class="flat">
                            			</th>
                            			<th class="column-title">Plano</th>
									</tr>
								</thead>
								
								<tbody>
									<?php
									foreach($dadosPlanos as $dadosPlano){?>
                          			<tr class="even pointer">
                            			<td class="a-center ">
                              				<input type="checkbox" id="input-plano<?php echo $dadosPlano["pk_id_plano"]?>" name="idPlano[]" class="flat form-control" value="<?php echo $dadosPlano["pk_id_plano"]?>">
											<?php echo form_error('idPlano', '<div class="error">', '</div>'); ?>
                            			</td>
										<td class="a-center ">
											<?php echo $dadosPlano["ds_nome_plano"]?>
										</td>
									</tr>
									<?php
						   			}
									?>
								</tbody>
							</table>
						</div>
			
					</div>
					<div>
					
					
					</div>
					  
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modalDesvincularPlanoSaude" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_title">
					<h2>Desvincular Médico aos Planos de Saúde</h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().$controler.'/registrarVinculoMedicoPlano'?>">
					<input type="hidden" id="idMedico" name="idMedico">
					
					<input type="hidden" name="action" value="delete">
					<h3 class="green">Escolha o(s) plano(s):</h3>
					<div class="overflowY">
						 <div class="table-responsive">
                      		<table class="table table-striped jambo_table bulk_action">
                        		<thead>
                         			<tr class="headings">
                            			<th>
                              				<input type="checkbox" id="check-all" class="flat">
                            			</th>
                            			<th class="column-title">Plano</th>
									</tr>
								</thead>
								
								<tbody class="tbody-desvincular">
									
								</tbody>
							</table>
						</div>
			
					</div>
					<div>
					
					
					</div>
					  
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="submit" class="btn btn-success">Desvincular</button>
						</div>
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

