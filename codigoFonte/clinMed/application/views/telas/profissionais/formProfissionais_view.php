<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Profissionais";
	$refer =  base_url()."Profissionais/"
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			
				<div class="x_title">
					<h2>Cadastrar <?php echo $controler?></small></h2>
					<div class="clearfix"></div>
				</div>
			
				
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler."/registrarDados"?>" >
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Nome do Profissional</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
							<input type="text" name="nome" id="input-nome" class="form-control col-md-10" value="<?php echo set_value('nome'); ?>" required/>
							<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
							<input type="hidden" name="action" value="create"/>
                        </div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-12 col-xs-12">Cargo</label>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<select name ="selectCargo" id="input-cargo" class="form-control" required>
								<option value="" checked></option>
								<?php foreach($cargos as $cargo){?>
									<option value="<?php echo $cargo["pk_id_cargo"]?>" <?php echo set_select('selectCargo',$cargo["pk_id_cargo"]); ?>><?php echo $cargo["ds_nome_cargo"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('selectCargo', '<div class="error">', '</div>'); ?>
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
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">CPF</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="cpf" id="input-cpf" class="cpf validarCPF form-control col-md-10" value="<?php echo set_value('cpf'); ?>" required/>
							<?php echo form_error('cpf', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div id="grupoCrm" class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">CRM*</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="crm" id="input-crm" class="form-control crm col-md-10" value="<?php echo set_value('crm'); ?>"/>
							<?php echo form_error('crm', '<div class="error">', '</div>'); ?>
							<span class="explicar-campos"><small>* Conselho Regional de Medicina - somente para médicos</small></span>
                        </div>
					</div>
					
					<div id="grupoEspecialidade" class="form-group">
						<label for="input-especialidade" class="control-label col-md-3 col-sm-12 col-xs-12">Especialidade</label>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<select name ="especialidade" id="input-especialidade" class="form-control">
								<option value = "" checked></option>
								<?php foreach($especialidades as $especialidade){?>
									<option value="<?php echo $especialidade["pk_id_especialidade"]?>" <?php echo set_select('especialidade',$especialidade["pk_id_especialidade"]); ?>><?php echo $especialidade["ds_nome_especialidade"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('especialidade', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">CEP</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="cep" id="input-cep" class="form-control col-md-10 cep" value="<?php echo set_value('cep'); ?>"/>
							<?php echo form_error('cep', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Rua</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
							<input type="text" name="logradouro" id="input-logradouro" class="form-control col-md-10" value="<?php echo set_value('logradouro'); ?>"/>
							<?php echo form_error('logradouro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Número</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="numero" id="input-numero" class="form-control col-md-10" value="<?php echo set_value('numero'); ?>"/>
							<?php echo form_error('numero', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Complemento</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="complemento" id="input-complemento" class="form-control col-md-10" value="<?php echo set_value('complemento'); ?>"/>
							<?php echo form_error('complemento', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Bairro</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
							<input type="text" name="bairro" id="input-bairro" class="form-control col-md-10" value="<?php echo set_value('bairro'); ?>"/>
							<?php echo form_error('bairro', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Tel. Fixo</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="telfixo" id="input-telfixo" class="form-control col-md-10 telefones" value="<?php echo set_value('telfixo'); ?>"/>
							<?php echo form_error('telfixo', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Tel. Celular</label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
							<input type="text" name="telcel" id="input-telcel" class="form-control col-md-10 telefones" value="<?php echo set_value('telcel'); ?>"/>
							<?php echo form_error('telcel', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Email</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
							<input type="text" name="email" id="input-email" class="form-control col-md-10" value="<?php echo set_value('email'); ?>"/>
							<?php echo form_error('email', '<div class="error">', '</div>'); ?>
                        </div>
					</div>
					
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
							<button class="btn btn-primary" type="reset">Limpar</button>
							<button type="submit" class="btn btn-success"><strong>Gravar</strong></button>
							
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