<?php
$chavePrimaria	= 'pk_id_usuario';
$nomeItem		= 'ds_nome_usuario';

?>

<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Gerenciamento de Usuários </h2>
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
				
			<a href="<?php echo base_url()."Usuarios/formUsuarios/usuarios" ?>" id="addItem" class="btn btn-primary">Adicionar usuário <i class="fa fa-plus"></i></a>
			
			<a href="<?php echo base_url()."Usuarios/formUsuarios/superusuario"?>" id="addItem" class="btn btn-primary">Adicionar Administrador <i class="fa fa-plus"></i></a>
				
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
								<th>Reiniciar Senha</th>
								<th>Excluir</th>
					</tr>
				</thead>
					<tbody>
						<?php
							foreach($dadosUsuarios as $dadosUsuario){?>
								<tr>
									<td><?php echo $dadosUsuario['ds_nome_profissional']?></td>
									<td><?php echo $dadosUsuario['ds_nome_usuario']?></td>
									<?php
										switch($dadosUsuario['ds_nivel']){
											case 1:
												$nivel = "Administrador";
												break;
											case 2:
												$nivel = "Atendimento";
												break;
											case 3:
												$nivel = "Médico";
												break;
									  }
									?>
								  <!--
									A forma como foi colocado os nomes dos níveis nessa tabela não é aconselhável por deixar o sistema dependente
									do desenvolvedor caso precise acrescentar um novo nível. O correto seria criar o CRUD para os níveis mas no caso
									da clínica médica os níveis apresentados são suficientes e estão no detalhamento de caso de uso.
									-->
									<td><?php echo $nivel?></td>  
									<td><?php echo $dadosUsuario['ds_nome_cargo']?></td>

									<td align="center">
										<?php
											if($dadosUsuario['ds_nivel'] > 1){
										?>
										<a class="pointer editItemUsuarios" data-id="<?php	echo $dadosUsuario['pk_id_usuario']?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php
											}
										?>
									</td>
									<td align="center">
										<?php
											if($dadosUsuario['ds_nivel'] > 1){
										?>
										<a class="pointer recuperaItem" data-id="<?php	echo $dadosUsuario['pk_id_usuario'].'|'.$dadosUsuario['ds_nome_usuario']?>">
											<i class="fas fa-undo-alt"></i>
										</a>
										<?php
											}
										?>
									</td>
									<td align="center"><a class="pointer deleteItem" data-id="<?php	echo $dadosUsuario['pk_id_usuario'].'|'.$dadosUsuario['ds_nome_usuario']?>"> <i class="fa fa-trash"></i></a>
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
		<div class="modal fade" id="modalEditUsuarios" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="x_title">
						<h2>Alterar dados de Usuários<small></small></h2>
						<div class="clearfix"></div>
					</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().'Usuarios/registrarDados'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Usuário</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="edit-nomeUsuario" name="nome" class="form-control" placeholder="Nome Completo" required readonly >
								<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
								<input type="hidden" id="edit-id" name="id">
								<input type="hidden" name="action" value="update">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Profissional</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="edit-nomeProfissional" name="nomeProfissional" class="form-control" required readonly >
								<input type="hidden" id="edit-idProfissional" name="idProfissional">
								<?php echo form_error('nomeProfissional', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">nível</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="nivel" id="edit-nivel" class="form-control">
								<option value="2" selected>Atendimento</option>
								<option value="3" >Médico</option>
							</select>
							<?php echo form_error('nivel', '<div class="error">', '</div>'); ?>
							</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Salvar</button>
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

<div class="modal fade" id="modalRecuperaItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Reiniciar Senha de Usuário</h5>
      		</div>
      		<div class="modal-body">
        		<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Você deseja reiniciar senha do usuário:</p>
		  		<form method="POST" action="<?php echo base_url('Usuarios/reiniciarSenha/')?>">
					<input id="recuperarChavePrimaria"type="hidden" name="chavePrimaria" />
					<label class="font25 black " id="recuperarNomeItem"></label>
					<div class="modal-footer">
		        		<button type="button" class="btn btn-danger" data-dismiss="modal"><strong>Cancelar</strong></button>
						<button type="submit" class="btn btn-success botao-refresh"><strong>Reiniciar</strong></button>
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
        		<h5 class="modal-title font25 red bold ta-center">Excluir um Usuário</h5>
      		</div>
      		<div class="modal-body">
        		<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Você deseja excluir:</p>
		  		<form method="POST" action="<?php echo base_url('Usuarios/delete/')?>">
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