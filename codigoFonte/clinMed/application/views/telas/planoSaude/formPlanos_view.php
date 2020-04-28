<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "PlanosSaude";
    $refer =  base_url()."PlanosSaude/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			
			<div class="x_title row">
				<div><h2>Cadastrar Planos de Saúde</h2></div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."PlanosSaude/registrarDados"?>" >
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-12 col-xs-12">Nome do Plano</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
							<input type="text" name="nome" id="input-nome" class="form-control" value="<?php echo set_value('nome'); ?>"/>
							<?php echo form_error('nome', '<div class="error">', '</div>'); ?>
							<input type="hidden" name="action" value="create"/>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-12 col-xs-12">Número na ANS</label>
						<div class="col-md-2 col-sm-12 col-xs-12">
							<input type="text" name="numeroAns" id="input-numeroAns" class="form-control" value="<?php echo set_value('numeroAns'); ?>"/>
							<?php echo form_error('numeroAns', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-12 col-xs-12">Telefone</label>
						<div class="col-md-2 col-sm-12 col-xs-12">
							<input type="text" name="telefone" id="input-telefone" class="form-control telefones" value="<?php echo set_value('telefone'); ?>"/>
							<?php echo form_error('telefone', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
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