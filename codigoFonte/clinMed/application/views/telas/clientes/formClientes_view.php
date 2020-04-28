<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Clientes";
	$refer =  base_url()."Clientes/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Cadastro de <?php echo $controler?></h2>
				<div class="clearfix"></div>
			</div>
				<form id="formAdicionarCliente" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler."/registrarDados"?>" >
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Cliente</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="nomeCliente" id="input-nomeCliente" class="form-control col-md-10" value="<?php echo set_value('nomeCliente')?>" required />
							<?php echo form_error('nomeCliente', '<div class="error">', '</div>'); ?>
							<input type="hidden" name="vinculo" value="<?php echo $vincularClienteAgendamento?>"/>
							<input type="hidden" name="action" value="create"/>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de Nascimento</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<input type="text" name="nascimento" id="input-nascimento" class="form-control col-md-10 input-data" value="<?php echo set_value('nascimento')?>" required />
							<?php echo form_error('nascimento', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<select name="sexo" id="input-sexo" class="form-control" required >
								<option value="" selected>Sexo</option>
								<option value="1" <?php echo set_select('sexo',"1"); ?> >Feminino</option>
								<option value="0" <?php echo set_select('sexo',"0"); ?> >Masculino</option>    
							</select>
							<?php echo form_error('sexo', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF do Cliente</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<input type="text" name="cpfCliente" id="input-cpfCliente" class="form-control col-md-10 cpf validarCPF" value="<?php echo set_value('cpfCliente')?>" required />
							<?php echo form_error('cpfCliente', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
                   
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Responsável Legal?</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio">
                                 <label>
                                     <input type="radio" value="1" <?php echo  set_radio('responsavel', '1'); ?>class="responsavel" id="input-responsavel1" name="responsavel">Sim
                                 </label>
                            </div>
                            <div class="radio">
                                <label>
                                   <input type="radio" value="0" <?php echo  set_radio('responsavel', '0', TRUE); ?>class="responsavel"  id="input-responsavel2" name="responsavel" >Não
                                </label>
                            </div>
                        </div>
                    </div>
					
                    <div class="boxResponsavel">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Responsável</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="nomeResponsavel" id="input-nomeResponsavel" class="form-control col-md-10" value="<?php echo set_value('nomeResponsavel')?>"/>
                                <?php echo form_error('nomeResponsavel', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF do Responsável</label>
                            <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
                                <input type="text" name="cpfResponsavel" id="input-cpfResponsavel" class="form-control col-md-10 cpf" value="<?php echo set_value('cpfResponsavel')?>"  />
                                <?php echo form_error('cpfResponsavel', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
						<label class="col-md-3 col-sm-3 col-xs-12 control-label">Possui plano de saúde?</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" <?php echo  set_radio('planoSaude', '1'); ?> class = "planoSaude" id="input-planoSaude1" name="planoSaude">Sim
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="0" <?php echo  set_radio('planoSaude', '0', TRUE); ?> class = "planoSaude"  id="input-planoSaude2" name="planoSaude">Não
                                </label>
                            </div>
							<?php echo form_error('planoSaude', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					
                    
                    <div class="boxPlanoSaude">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Plano de Saúde</label>
                           
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name ="nomePlano" id="input-nomePlano" class="form-control">
									<option value="1" checked>Particular</option>
									<?php foreach($planosSaude as $planoSaude){?>
									<option value="<?php echo $planoSaude["pk_id_plano"]?>" <?php echo set_select('nomePlano',$planoSaude["pk_id_plano"]); ?>><?php echo $planoSaude["ds_nome_plano"]?></option>
								<?php } ?>
								</select>
							</div>
							
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Número do Plano de Saúde</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="numeroPlano" id="input-numeroPlano" class="form-control col-md-10" value="<?php echo set_value('numeroPlano')?>"/>
                                <?php echo form_error('numeroPlano', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
					</div>                    
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CEP</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<input type="text" name="cep" id="input-cep" class="form-control col-md-10 cep" value="<?php echo set_value('cep')?>" required />
							<?php echo form_error('cep', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Rua</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="logradouro" id="input-logradouro" class="form-control col-md-10" value="<?php echo set_value('logradouro')?>" required />
							<?php echo form_error('logradouro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Número</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="numero" id="input-numero" class="form-control col-md-10" value="<?php echo set_value('numero')?>" required />
							<?php echo form_error('numero', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Complemento</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="complemento" id="input-complemento" class="form-control col-md-10" value="<?php echo set_value('complemento')?>"/>
							<?php echo form_error('complemento', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bairro</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="bairro" id="input-bairro" class="form-control col-md-10" value="<?php echo set_value('bairro')?>" required />
							<?php echo form_error('bairro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cidade</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="cidade" id="input-cidade" class="form-control col-md-10" value="<?php echo set_value('cidade')?>" required />
							<?php echo form_error('cidade', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tel. Fixo</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<input type="text" name="telfixo" id="input-telfixo" class="form-control col-md-10 telefones" value="<?php echo set_value('telfixo')?>"/>
							<?php echo form_error('telfixo', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tel. Celular</label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12">
							<input type="text" name="telcel" id="input-telcel" class="form-control col-md-10 telefones" value="<?php echo set_value('telcel')?>" required />
							<?php echo form_error('telcel', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="email" id="input-email" class="form-control col-md-10" value="<?php echo set_value('email')?>"/>
							<?php echo form_error('email', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
							<button class="btn btn-primary" type="reset">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
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