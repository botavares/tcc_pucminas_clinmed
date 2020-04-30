<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Consultas";
	$encoding = mb_internal_encoding();
?>
<div class="right_col" id="area-consulta" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Consulta do paciente <?php echo mb_strtoupper($nomeCliente,$encoding).', '.mb_strtoupper($idade." anos",$encoding)?> </h2>
				
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
						<div id="mensagem-erro" class="mensagem alert alert-danger alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemerror')?>
						</div>
					</div>
			<?php endif;?>
			
			
			<div>
				<?php $nomeTipoAtendimento = $tipoAtendimento == 1 ? "CONSULTA" : "RETORNO";?>
				<label class="font18">REGISTRO: </label>
				<label class="red font18 ml-5"><?php echo $idConsulta.' - '.$nomeTipoAtendimento ?></label>
				<label class="green ml-5 ta-right">
					<?php
						echo $primeiraConsulta == FALSE ? "<a class='btn btn-primary btn-sm' href='".base_url()."Consultas/historicoPaciente/".$idCliente."/".$idMedico."' target='_blank' ><i class='fas fa-notes-medical fa-2x'></i> PRONTUÁRIO</a>":"<a></a>";
					?>
				</label>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEncerraConsulta">
  					FINALIZAR CONSULTA
				</button>
			</div>
			
			<nav class="navbar mb-20 col-md-12 col-sm-12 col-xs-12">
				
			</nav>
			
			
				
			<form id="formregistrarAnamneseConsulta" class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().$controler."/registrarAnamneseConsulta"?>" >
				<input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">
				<input type="hidden" name="idMedico" value="<?php echo $idMedico ?>">
				<input type="hidden" name="idConsulta" value="<?php echo $idConsulta ?>">
				<input type="hidden" name="tipoAtendimento" value="<?php echo $tipoAtendimento ?>">
				<div>
					<h2 class="font20 green">Queixa do paciente</h2>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Queixa Principal</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<?php $consultaRecuperada == "" ? $queixa = "": $queixa = $consultaRecuperada["ds_queixa"] ?>
						<textarea class="resizable_textarea form-control" name="queixa" placeholder="Principal queixa que o paciente descreve"><?php echo set_value('queixa', $queixa)?></textarea>
					</div>
					<?php echo form_error('queixa', '<div class="error">', '</div>'); ?>
				</div>
				
						
				<div class="ln_solid"></div>
				
				<div>
					<h2 class="font20 green">Sinais vitais e medidas</h2>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Temperatura(C°)</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php $consultaRecuperada == "" ? $temperatura = "": $temperatura = $consultaRecuperada["ds_temperatura"] ?>
							<input type="text" class="form-control" name="temperatura" id="temperatura" value="<?php echo set_value('temperatura',$temperatura)?>">
						</div>
						<?php echo form_error('temperatura', '<div class="error">', '</div>'); ?>
					</div>
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Pressão Sanguínea</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php $consultaRecuperada == "" ? $pressao = "": $pressao = $consultaRecuperada["ds_pressaosanguinea"] ?>
							<input type="text" class="form-control pressao" name="pressaoSanguinea" id="pressaoSanguinea" value="<?php echo set_value('pressaoSanguinea',$pressao)?>">
						</div>
						<?php echo form_error('pressaoSanguinea', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Batimento Cardiaco (bpm)</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php $consultaRecuperada == "" ? $batimento = "": $batimento = $consultaRecuperada["ds_batimento"] ?>
							<input type="text" class="form-control" name="batimento" id="batimento" value="<?php echo set_value('batimento',$batimento)?>">
						</div>
						<?php echo form_error('batimento', '<div class="error">', '</div>'); ?>
					</div>
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Peso (kg)</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<?php $consultaRecuperada == "" ? $peso = "": $peso = $consultaRecuperada["ds_peso"] ?>
							<input type="text" class="form-control" name="peso" id="peso" value="<?php echo set_value('peso',$peso)?>">
						</div>
						<?php echo form_error('peso', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="ln_solid"></div>
				
				
				
				
					<div class="row container fundo-turqueza chanfrado pd-5">
						
						<div class="mb-15 ta-right col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<a href='#'  class="botao fundo-branco ta-center bold" id = 'input-expedeExames' data-id = "<?php echo $idConsulta."|".$tipoAtendimento ?>"> <i class="fas fa-microscope fa-2x"></i></i> ABRIR PEDIDO EXAMES</a>
						</div>
				
						<div class="mb-15 ta-right col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<a href='#' class="botao fundo-branco ta-center bold" id='input-prescreveMedicamentos' data-id ="<?php echo $idConsulta?>"><i class="fas fa-pills fa-2x"></i> PRESCREVER MEDICAMENTO</a>
						</div>
				
				
				
						<?php if ($examesDaConsulta != NULL){?>
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-15">
							
							<label class="ta-center col-md-12 col-sm-12 col-xs-12 font18 green">Exames pedidos</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<table class="tabela-consulta table table-striped">
									<thead>
										<tr>
											<th>Nome do Exame</th>
											<?php 
												if($tipoAtendimento == 2){?>
													<th class="bold red">Incluir Resultados</th>
											<?php } ?>
											<th>Excluir</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										foreach($examesDaConsulta as $valExpedidos){
											if(!empty($valExpedidos["ds_resultado_exame"])){
												$check = "<i class='blue fa fa-check'></i> ";
											}else{
												$check = "";
											}
									?>
										<tr>
											<td align="left" class="font12"><?php echo $check.$valExpedidos["ds_nome_exame"]?></td>
												<?php 
												if($tipoAtendimento == 2){?>
													<td align="center"><a class="pointer" id="insereResultadoExame" data-id="<?php echo $valExpedidos["pk_id_exameconsulta"]?>"> <i class="green fa fa-pencil"></i></a></td>
												<?php }?>

											<td align="center"><a href="<?php echo base_url()."Exames/excluirExame/".$valExpedidos["fk_id_exame"]."/".$idConsulta."/".$tipoAtendimento."/".$idMedico ?>"> <i class="red fa fa-trash"></i></a></td>
										</tr>
									<?php 
										}
									?>
									</tbody>
								</table>
								<div class="col-md-12 col-sm-12 col-xs-12">
								<?php
									if($examesRecebidos != "" && $examesRecebidos[0]["ds_numero_consulta"] == $idConsulta){
								?>
								
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<a href="<?php echo base_url()."Exames/imprimirExames/".$idConsulta."-".$idCliente."-".$idMedico ?>" class="btn btn-success col-md-12 col-sm-12 col-xs-12" target="_blank"><i class="fa fa-print"></i> Pedido de Exames</a>
									</div>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<a href="<?php echo $examesRecebidos[0]["ds_caminho_arquivo"]?>" class="btn btn-success col-md-12 col-sm-12 col-xs-12" target="_blank"><i class="fa fa-print"></i> Exame Laboratorial</a>
									</div>
								<?php
									}else{
								?>	
									<div class="col-md-12 col-sm-12 col-xs-12">
										<a href="<?php echo base_url()."Exames/imprimirExames/".$idConsulta."-".$idCliente."-".$idMedico ?>" class="btn btn-success col-md-12 col-sm-12 col-xs-12" target="_blank"><i class="fa fa-print"></i> Pedido de Exames</a>
									</div>
								<?php 
									}
								?>
								</div>
							</div>
						</div>
						<?php } ?>
						<?php if ($medicamentosDaConsulta != NULL){?>	
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12  mt-15">
							
							<label class="ta-center col-md-12 col-sm-12 col-xs-12 font18 green">Prescrição</label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<table class="tabela-consulta table table-striped">
									<thead>
											<tr>
												<th width="">Medicamento</th>
												<th width="">Apresentação</th>
												<?php 
												if($tipoAtendimento == 2){?>
													<th class="bold red">Orientação</th>
											<?php } ?>
												<th width="">Excluir</th>
											</tr>
										</thead>
									<tbody>
										<?php 
											foreach($medicamentosDaConsulta as $valMedicamento){
										?>
										<tr>
											<td align="left" class="font12"><?php echo $valMedicamento["ds_nome_generico"].' ('.$valMedicamento["ds_nome_medicamento"].') '?></td>
											<td align="center" class="font12"><?php echo $valMedicamento["ds_apresentacao"]?></td>
											<?php 
												if($tipoAtendimento == 2){?>
													<td align="center"><a class="pointer" id="insereOrientacao" data-id="<?php echo $valMedicamento["pk_id_receita_consulta"]?>"> <i class="green fa fa-pencil"></i></a></td>
												<?php }?>
											

											<td align="center"><a href="<?php echo base_url()."Receitas/excluirReceita/".$valMedicamento["fk_id_medicamento"]."/".$idConsulta."/".$tipoAtendimento."/".$idMedico  ?>"> <i class="red fa fa-trash"></i></a></td>
										</tr>
										<?php 
											}	
										?>
									</tbody>
								</table>
								
								<a href="<?php echo base_url()."Receitas/imprimirReceita/".$idConsulta."-".$idCliente."-".$idMedico ?>" class="btn btn-success col-md-12 col-sm-12 col-xs-12"  target="_blank"><i class="fa fa-print"></i> Imprimir Receitas</a>
								
								
								
							</div>
						</div>
						<?php
							 }
						?>
					</div>
				
				<div>
					<h2 class="font20 green">Histórico Familiar</h2>
				</div>	
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Diabetes na família?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $diabetes = 0 : $diabetes = $anamneseRecuperada["ds_diabetes"] ?>
						<?php if($diabetes == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="diabetes" id="diabetesNao" 
									   value="0" <?php echo  set_radio('diabetes', '0', TRUE); ?> checked/>
								<label for="diabetesNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="diabetes" id="diabetesSim" value="1" <?php echo  set_radio('diabetes', '1'); ?> />
								<label for="diabetesSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{ ?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="diabetes" id="diabetesNao" 
									   value="0" <?php echo  set_radio('diabetes', '0'); ?>/>
								<label for="diabetesNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="diabetes" id="diabetesSim" value="1" <?php echo  set_radio('diabetes', '1', TRUE); ?> checked />
								<label for="diabetesSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('diabetes', '<div class="error">', '</div>'); ?>
					</div>
				
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Antecedentes oncológicos?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $oncologico = 0 : $oncologico = $anamneseRecuperada["ds_oncologico"] ?>
						<?php if($oncologico == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="oncologico" id="oncologicoNao" value="0" <?php echo  set_radio('oncologico', '0', TRUE); ?> checked/>
								<label for="oncologicoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="oncologico" id="oncologicoSim" value="1" <?php echo  set_radio('oncologico', '1'); ?> />
								<label for="oncologicoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="oncologico" id="oncologicoNao" value="0" <?php echo  set_radio('oncologico', '0'); ?> />
								<label for="oncologicoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="oncologico" id="oncologicoSim" value="1" <?php echo  set_radio('oncologico', '1', TRUE); ?> checked/>
								<label for="oncologicoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('oncologico', '<div class="error">', '</div>'); ?>
					</div>
				</div>
			
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">"Pressão Alta"?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $pressaoAlta = 0 : $pressaoAlta = $anamneseRecuperada["ds_pressaoAlta"] ?>
						<?php if($pressaoAlta == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoAlta" id="pressaoAltaNao" value="0" <?php echo  set_radio('pressaoAlta', '0', TRUE); ?> checked/>
								<label for="pressaoAltaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoAlta" id="pressaoAltaSim" value="1" <?php echo  set_radio('pressaoAlta', '1'); ?> />
								<label for="pressaoAltaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoAlta" id="pressaoAltaNao" value="0" <?php echo  set_radio('pressaoAlta', '0'); ?> />
								<label for="pressaoAltaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoAlta" id="pressaoAltaSim" value="1" <?php echo  set_radio('pressaoAlta', '1',TRUE); ?>checked />
								<label for="pressaoAltaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('pressaoAlta', '<div class="error">', '</div>'); ?>
					</div>
					<label class="control-label col-md-3 col-sm-3 col-xs-12">"Pressão" Baixa?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $pressaoBaixa = 0 : $pressaoBaixa = $anamneseRecuperada["ds_pressaoBaixa"] ?>
						<?php if($pressaoBaixa == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoBaixa" id="pressaoBaixaNao" value="0" <?php echo  set_radio('pressaoBaixa', '0', TRUE); ?> checked/>
								<label for="pressaoBaixaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoBaixa" id="pressaoBaixaSim" value="1" <?php echo  set_radio('pressaoBaixa', '1'); ?> />
								<label for="pressaoBaixaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoBaixa" id="pressaoBaixaNao" value="0" <?php echo  set_radio('pressaoBaixa', '0'); ?> />
								<label for="pressaoBaixaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="pressaoBaixa" id="pressaoBaixaSim" value="1" <?php echo  set_radio('pressaoBaixa', '1', TRUE); ?> checked/>
								<label for="pressaoBaixaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
							<?php echo form_error('pressaoBaixa', '<div class="error">', '</div>'); ?>
					</div>
				</div>

				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Antecedentes cardíacos?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $cardiaco = 0 : $cardiaco = $anamneseRecuperada["ds_cardiaco"] ?>
						<?php if($cardiaco == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="cardiaco" id="cardiacoNao" value="0" <?php echo  set_radio('cardiaco', '0', TRUE); ?>  checked/>
									<label for="cardiacoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="cardiaco" id="cardiacoSim" value="1" <?php echo  set_radio('cardiaco', '1'); ?> />
								<label for="cardiacoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="cardiaco" id="cardiacoNao" value="0" <?php echo  set_radio('cardiaco', '0'); ?>  />
								<label for="cardiacoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="cardiaco" id="cardiacoSim" value="1" <?php echo  set_radio('cardiaco', '1', TRUE); ?>checked />
								<label for="cardiacoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('cardiaco', '<div class="error">', '</div>'); ?>
					</div>
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Outros antecedentes?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $outrosAntecedentes = 0 : $outrosAntecedentes = $anamneseRecuperada["ds_outrosAntecedentes"] ?>
						<?php if($outrosAntecedentes == 0){ ?>	
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="radio" class="flat antecedentesFamiliares" name="outrosAntecedentes" id="outrosAntecedentesNao" value="0" <?php echo  set_radio('outrosAntecedentes', '0', TRUE); ?>checked/>
								<label for="outrosAntecedentesNao" class="control-label mr-10">Não</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="radio" class="flat antecedentesFamiliares" name="outrosAntecedentes" id="outrosAntecedentesSim" value="1" <?php echo  set_radio('outrosAntecedentes', '1'); ?> />
							<label for="outrosAntecedentesSim"class="control-label mr-10">Sim</label>
						</div>
						<?php }else{?>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="radio" class="flat antecedentesFamiliares" name="outrosAntecedentes" id="outrosAntecedentesNao" value="0" <?php echo  set_radio('outrosAntecedentes', '0'); ?>/>
							<label for="outrosAntecedentesNao" class="control-label mr-10">Não</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="radio" class="flat antecedentesFamiliares" name="outrosAntecedentes" id="outrosAntecedentesSim" value="1" <?php echo  set_radio('outrosAntecedentes', '1', TRUE); ?>checked />
							<label for="outrosAntecedentesSim"class="control-label mr-10">Sim</label>
						</div>
						<?php } ?>
						<?php echo form_error('outrosAntecedentes', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="boxAntecedentesFamiliares">
					<div class="form-group mb-10">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Outros antecedentes<br>familiares</label>
							<div class="col-md-9 col-sm-9 col-xs-12">

								<?php $anamneseRecuperada == "" ? $descreveOutrosAntecedentes = "": $descreveOutrosAntecedentes = $anamneseRecuperada["ds_descreveOutrosAntecedentes"] ?>

								<textarea class="resizable_textarea form-control" name="descreveOutrosAntecedentes" id="descreveOutrosAntecedentes" placeholder="Descrever outros antecedentes familiares"><?php echo set_value('descreveOutrosAntecedentes', $descreveOutrosAntecedentes)?></textarea>
							</div>
							<?php echo form_error('descreveOutrosAntecedentes', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div>
					<h2 class="font20 green">Histórico Patológico</h2>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Faz uso de medicamentos?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $usoMedicamentos = 0 : $usoMedicamentos = $anamneseRecuperada["ds_usoMedicamentos"] ?>
						<?php if($usoMedicamentos == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat usoMedicamento" name="usoMedicamentos" id="usoMedicamentosNao" value="0" <?php echo  set_radio('usoMedicamentos', '0', TRUE); ?> checked/>
									<label for="usoMedicamentosNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat usoMedicamento" name="usoMedicamentos" id="usoMedicamentosSim" value="1" <?php echo  set_radio('usoMedicamentos', '1'); ?> />
								<label for="usoMedicamentosSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat usoMedicamento" name="usoMedicamentos" id="usoMedicamentosNao" value="0" <?php echo  set_radio('usoMedicamentos', '0'); ?> checked/>
									<label for="usoMedicamentosNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat usoMedicamento" name="usoMedicamentos" id="usoMedicamentosSim" value="1" <?php echo  set_radio('usoMedicamentos', '1', TRUE); ?> checked/>
								<label for="usoMedicamentosSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('usoMedicamentos', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="boxUsoMedicamentos">
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Qual(is) medicamento(s)?</label>
						<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
							<div class="col-md-12 col-sm-12 col-xs-12">
							
								<?php $anamneseRecuperada == "" ? $descreveMedicamento = "": $descreveMedicamento = $anamneseRecuperada["ds_descreveMedicamento"] ?>

								<textarea class="resizable_textarea form-control" name="descreveMedicamento" id="descreveMedicamento" placeholder="Descrever medicamentos"><?php echo set_value('descreveMedicamento',$descreveMedicamento)?></textarea>
							</div>
							<?php echo form_error('descreveMedicamento', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Alergia a algum medicamento?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $alergiaMedicamentos = 0 : $alergiaMedicamentos = $anamneseRecuperada["ds_alergiaMedicamento"] ?>
						<?php if($alergiaMedicamentos == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alergiaMedicamentos" name="alergiaMedicamento" id="alergiaMedicamentoNao" value="0" <?php echo  set_radio('alergiaMedicamento', '0', TRUE); ?> checked/>
									<label for="alergiaMedicamentoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alergiaMedicamentos" name="alergiaMedicamento" id="alergiaMedicamentoSim" value="1" <?php echo  set_radio('alergiaMedicamento', '1'); ?> />
								<label for="alergiaMedicamentoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alergiaMedicamentos" name="alergiaMedicamento" id="alergiaMedicamentoNao" value="0" <?php echo  set_radio('alergiaMedicamento', '0'); ?> />
								<label for="alergiaMedicamentoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alergiaMedicamentos" name="alergiaMedicamento" id="alergiaMedicamentoSim" value="1" <?php echo  set_radio('alergiaMedicamento', '1', TRUE); ?> checked/>
								<label for="alergiaMedicamentoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>

						<?php echo form_error('alergiaMedicamento', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				
				<div class="boxAlergiaMedicamentos"	>
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Qual(is) medicamento(s)?</label>
						<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<?php $anamneseRecuperada == "" ? $descreveMedicamentoAlergia = "": $descreveMedicamentoAlergia = $anamneseRecuperada["ds_descreveMedicamentoAlergia"] ?>

								<textarea class="resizable_textarea form-control" name="descreveMedicamentoAlergia" id="descreveMedicamentoAlergia" placeholder="Descrever quais medicamentos o paciente é alérgico"><?php echo set_value('descreveMedicamentoAlergia',$descreveMedicamentoAlergia)?></textarea>
								</div>
							<?php echo form_error('descreveMedicamentoAlergia', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				
				
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Já fez algum procedimento cirurgico?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $fezCirurgia = 0 : $fezCirurgia = $anamneseRecuperada["ds_fezCirurgia"] ?>
						<?php if($fezCirurgia == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat fezCirurgias" name="fezCirurgia" id="fezCirurgiaNao" value="0" <?php echo  set_radio('fezCirurgia', '0', TRUE); ?> checked/>
									<label for="fezCirurgiaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat fezCirurgias" name="fezCirurgia" id="fezCirurgiaSim" value="1" <?php echo  set_radio('fezCirurgia', '1'); ?> />
								<label for="fezCirurgiaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="radio" class="flat fezCirurgias" name="fezCirurgia" id="fezCirurgiaNao" value="0" <?php echo  	set_radio('fezCirurgia', '0'); ?>/>
								<label for="fezCirurgiaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat fezCirurgias" name="fezCirurgia" id="fezCirurgiaSim" value="1" <?php echo  set_radio('fezCirurgia', '1', TRUE); ?> checked/>
								<label for="fezCirurgiaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>

						<?php echo form_error('fezCirurgia', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="boxCirurgias">
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Qual(is) procedimento(s)?</label>
						<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<?php $anamneseRecuperada == "" ? $descreveCirurgia = "": $descreveCirurgia = $anamneseRecuperada["ds_descreveCirurgia"] ?>

								<textarea class="resizable_textarea form-control" name="descreveCirurgia" id="descreveCirurgia" placeholder="Descrever o procedimento cirurgico feito pelo paciente"><?php echo set_value('descreveCirurgia',$descreveCirurgia)?></textarea>
							</div>
							<?php echo form_error('descreveCirurgia', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<?php if($sexo > 0){?>
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Ciclo menstrual regular?</label>
						<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
							<?php $anamneseRecuperada == "" ? $cicloMenstrual = 0 : $cicloMenstrual = $anamneseRecuperada["ds_cicloMenstrual"] ?>
							<?php if($cicloMenstrual == 0){ ?>	
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="cicloMenstrual" id="cicloMenstrualNao" value="0" <?php echo  set_radio('cicloMenstrual', '0', TRUE); ?> checked/>
										<label for="cicloMenstrual" class="control-label mr-10">Não</label>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="cicloMenstrual" id="cicloMenstrualSim" value="1" <?php echo  set_radio('cicloMenstrual', '1'); ?> />
									<label for="cicloMenstrualSim"class="control-label mr-10">Sim</label>
								</div>
							<?php }else{?>
								<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="cicloMenstrual" id="cicloMenstrualNao" value="0" <?php echo  set_radio('cicloMenstrual', '0'); ?> />
									<label for="cicloMenstrual" class="control-label mr-10">Não</label>
							</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="cicloMenstrual" id="cicloMenstrualSim" value="1" <?php echo  set_radio('cicloMenstrual', '1', TRUE); ?> checked/>
									<label for="cicloMenstrualSim"class="control-label mr-10">Sim</label>
								</div>
							<?php } ?>

							<?php echo form_error('cicloMenstrual', '<div class="error">', '</div>'); ?>
						</div>
				
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Faz uso de anticoncepcional?</label>
						<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
							<?php $anamneseRecuperada == "" ? $anticoncepcional = 0 : $anticoncepcional = $anamneseRecuperada["ds_anticoncepcional"] ?>
							<?php if($anticoncepcional == 0){ ?>	
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="anticoncepcional" id="anticoncepcionalNao" value="0" <?php echo  set_radio('anticoncepcional', '0', TRUE); ?> checked/>
									<label for="anticoncepcionalNao" class="control-label mr-10">Não</label>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="anticoncepcional" id="anticoncepcionalSim" value="1" <?php echo  set_radio('anticoncepcional', '1'); ?> />
									<label for="anticoncepcionalSim"class="control-label mr-10">Sim</label>
								</div>
							<?php }else{?>
								<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="anticoncepcional" id="anticoncepcionalNao" value="0" <?php echo  set_radio('anticoncepcional', '0'); ?> />
								<label for="anticoncepcionalNao" class="control-label mr-10">Não</label>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<input type="radio" class="flat" name="anticoncepcional" id="anticoncepcionalSim" value="1" <?php echo  set_radio('anticoncepcional', '1', TRUE); ?> checked/>
									<label for="anticoncepcionalSim"class="control-label mr-10">Sim</label>
								</div>
							<?php } ?>
							<?php echo form_error('anticoncepcional', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				<?php }?>
				<div class="ln_solid"></div>
				
				<div>
					<h2 class="font20 green">Histórico Social</h2>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">É fumante?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $fumante = 0 : $fumante = $anamneseRecuperada["ds_fumante"] ?>
						<?php if($fumante == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="fumante" id="fumanteNao" value="0" <?php echo  set_radio('fumante', '0', TRUE); ?> checked/>
								<label for="fumanteNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="fumante" id="fumanteSim" value="1" <?php echo  set_radio('fumante', '1'); ?> />
								<label for="fumanteSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="fumante" id="fumanteNao" value="0" <?php echo  set_radio('fumante', '0'); ?>/>
								<label for="fumanteNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="fumante" id="fumanteSim" value="1" <?php echo  set_radio('fumante', '1', TRUE); ?> checked />
								<label for="fumanteSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('fumante', '<div class="error">', '</div>'); ?>
					</div>
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Faz uso de bebida alcoólica?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $bebidaAlcoolica = 0 : $bebidaAlcoolica = $anamneseRecuperada["ds_bebidaAlcoolica"] ?>
						<?php if($bebidaAlcoolica == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="bebidaAlcoolica" id="bebidaAlcoolicaNao" value="0" <?php echo  set_radio('bebidaAlcoolica', '0', TRUE); ?> checked/>
								<label for="bebidaAlcoolicaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="bebidaAlcoolica" id="bebidaAlcoolicaSim" value="1" <?php echo  set_radio('bebidaAlcoolica', '1'); ?> />
								<label for="bebidaAlcoolicaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="bebidaAlcoolica" id="bebidaAlcoolicaNao" value="0" <?php echo  set_radio('bebidaAlcoolica', '0'); ?>/>
								<label for="bebidaAlcoolicaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat" name="bebidaAlcoolica" id="bebidaAlcoolicaSim" value="1" <?php echo  set_radio('bebidaAlcoolica', '1', TRUE); ?> checked />
								<label for="bebidaAlcoolicaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('bebidaAlcoolica', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Faz atividades físicas frequentes?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $atividadeFisica = 0 : $atividadeFisica = $anamneseRecuperada["ds_atividadeFisica"] ?>
						<?php if($atividadeFisica == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat atividadesFisicas" name="atividadeFisica" id="atividadeFisicaNao" value="0" <?php echo  set_radio('atividadeFisica', '0', TRUE); ?> checked/>
									<label for="atividadeFisicaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat atividadesFisicas" name="atividadeFisica" id="atividadeFisicaSim" value="1" <?php echo  set_radio('atividadeFisica', '1'); ?> />
								<label for="atividadeFisicaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat atividadesFisicas" name="atividadeFisica" id="atividadeFisicaNao" value="0" <?php echo  set_radio('atividadeFisica', '0'); ?>/>
									<label for="atividadeFisicaNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat atividadesFisicas" name="atividadeFisica" id="atividadeFisicaSim" value="1" <?php echo  set_radio('atividadeFisica', '1', TRUE); ?>checked/>
								<label for="atividadeFisicaSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('atividadeFisica', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="boxAtividadesFisicas">
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Qual(is) atividade(s)?</label>
						<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<?php $anamneseRecuperada == "" ? $descreveAtividadeFisica = "": $descreveAtividadeFisica = $anamneseRecuperada["ds_descreveAtividadeFisica"] ?>

								<textarea class="resizable_textarea form-control" name="descreveAtividadeFisica" id="descreveAtividadeFisica" placeholder="Descrever atividade física frequente que o paciente pratica."><?php echo set_value('descreveAtividadeFisica', $descreveAtividadeFisica)?></textarea>
							</div>
							<?php echo form_error('descreveAtividadeFisica', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">É adepto a alguma restrição de alimento(Ex: Vegetariano,Vegano)?</label>
					<div class="col-md-3 col-sm-9 col-xs-12 mb-10">
						<?php $anamneseRecuperada == "" ? $restricaoAlimento = 0 : $restricaoAlimento = $anamneseRecuperada["ds_restricaoAlimento"] ?>
						<?php if($restricaoAlimento == 0){ ?>	
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alimentosEvitados" name="restricaoAlimento" id="restricaoAlimentoNao" value="0" <?php echo  set_radio('restricaoAlimento', '0', TRUE); ?> checked/>
									<label for="restricaoAlimentoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alimentosEvitados" name="restricaoAlimento" id="restricaoAlimentoSim" value="1" <?php echo  set_radio('restricaoAlimento', '1'); ?> />
								<label for="restricaoAlimentoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php }else{?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alimentosEvitados" name="restricaoAlimento" id="restricaoAlimentoNao" value="0" <?php echo  set_radio('restricaoAlimento', '0'); ?>/>
									<label for="restricaoAlimentoNao" class="control-label mr-10">Não</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="radio" class="flat alimentosEvitados" name="restricaoAlimento" id="restricaoAlimentoSim" value="1" <?php echo  set_radio('restricaoAlimento', '1', TRUE ); ?>checked />
								<label for="restricaoAlimentoSim"class="control-label mr-10">Sim</label>
							</div>
						<?php } ?>
						<?php echo form_error('restricaoAlimento', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="boxAlimentosEvitados">
					<div class="form-group mb-10">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Qual(is) alimentos não come?</label>
						<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<?php $anamneseRecuperada == "" ? $descreveRestricaoAlimento = "": $descreveRestricaoAlimento = $anamneseRecuperada["ds_descreveRestricaoAlimento"] ?>
								
								<textarea class="resizable_textarea form-control" name="descreveRestricaoAlimento" id="descreveRestricaoAlimento" placeholder="Descrever quais alimentos o paciente se restringe a comer."><?php echo set_value('descreveRestricaoAlimento',$descreveRestricaoAlimento)?></textarea>
							</div>
							<?php echo form_error('descreveRestricaoAlimento', '<div class="error">', '</div>'); ?>
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				
				
				<div>
					<h2 class="font20 green">Parecer Médico</h2>
				</div>

				<div class="form-group mb-10">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Parecer médico:</label>
					<div class="col-md-9 col-sm-9 col-xs-12 mb-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php $consultaRecuperada == "" ? $parecerMedico = "": $parecerMedico = $consultaRecuperada["ds_parecermedico"] ?>
							<textarea class="resizable_textarea form-control" name="parecerMedico" id="parecerMedico" placeholder="Observações sobre o paciente ."><?php echo set_value('parecerMedico',$parecerMedico)?></textarea>
						</div>
						<?php echo form_error('parecerMedico', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- MODAL PARA PEDIR EXAMES MÉDICOS -->
<div class="modal fade" id="modalExpedirExames" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_title">
					<h2>Expedir Exames<small>Consulta: <?php echo $idConsulta?></small></h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().'Exames/registrarExames'?>">
					<input type="hidden" id="input-numeroconsulta" name="numeroConsulta" value = "<?php echo $idConsulta ?>">
					<input type="hidden" id="input-tipoAtendimento" name="tipoAtendimento" value = "<?php echo $tipoAtendimento ?>">
					<input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">
					<input type="hidden" name="idMedico" value="<?php echo $idMedico ?>">
					
					<input type="hidden" name="action" value="create">
					<h3 class="green">Escolha o(s) exame(s):</h3>
					<div class="overflowY">
						 <div class="table-responsive">
                      		<table class="table table-striped jambo_table bulk_action">
                        		<thead>
                         			<tr class="headings">
                            			<th>
                              				<input type="checkbox" id="check-all" class="flat">
                            			</th>
                            			<th class="column-title">Exame</th>
									</tr>
								</thead>
								
								<tbody>
									<?php
									foreach($examesMedicos as $exameMedico){?>
                          			<tr class="even pointer">
                            			<td class="a-center ">
                              				<input type="checkbox" id="input-exame<?php echo $exameMedico["pk_id_exame"]?>" name="idExame[]" class="flat form-control" value="<?php echo $exameMedico["pk_id_exame"]?>">
											<?php echo form_error('idExame', '<div class="error">', '</div>'); ?>
                            			</td>
										<td class="a-center ">
											<?php echo $exameMedico["ds_nome_exame"]?>
										</td>
									</tr>
									<?php
						   			}
									?>
								</tbody>
							</table>
						</div>
			
					</div>
					<div>
					
					
					</div>
					  
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- MODAL PARA PEDIR PRESECREVER RECEITAS -->
<div class="modal fade" id="modalPrescreverReceitas" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_title">
					<h2>Prescrição<small>Consulta: <?php echo $idConsulta?></small></h2>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().'Receitas/registrarReceita'?>">
					<input type="hidden" id="numeroconsulta" name="numeroConsulta" value = "<?php echo $idConsulta ?>">
					<input type="hidden" id="tipoAtendimento" name="tipoAtendimento" value = "<?php echo $tipoAtendimento ?>">
					<input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">
					<input type="hidden" name="idMedico" value="<?php echo $idMedico ?>">
					
					<input type="hidden" name="action" value="create">
					<h3 class="green">Escolha o(s) medicamentos(s):</h3>
					<div class="overflowY">
						 <div class="table-responsive">
                      		<table class="table table-striped jambo_table bulk_action">
                        		<thead>
                         			<tr class="headings">
                            			<th>
                              				<input type="checkbox" id="check-all" class="flat">
                            			</th>
                            			<th class="column-title">Genérico</th>
										<th class="column-title">Comercial</th>
										<th class="column-title">Apresentação</th>
										
									</tr>
								</thead>
								
								<tbody>
									<?php
									foreach($medicamentos as $medicamento){?>
                          			<tr class="even pointer">
                            			<td class="a-center ">
                              				<input type="checkbox" id="input-exame<?php echo $medicamento["pk_id_medicamento"]?>" name="idMedicamento[]" class="flat form-control" value="<?php echo $medicamento["pk_id_medicamento"]?>">
											<?php echo form_error('idMedicamento', '<div class="error">', '</div>'); ?>
                            			</td>
										<td class="a-center ">
											<?php echo $medicamento["ds_nome_generico"]?>
										</td>
										<td class="a-center ">
											<?php echo $medicamento["ds_nome_medicamento"]?>
										</td>
										<td class="a-center ">
											<?php echo $medicamento["ds_apresentacao"]?>
										</td>
										
									</tr>
									<?php
						   			}
									?>
								</tbody>
							</table>
						</div>
			
					</div>
					<div>
					
					
					</div>
					  
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- MODAL PARA INSERIR RESULTADOS DE EXAMES -->
<div class="modal fade" id="modalResultadoExames" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="font25 red ta-c">Registrar resultado do exame:</h5>
			</div>
			<div class="modal-body">
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="font16 blue">Número da consulta: </label>  <span class="ta-left font16 black bold" id="exameNrConsulta"></span>
					</div>
					<div class="form-group">
						<label class="font16 blue">Nome do Exame: </label>  <span class="ta-left font16 black bold" id="nomeExame"></span>
					</div>
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().'Exames/registrarResultadoExame'?>"><br>
					<div class="form-group mb-10">
						<label class="col-md-12 col-xs-12 font16 blue">Resultado desse exame:</label>
						<div class="col-md-12 col-sm-12 col-xs-12 mb-10">
							<input type="hidden" name="idPedidoExame" id="idPedidoExame">
							<input type="hidden" name="numeroConsulta" class="numeroConsulta">
							<input type="hidden" name="idMedico" id="medicoExame">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<textarea class="resizable_textarea form-control" name="resultadoExame" id="resultadoExame" placeholder="Inserir resultado do exame." required><?php echo set_value('resultadoExame')?></textarea>
							</div>
							<?php echo form_error('resultadoExame', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>
<!-- MODAL PARA INSERIR ORIENTAÇÕES NA RECEITA MEDICA-->
<div class="modal fade" id="modalOrientacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="font25 red ta-c">Registrar Orientação de uso:</h5>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="font16 blue">Número da consulta: </label><span class="ta-left font16 bold" id="nrConsulta"></span>
					</div>
					<div class="form-group">
						<label class="font16 blue">Nome do Medicamento: </label><span class="ta-left font16 bold" id="nomeMedicamento"></span>
					</div>
					
				</div>
				<form class="form-horizontal" method="POST" action="<?php echo base_url().'Receitas/registrarOrientacaoReceita'?>"><br>
					<div class="form-group mb-10">
						<label class="col-md-12 col-xs-12 font16 blue">Orientação para uso do medicamento:</label>
						<div class="col-md-12 col-sm-12 col-xs-12 mb-10">
							<input type="hidden" name="idReceita" id="idReceita">
							<input type="hidden" name="numeroConsulta" id="numConsulta">
							<input type="hidden" name="idMedico" id="medicoReceita">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<textarea class="resizable_textarea form-control" name="orientacaoReceita" id="orientacaoReceita" placeholder="ex.intervalos de uso, evitar algo que possa atrapalhar o efeito, etc.." required><?php echo set_value('orientacaoReceita')?></textarea>
							</div>
							<?php echo form_error('orientacaoReceita', '<div class="error">', '</div>'); ?>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-1">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button type="reset" class="btn btn-primary">Limpar</button>
							<button type="submit" class="btn btn-success">Gravar</button>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>

<!-- MODAL PARA VERIFICAR SE IRÁ ENCERRAR A CONSULTA-->
<div class="modal fade" id="modalEncerraConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Finalizar Consulta</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30 blue"><i class="font35 amarelo fas fa-question-circle"></i>  Deseja finalizar a Consulta?</p>
		  		<form method="POST" action="<?php echo base_url('Consultas/finalizarConsulta/')?>">
					<input id="numeroConsulta"type="hidden" name="numeroConsulta" value="<?php echo $idConsulta?>"/>
					<label class="font25 black " id="nomeItem"></label>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success btn-lg botao-refresh"><strong>SIM</strong></button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"><strong>NÃO</strong></button>
						<a class="btn btn-warning bold" href="<?php echo base_url()."Consultas/formAtendimentoConsultas"?>">Tela Inicial</a>
						
						
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