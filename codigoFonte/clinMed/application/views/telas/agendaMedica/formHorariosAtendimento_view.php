<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "HorariosAtendimento";
	$refer =  base_url()."HorariosAtendimento/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Cadastrar <?php echo "horários de atendimento médico"?></small></h2>
				<div class="clearfix"></div>
			</div>
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."HorariosAtendimento/registrarHorariosAtendimento"?>" >
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Médico</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
							<select name ="selectMedico" id="input-medico" class="form-control">
								<?php foreach($dados as $keyDados){?>
									<option value="<?php echo $keyDados["pk_id_profissional"]?>"
										<?php echo set_select('selectMedico',$keyDados["pk_id_profissional"]); ?>>
										<?php echo $keyDados["ds_nome_profissional"]?>
									</option>
								<?php } ?>
							</select>
                            <input type="hidden" name="action" value="create"/>
							<?php echo form_error('selectMedico', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Atendimento Matutino</label>
						<div class="col-md-3 col-sm-9 col-xs-12">
							<div class="mb-10 ">
								<label for="entrada-matutino" class="control-label  green mr-10">Entrada:</label>
								<input type="text" class="horas form-control" name="entradaMatutino" id="entrada-matutino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('entradaMatutino'); ?>"/>
								<?php echo form_error('entradaMatutino', '<div class="error">', '</div>'); ?>
								
								<label for="saida-matutino" class="control-label red mr-10">Saída:</label>
								<input type="text" class="horas form-control" name="saidaMatutino" id="saida-matutino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('saidaMatutino'); ?>"/>
								<?php echo form_error('saidaMatutino', '<div class="error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Atendimento Vespertino</label>
						<div class="col-md-3 col-sm-9 col-xs-12">
							<div class="mb-10 ">
								<label for="entrada-vespertino" class="control-label  green mr-10">Entrada:</label>
								<input type="text" class="horas form-control" name="entradaVespertino" id="entrada-vespertino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('entradaVespertino'); ?>"/>
								<?php echo form_error('entradaVespertino', '<div class="error">', '</div>'); ?>
								
								<label for="saida-vespertino" class="control-label red mr-10">Saída:</label>
								<input type="text" class="horas form-control" name="saidaVespertino" id="saida-vespertino" pattern="([01]?[0-9]{1}|2[0-3]{1}):[0-5]{1}[0-9]{1}" value="<?php echo set_value('saidaVespertino'); ?>"/>
								<?php echo form_error('saidaVespertino', '<div class="error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Tempo Médio de Consulta</label>
						<div class="col-md-3 col-sm-9 col-xs-12">
							<input type="text" id="input-tmpConsulta" class="form-control" name="tmpConsulta" value="<?php echo set_value('tmpConsulta'); ?>"/>
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