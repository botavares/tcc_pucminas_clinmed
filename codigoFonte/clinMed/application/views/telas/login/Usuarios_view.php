<?php
$controler = "Usuarios";
?>
<!-- page content -->
        <div class="right_col" role="main">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
                    <h2>Relação de <small>USUÁRIOS</small></h2>
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				</div>
			</div>
			
<!-- mensagens de aviso-->
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
			</p>
<button id="addItem" class="btn btn-primary">Adicionar Usuários <i class="fa fa-plus"></i></button>
<!--/Mensagens de aviso-->			
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
							<td><?php echo $keyDados['ds_nome_usuario']?></td>
							<td><?php echo $keyDados['ds_nick_usuario']?></td>
							<td><?php echo $keyDados['ds_nome_escola']?></td>
								
						  	<td align="center"><a class="editItemUsuarios" data-id="<?php	echo $keyDados['pk_id_usuario']?>"> <i class="fa fa-edit"></i></a>
							</td>
							<td align="center"><a class="deleteItem" data-id="<?php	echo $keyDados['pk_id_usuario'].'|'.$keyDados['ds_nome_usuario']?>"> <i class="fa fa-trash"></i></a>
							</td>
						</tr>
						  <?php } ?>
                     
                      </tbody>
                    </table>
			
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
						<h2>Dados dos Usuários<small></small></h2>
						<div class="clearfix"></div>
					</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler.'/create'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome completo</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="edit-nome" name="nome" class="form-control" placeholder="Nome Completo" required >
								<input type="hidden" id="edit-id" name="id">
								<input type="hidden" id="edit-area" name="area" value="CAD">
								<input type="hidden" id="edit-deus" name="deus" value="0">
								<input type="hidden" name="action" value="edit">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Usuário</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="edit-nick" name="nick" class="form-control" placeholder="usuário" required>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">email</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="email" id="edit-email" name="email"class="form-control" placeholder="Email" required >
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Escola</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="escola" id="edit-idEscola" class="form-control" required>
									<?php 
										foreach($unidades as $keyUnidades){
									?>
										<option value="<?php echo $keyUnidades['pk_id_escola'] ?>"><?php echo $keyUnidades['ds_nome_escola']?></option>
									<?php 
										}
									?>
									
								</select>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Tipo</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="nivel" id="edit-nivel" class="form-control">
									 <option value="1">Administrador</option>
									 <option value="2">Operador</option>
								</select>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Status</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="status" id="edit-status" class="form-control">
									 <option value="1" selected >Ativo</option>
									 <option value="2" >Inativo</option>
								</select>
							</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Sair</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Salvar</button>
						</div>
					</div>
				</form>
			  </div>
			</div>
		  </div>
		</div>


<!-- MODAL PARA ADIÇÃO DE ITENS-->
		<div class="modal fade" id="modalAddItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="x_title">
						<h2>Dados dos Usuários<small></small></h2>
						<div class="clearfix"></div>
					</div>
				<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler.'/create'?>">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome completo</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="add-nome" name="nome" class="form-control" placeholder="Nome Completo" required >
								
								<input type="hidden" id="add-area" name="area" value="CAD">
								<input type="hidden" id="add-deus" name="deus" value="0">
								<input type="hidden" name="action" value="create">
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Usuário</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="add-nick" name="nick" class="form-control" placeholder="usuário" required >
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">email</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="add-email" name="email"class="form-control" placeholder="Email" required >
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Escola</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="escola" id="add-idEscola" class="form-control" required>
									<option></option>
									<?php 
										foreach($unidades as $keyUnidades){
									?>
										<option value="<?php echo $keyUnidades['pk_id_escola'] ?>"><?php echo $keyUnidades['ds_nome_escola']?></option>
									<?php 
										}
									?>
									
								</select>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Tipo</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="nivel" id="add-nivel" class="form-control">
									 <option value="1">Administrador</option>
									 <option value="2" selected>Operador</option>
								</select>
							</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Status</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="status" id="add-status" class="form-control">
									 <option value="1" selected >Ativo</option>
									 <option value="2" >Inativo</option>
								</select>
							</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Sair</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Salvar</button>
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
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url($controler.'/delete/')?>">
          
	            <h5 class="modal-title" id="modalLabel">Realmente deseja excluir:</h5>
                	<input id="chavePrimaria"type="hidden" name="chavePrimaria" />
        			<label id="nomeItem"></label>
		<div class="modal-footer">
        
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	        <button type="submit" class="btn btn-danger botao-refresh">Excluir</button>
      </div>	
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalShowDuplo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
</div>
		<!-- /modals-->