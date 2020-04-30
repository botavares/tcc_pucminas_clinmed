<?php
$controler = "Medicamentos";
$chavePrimaria = 'pk_id_medicamento';
$nomeItem = 'ds_nome_generico';
$assunto = "Medicamentos";
$refer =  base_url()."Home/iniciar/";
?>

<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Gerenciamento de <?php echo $controler?></h2>
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
			<a href="<?php echo base_url().$controler."/form".$controler?>" id="addItem" class="btn btn-primary"><?php echo $assunto?> <i class="fa fa-plus"></i></a>
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
				foreach($dados as $keyDados){
				?>
					<tr>
						<td><?php echo $keyDados['ds_nome_generico']?></td>
						<td><?php echo $keyDados['ds_nome_medicamento']?></td>
						<td><?php echo $keyDados['ds_apresentacao']?></td>
						<td><?php echo $keyDados['ds_nome_fabricante']?></td>
						<td align="center"><a class="editItemMedicamentos pointer" data-id="<?php	echo $keyDados[$chavePrimaria]?>"> <i class="fa fa-edit"></i></a>
						</td>
						<td align="center"><a class="deleteItem pointer" data-id="<?php	echo $keyDados[$chavePrimaria].'|'.$keyDados[$nomeItem]?>"> <i class="fa fa-trash"></i></a>
				</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<a class="btn btn-success" data-toggle="modal" data-target="#modalRecuperaItens"><?php echo "Recuperar ".$assunto?>  <i class="fa fa-recycle"></i></a>
	<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
</div>

			
        
        <!-- /page content -->
		<!-- modals-->
		<!-- MODAL PARA EDIÇÃO DE ITENS-->
		<div class="modal fade" id="modalEditMedicamentos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="x_title">
						<h2>Alterar dados do Medicamento</h2>
						<div class="clearfix"></div>
					</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler.'/create'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome Genérico</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="nomeGenerico" id="edit-nomeGenerico" class="form-control col-md-10" required/>
								<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
								<input type="hidden" id="edit-id" name="id">
								<input type="hidden" name="action" value="update">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Medicamento</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="nomeMedicamento" id="edit-nomeMedicamento" class="form-control col-md-10" required/>
								<?php echo form_error('nomeMedicamento', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Apresentação</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="apresentacao" id="edit-apresentacao" class="form-control col-md-10" required/>
								<?php echo form_error('apresentacao', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Especialidade principal</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="especialidade" id="edit-especialidade" class="form-control" required>
								<option selected></option>
								<?php foreach($especialidades as $especialidade){?>
									<option value="<?php echo $especialidade["pk_id_especialidade"]?>"><?php echo $especialidade["ds_nome_especialidade"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('especialidade', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Posologia</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<textarea class="resizable_textarea form-control" name = "posologia"  id="edit-posologia" placeholder="Posologia do medicamento. Texto livre"></textarea>
								<?php echo form_error('posologia', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Restrições</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<textarea class="resizable_textarea form-control" name = "restricoes"  id="edit-restricoes" placeholder="Restrições do medicamento. Texto livre"></textarea>
								<?php echo form_error('restricoes', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Classe</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="classe" id="edit-classe" class="form-control">
								<option selected></option>
								<?php foreach($classe as $keyClasses){?>
									<option value="<?php echo $keyClasses["pk_id_classe"]?>"><?php echo $keyClasses["ds_nome_classe"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('classe', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Fabricante</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="fabricante" id="edit-fabricante" class="form-control">
								<option selected></option>
								<?php foreach($fabricantes as $keyFabricante){?>
									<option value="<?php echo $keyFabricante["pk_id_fabricante"]?>"><?php echo $keyFabricante["ds_nome_fabricante"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('fabricante', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
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

		<!-- MODAL PARA EXCLUIR ITENS -->
		<div class="modal fade" id="modalDeleteItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title font25 red bold ta-center">Excluir um Medicamento</h5>

					</div>
      				<div class="modal-body">
						<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Você deseja excluir:</p>
        				<form method="POST" action="<?php echo base_url($controler.'/deleteLogico/')?>">
            		    	<input id="chavePrimaria"type="hidden" name="chavePrimaria" />
							<label class="font25 black " id="nomeItem"></label>
							<div class="modal-footer">
					        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        					<button type="submit" class="btn btn-success botao-refresh">Excluir</button>
      						</div>	
        				</form>
      				</div>
    			</div>
  			</div>
		</div>
		

		<!-- MODAL PARA RECUPAR ITENS EXCLUIDOS DE FORMA LÓGICA-->
		<div class="modal fade" id="modalRecuperaItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  		<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title font25 red bold ta-center">Recuperar medicamento excluído</h5>
					</div>
					<div class="modal-body">
						<form method="POST" action="<?php echo base_url($controler.'/recuperaLogico/')?>">

            		    	<div class="form-group">
								<label class="control-label col-lg-4 col-md-12 col-sm-12 col-xs-12 font16 blue">Medicamento</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select name ="chavePrimaria" id="chavePrimaria" class="form-control">
										<option selected></option>
										<?php foreach($medExcluidos as $keyMedExcluidos){?>
										<option value="<?php echo $keyMedExcluidos["pk_id_medicamento"]?>"><?php echo $keyMedExcluidos["ds_nome_medicamento"]." - ".$keyMedExcluidos["ds_apresentacao"]?></option>
										<?php } ?>
										</select>
										<?php echo form_error('fabricante', '<div class="error">', '</div>'); ?>
								</div>
							</div>
							<div class="form-group">
					        	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        					<button type="submit" class="btn btn-success botao-refresh">Recuperar</button>
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