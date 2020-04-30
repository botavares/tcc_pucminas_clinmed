<?php
$controler = "Clientes";
$chavePrimaria = 'pk_id_cliente';
$nomeItem = 'ds_nome_cliente';
$assunto = "Adicionar ".$controler;
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
			<a href="<?php echo base_url().$controler."/form".$controler?>" id="addItem" class="btn btn-primary col-md-2 col-xs-12 col-sm-12"><?php echo $assunto?> <i class="fa fa-plus"></i></a>
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
						<th><?php $status==1 ? $titulo = "Excluir": $titulo =  "Recuperar";echo $titulo;?></th>
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($dados as $keyDados){?>
					<tr>
						<td><?php echo $keyDados['ds_nome_cliente']?></td>
						<td><?php echo $keyDados['ds_telcel']?></td>


						<td align="center"><a class="editItem<?php echo $controler?> pointer" data-id="<?php echo $keyDados[$chavePrimaria]?>"> <i class="fa fa-edit"></i></a>
						</td>
						<?php 
							if($status == 1){?>
								<td align="center"><a class="deleteItem pointer" data-id="<?php	echo $keyDados[$chavePrimaria].'|'.$keyDados[$nomeItem]?>"> <i class="fa fa-trash"></i></a>
								</td>
						<?php }else{?>
								<td align="center"><a class="recuperaItem" data-id="<?php	echo $keyDados[$chavePrimaria].'|'.$keyDados[$nomeItem]?>"> <i class="fas fa-trash-restore-alt"></i></a>
								</td>
						<?php }?>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<?php $status == 1 ? $nomeStatus = "Inativos" : $nomeStatus = "Ativos";?>
			<a href="<?php echo base_url()."Clientes/index/".$nomeStatus?>" class="btn btn-success"><i class="fas fa-trash-restore-alt"></i> Clientes <?php echo $nomeStatus?></a>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
		</div>
	</div>
</div>
        <!-- /page content -->
		<!-- /modals-->
		<!-- /MODAL PARA EDIÇÃO DE ITENS-->
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
				<form class="form-horizontal form-label-left" id="formAlterarCliente" method="POST" action="<?php echo base_url().$controler.'/registrarDados'?>">
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Cliente</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="nomeCliente" id="input-nomeCliente" class="form-control col-md-10"/>
							<?php echo form_error('nomeCliente', '<div class="error">', '</div>'); ?>
							<input type="hidden" id="input-id" name="id" value="create"/>
							<input type="hidden" name="action" value="update"/>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Data de Nascimento</label>
                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12">
							<input type="text" name="nascimento" id="input-nascimento" class="form-control col-md-10 input-data" value="<?php echo set_value('nascimento')?>" required />
							<?php echo form_error('nascimento', '<div class="error">', '</div>'); ?>
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">CPF do Cliente</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="cpfCliente" id="input-cpfCliente" class="form-control col-md-10 cpf"/>
							<?php echo form_error('cpfCliente', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
                   
                    <div class="form-group row">
                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">Responsável Legal?</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio">
                                 <label>
                                     <input type="radio" value="1" class="responsavel" id="input-responsavel1" name="responsavel">Sim
                                 </label>
                            </div>
                            <div class="radio">
                                <label>
                                   <input type="radio" value="0" class="responsavel"  id="input-responsavel2" name="responsavel" checked = "checked">Não
                                </label>
                            </div>
                        </div>
                    </div>
					<div class="boxResponsavel">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Nome do Responsável</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="nomeResponsavel" id="input-nomeResponsavel" class="form-control col-md-10"/>
                                <?php echo form_error('nomeResponsavel', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">CPF do Responsável</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="cpfResponsavel" id="input-cpfResponsavel" class="form-control col-md-10 cpf validarCPF"/>
                                <?php echo form_error('cpfResponsavel', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
						<label class="col-md-4 col-sm-4 col-xs-12 control-label">Possui plano de saúde?</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" class = "planoSaude" id="input-planoSaude1" name="planoSaude">Sim
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="0" class = "planoSaude"  id="input-planoSaude2" name="planoSaude" checked="checked">Não
                                </label>
                            </div>
						</div>
					</div>
					<div class="boxPlanoSaude">
                        <div class="form-group">
                          <label class="control-label col-md-4 col-sm-12 col-xs-12">Nome do Plano</label>
							<div class="col-md-8 col-sm-12 col-xs-12">
								<select name ="nomePlano" id="input-nomePlano" class="form-control">
									<?php foreach($planosSaude as $planoSaude){?>
									<option value="<?php echo $planoSaude["pk_id_plano"]?>" <?php echo set_select('nomePlano',$planoSaude["pk_id_plano"]); ?>><?php echo $planoSaude["ds_nome_plano"]?></option>
								<?php } ?>
								</select>
							</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Número do Plano de Saúde</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="numeroPlano" id="input-numeroPlano" class="form-control col-md-10"/>
                                <?php echo form_error('numeroPlano', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
					</div>                    
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">CEP</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="cep" id="input-cep" class="form-control col-md-10 cep"/>
							<?php echo form_error('cep', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Rua</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="logradouro" id="input-logradouro" class="form-control col-md-10"/>
							<?php echo form_error('logradouro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Número</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="numero" id="input-numero" class="form-control col-md-10"/>
							<?php echo form_error('numero', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Complemento</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="complemento" id="input-complemento" class="form-control col-md-10"/>
							<?php echo form_error('complemento', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Bairro</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="bairro" id="input-bairro" class="form-control col-md-10"/>
							<?php echo form_error('bairro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Cidade</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="cidade" id="input-cidade" class="form-control col-md-10"/>
							<?php echo form_error('cidade', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Tel. Fixo</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="telfixo" id="input-telfixo" class="form-control col-md-10 telefones"/>
							<?php echo form_error('telfixo', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Tel. Celular</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="telcel" id="input-telcel" class="form-control col-md-10 telefones"/>
							<?php echo form_error('telcel', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Email</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="email" id="input-email" class="form-control col-md-10"/>
							<?php echo form_error('email', '<div class="error">', '</div>'); ?>
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


<div class="modal fade" id="modalDeleteItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Excluir um cliente:</h5>
        		
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
<div class="modal fade" id="modalRecuperaItens" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Reativação de Cadastro:</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Você deseja reativar:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/reativar/')?>">
					<input id="chaveReativar"type="hidden" name="chaveReativar" />
					<label class="font25 black " id="nomeReativar"></label>
					<div class="modal-footer">
		        		<button type="button" class="btn btn-danger" data-dismiss="modal"><strong>cancelar</strong></button>
						<button type="submit" class="btn btn-warning botao-refresh"><strong>REATIVAR</strong></button>
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