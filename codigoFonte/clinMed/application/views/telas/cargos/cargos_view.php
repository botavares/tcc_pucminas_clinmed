<?php
$controler 		= "Cargos";
$chavePrimaria	= 'pk_id_cargo';
$nomeItem		= 'ds_nome_cargo';
$assunto		= "Adicionar Cargo";
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
			<table id="datatable-fixed-header" class="table table-striped table-bordered nowrap">
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
							foreach($dadosCargos as $dadosCargo){?>
					<tr>
						<td><?php echo $dadosCargo['ds_nome_cargo']?></td>
						<td align="center"><a class="pointer editItem<?php echo $controler?>" data-id="<?php echo $dadosCargo[$chavePrimaria]?> "> <i class="fa fa-edit"></i></a>
						</td>
						<td align="center"><a class="deleteItem pointer" data-id="<?php	echo $dadosCargo[$chavePrimaria].'|'.$dadosCargo[$nomeItem]?>"> <i class="fa fa-trash"></i></a>
						</td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
		</div>
	</div>
</div>
      
<div class="modal fade" id="modalEdit<?php echo $controler?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_title">
					<h2>Alterar dados de Cargos</h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler.'/registrarDados'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Cargo</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="edit-nome" name="nome" class="form-control" placeholder="Nome do cargo" required >
								<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
								<input type="hidden" id="edit-id" name="id">
								<input type="hidden" name="action" value="update">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Turno de trabalho dependente de agenda?</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="dependeAgenda" id="edit-dependeAgenda" class="form-control" required>
									<option value='1'>Sim</option>
									<option value='0'>Não</option>
								</select>
								<?php echo form_error('dependeAgenda', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Possui registro no C R M*?</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="registro" id="edit-registro" class="form-control" required>
									<option value='1'>Sim</option>
									<option value='0'>Não</option>
								</select>
								<span class="explicar-campos"><small>* Conselho Regional de Medicina</small></span>
								<?php echo form_error('registro', '<div class="error">', '</div>'); ?>
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



<div class="modal fade" id="modalDeleteItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Excluir um Cargo</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Você deseja excluir:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/delete/')?>">
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