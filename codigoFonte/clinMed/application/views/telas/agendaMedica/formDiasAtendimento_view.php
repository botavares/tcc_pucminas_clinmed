<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "DiasAtendimento";
	$refer =  base_url()."DiasAtendimento/";

?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Cadastro Dias de Atendimento Médico</h2>
				<div class="clearfix"></div>
			</div>
				<form id="formCargo" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url()."DiasAtendimento/registrarDiasAtendimento"?>" >
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12">Nome do Médico</label>
                        <div class="col-md-8 col-sm-9 col-xs-12">
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
						<label class="control-label col-md-2 col-sm-3 col-xs-12">Segunda-Feira</label>
						<div class="col-md-10 col-sm-9 col-xs-12 mb-10">
							<div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-1" id="segunda-nao-atende" value="0" checked/>
									<label for="segunda-nao-atende" class="control-label mr-10">Não atende:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-1" id="segunda-dia-todo" value="1" />
									<label for="segunda-dia-todo"class="control-label mr-10">O dia Todo:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-1" id="segunda-manha" value="2" />
									<label for="" class="control-label mr-10">Manhã:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat ml-10" name="opt-1" id="segunda-tarde" value="3" />
									<label for="segunda-tarde" class="control-label mr-10">Tarde:</label>
								</div>
							</div>
							<?php echo form_error('opt-segunda', '<div class="error">', '</div>'); ?>
						</div>
						
						<label class="control-label col-md-2 col-sm-3 col-xs-12">Terça-Feira</label>
						<div class="col-md-10 col-sm-9 col-xs-12 mb-10">
							<div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-2" id="terca-nao-atende" value="0" checked/>
									<label for="terca-nao-atende" class="control-label mr-10">Não atende:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-2" id="terca-dia-todo" value="1" />
									<label for="terca-dia-todo"class="control-label mr-10">O dia Todo:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-2" id="terca-manha" value="2" />
									<label for="" class="control-label mr-10">Manhã:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat ml-10" name="opt-2" id="terca-tarde" value="3" />
									<label for="terca-tarde" class="control-label mr-10">Tarde:</label>
								</div>
							</div>
							<?php echo form_error('opt-terca', '<div class="error">', '</div>'); ?>
						</div>
						
						<label class="control-label col-md-2 col-sm-3 col-xs-12">Quarta-Feira</label>
						<div class="col-md-10 col-sm-9 col-xs-12 mb-10">
							<div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-3" id="quarta-nao-atende" value="0" checked/>
									<label for="quarta-nao-atende" class="control-label mr-10">Não atende:</label>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-3" id="quarta-dia-todo" value="1" />
									<label for="quarta-dia-todo"class="control-label mr-10">O dia Todo:</label>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-3" id="quarta-manha" value="2" />
									<label for="" class="control-label mr-10">Manhã:</label>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat ml-10" name="opt-3" id="quarta-tarde" value="3" />
									<label for="quarta-tarde" class="control-label mr-10">Tarde:</label>
								</div>
							</div>
							<?php echo form_error('opt-quarta', '<div class="error">', '</div>'); ?>
						</div>
						
						<label class="control-label col-md-2 col-sm-3 col-xs-12">Quinta-Feira</label>
						<div class="col-md-10 col-sm-9 col-xs-12 mb-10">
							<div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-4" id="quinta-nao-atende" value="0" checked/>
									<label for="quinta-nao-atende" class="control-label mr-10">Não atende:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-4" id="quinta-dia-todo" value="1" />
									<label for="quinta-dia-todo"class="control-label mr-10">O dia Todo:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-4" id="quinta-manha" value="2" />
									<label for="" class="control-label mr-10">Manhã:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat ml-10" name="opt-4" id="quinta-tarde" value="3" />
									<label for="quinta-tarde" class="control-label mr-10">Tarde:</label>
								</div>
							</div>
							<?php echo form_error('opt-quinta', '<div class="error">', '</div>'); ?>
						</div>
						
						<label class="control-label col-md-2 col-sm-3 col-xs-12">Sexta-Feira</label>
						<div class="col-md-10 col-sm-9 col-xs-12 mb-10">
							<div>
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-5" id="sexta-nao-atende" value="0" checked/>
									<label for="sexta-nao-atende" class="control-label mr-10">Não atende:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-5" id="sexta-dia-todo" value="1" />
									<label for="sexta-dia-todo"class="control-label mr-10">O dia Todo:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="opt-5" id="sexta-manha" value="2" />
									<label for="" class="control-label mr-10">Manhã:</label>
								</div>
								
								<div class="col-md-3 col-sm-6 col-xs-6">
									<input type="radio" class="flat ml-10" name="opt-5" id="sexta-tarde" value="3" />
									<label for="sexta-tarde" class="control-label mr-10">Tarde:</label>
								</div>
							</div>
							<?php echo form_error('opt-sexta', '<div class="error">', '</div>'); ?>
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