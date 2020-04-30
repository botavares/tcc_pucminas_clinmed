<?php
$controler		= "Profissionais";
$chavePrimaria	= 'pk_id_profissional';
$nomeItem		= 'ds_nome_profissional';
$assunto		= "Adicionar Profissional";
?>

<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Gerenciamento de Profissionais</h2>
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
						foreach($dadosProfissionais as $dadosProfissional){?>
				<tr>
					<td><?php echo $dadosProfissional['ds_nome_profissional']?></td>
					<td><?php echo $dadosProfissional['ds_nome_cargo']?></td>
					<td><?php echo $dadosProfissional['ds_telcel']?></td>
					<td align="center"><a class="pointer editItem<?php echo $controler?>" data-id="<?php echo $dadosProfissional[$chavePrimaria]?>"> <i class="fa fa-edit"></i></a>
					</td>
					<td align="center"><a class="pointer deleteItem" data-id="<?php	echo $dadosProfissional[$chavePrimaria].'|'.$dadosProfissional[$nomeItem]?>"> <i class="fa fa-trash"></i></a>
					</td>
				</tr>
					<?php } ?>
				</tbody>
			</table>
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
					<h2>Alterar dados de <?php echo $controler?><small></small></h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler.'/registrarDados'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Profissional</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-nome" name="nome" class="form-control" placeholder="Nome do profissional" required >
								<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
								<input type="hidden" id="input-id" name="id">
								<input type="hidden" name="action" value="update">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Cargo</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="selectCargo" id="input-cargo" class="form-control" required>
									<?php foreach($cargos as $cargo){?>
									<option value="<?php echo $cargo["pk_id_cargo"]?>"><?php echo $cargo["ds_nome_cargo"]?></option>
								<?php } ?>
								</select>
								<?php echo form_error('cargo', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Sexo</label>
                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12">
							<select name="sexo" id="input-sexo" class="form-control" required >
								<option value="" selected>Sexo </option>
								<option value="1" <?php echo set_select('sexo',"1"); ?> >Feminino</option>
								<option value="0" <?php echo set_select('sexo',"0"); ?> >Masculino</option>    
							</select>
							<?php echo form_error('sexo', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">CPF</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-cpf" name="cpf" class="form-control cpf validarCPF" placeholder="CPF" required >
								<?php echo form_error('cpf', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div id="grupoCrm" class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">CRM</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-crm" name="crm" class="crm form-control" placeholder="CRM" >
								<?php echo form_error('crm', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div id="grupoEspecialidade" class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Especialidade</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="especialidade" id="input-especialidade" class="form-control">
									<?php foreach($especialidades as $especialidade){?>
									<option value="<?php echo $especialidade["pk_id_especialidade"]?>"><?php echo $especialidade["ds_nome_especialidade"]?></option>
								<?php } ?>
								</select>
								<?php echo form_error('especialidade', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">CEP</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-cep" name="cep" class="form-control" placeholder="CEP" required >
								<?php echo form_error('cep', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Rua</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-logradouro" name="logradouro" class="form-control" placeholder="CEP" required >
								<?php echo form_error('logradouro', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Complemento</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-complemento" name="complemento" class="form-control" placeholder="complemento"  >
								<?php echo form_error('complemento', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Número</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-numero" name="numero" class="form-control" placeholder="Número da residência"  >
								<?php echo form_error('numero', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Bairro</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-bairro" name="bairro" class="form-control" placeholder="Bairro" required >
								<?php echo form_error('bairro', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Tel. Fixo</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-telfixo" name="telfixo" class="form-control telefones" placeholder="Telefone Fixo"  >
								<?php echo form_error('telfixo', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Tel. Celular</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-telcel" name="telcel" class="form-control telefones" placeholder="Telefone Celular" required >
								<?php echo form_error('telcel', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Email</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-email" name="email" class="form-control " placeholder="Email" required >
								<?php echo form_error('email', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Alterar</button>
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
        		<h5 class="modal-title font30 red bold ta-center">Excluir um Profissional</h5>
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
