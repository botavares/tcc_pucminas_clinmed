<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Usuarios";
	$refer =  base_url()."Usuarios/"
?>
<div class="right_col" role="main">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Cadastrar <?php echo $controler?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<form id="formUsuario" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."Usuarios/registrarDados"?>" >
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Nome do Usuario</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
							<input type="text" name="nome" id="input-nome" class="form-control col-md-10" required/>
							<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
							<input type="hidden" name="action" value="create"/>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-12 col-xs-12">Nome do Profissional</label>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<select name ="idProfissional" id="input-idProfissional" class="form-control">
								<option selected></option>
								<?php foreach($nomesProfissionais as $nomeProfissional){?>
									<option value="<?php echo $nomeProfissional["pk_id_profissional"]?>"><?php echo $nomeProfissional["ds_nome_profissional"]?></option>
								<?php } ?>
							</select>
							<?php echo form_error('idProfissional', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-12 col-xs-12">Nível</label>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<select name ="nivel" id="input-nivel" class="form-control">
								<?php 
									if($tipoUsuario = "superusuario"){
								?>
								<option value="1">Administrador</option>
								<?php
									}else{
								?>
								<option value="2" selected>Atendimento</option>
								<option value="3" >Médico</option>
								<?php
									}
								?>
							</select>
							<?php echo form_error('nivel', '<div class="error">', '</div>'); ?>
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
</div>