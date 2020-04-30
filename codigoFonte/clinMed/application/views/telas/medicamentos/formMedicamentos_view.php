<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Medicamentos";
	$referer = base_url()."Medicamentos";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			
			<div class="x_title">
				<h2>Cadastrar <?php echo $controler?></small></h2>
				<div class="clearfix"></div>
			</div>
			<form id="formUsuario" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler."/create"?>" >
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nome Genérico</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="nomeGenerico" id="input-nomeGenerico" class="form-control col-md-10" required/>
						<?php echo form_error('nomeGenerico', '<div class="error">', '</div>'); ?>
						<input type="hidden" name="action" value="create"/>
					</div>
				</div>
				<div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Medicamento</label>
                    	<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="nomeMedicamento" id="input-nomeMedicamento" class="form-control col-md-10" required/>
							<?php echo form_error('nomeMedicamento', '<div class="error">', '</div>'); ?>
                        </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Especialidade principal</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name ="especialidade" id="input-especialidade" class="form-control" required>
							<option selected></option>
							<?php foreach($especialidades as $especialidade){?>
							<option value="<?php echo $especialidade["pk_id_especialidade"]?>"><?php echo $especialidade["ds_nome_especialidade"]?></option>
							<?php } ?>
						</select>
						<?php echo form_error('especialidade', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group">
                	<label class="control-label col-md-3 col-sm-3 col-xs-12">Apresentação</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="apresentacao" id="input-apresentacao" class="form-control col-md-10" required/>
							<?php echo form_error('apresentacao', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Posologia</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="resizable_textarea form-control" name = "posologia"  id="input-posologia" placeholder="Posologia do medicamento. Texto livre"></textarea>
						<?php echo form_error('posologia', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Restrições</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="resizable_textarea form-control" name = "restricoes"  id="input-restricoes" placeholder="Restrições do medicamento. Texto livre"></textarea>
							<?php echo form_error('restricoes', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Classe</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name ="classe" id="input-classe" class="form-control">
							<option selected></option>
							<?php foreach($classe as $keyClasses){?>
							<option value="<?php echo $keyClasses["pk_id_classe"]?>"><?php echo $keyClasses["ds_nome_classe"]?></option>
							<?php } ?>
						</select>
						<?php echo form_error('classe', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Fabricante</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name ="fabricante" id="input-fabricante" class="form-control">
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
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<a class="btn btn-warning" href="<?php echo $referer?>"> Voltar </a>
						<button class="btn btn-primary" type="reset">Limpar</button>
						<button type="submit" class="btn btn-success">Gravar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>