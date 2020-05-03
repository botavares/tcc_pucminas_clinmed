<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$controler = "Recepcao";
	$chavePrimaria = "pk_id_consulta";
	$anoAnterior = $ano - 1;
	$anoPosterior = $ano + 1;
	$refer =  base_url()."Recepcao/medicosDisponiveis/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2><small>Agendar Consulta</small> <?php echo "médico ".$dados[0]["ds_nome_profissional"]?></h2>
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
                    <div class="calendario col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table border="0">
        				<?php
							foreach($arrayMes as $num => $mes){
						?>
								<tbody id="<?php echo 'mes_'.$num?>" class="mes">
										<tr class="mes_ano">
											
											<td colspan="1" class="chanfrado-esquerda"><a href="<?php echo base_url()."Recepcao/formAgendarConsultas/".$medico."/".$anoAnterior?>" id="ano-anterior">&laquo;</a></td>
											
											<td colspan="5"><?php echo $ano?></td>
											<td colspan="1" class="chanfrado-direita"><a href="<?php echo base_url()."Recepcao/formAgendarConsultas/".$medico."/".$anoPosterior?>" id="ano-posterior">&raquo;</a></td>
										</tr>
									
									
										<tr class="mes_title">
											<td colspan="1" class="chanfrado-esquerda"><a href="#" id="volta">&laquo;</a></td>
											<td colspan="5"><?php echo $mes?></td>
											<td colspan="1" class="chanfrado-direita"><a href="#" id="vai">&raquo;</a></td>
										</tr>
									
										<tr class="dias_title">
										<?php
											foreach($diasSemana as $i => $day){
												if($day == "Dom"){?>
													<td><span class="numvermelho"><?php echo $day?></span></td>
										<?php	}else{?>
													<td><span style="color:#000"><?php echo $day?></span></td>
										<?php
												}
											}
										?>
										</tr>
									
										<tr>
										<?php
											$y = 0;
											foreach($arrayRetorno[$num] as $numero => $dia){
												$y++;
												if($numero == 1){
													$qtd = array_search($dia, $daysWeek);
													for($i=1; $i<=$qtd; $i++){
										?>
														<td></td>
										<?php
														$y+=1;
													}
												}
												$month = num($num);
												$dayNow = num($numero);
												$date = $ano.'-'.$month.'-'.$dayNow;
					
												//insere classe 'atual' no dia corrente
												if($date == date("Y-m-d")){
													$classeDia = "atual";
												}else{
													$classeDia = "dias";
												}
												
												if($date < date("Y-m-d")){?>
													<td ><?php echo $numero?></td>
										<?php
												}else{
													if(count($agendaConsulta) > 0){//se tiver algum evento no dia
														if(in_array($date, array_keys($agendaConsulta))){
															$evento = $agendaConsulta[$date];
															if($evento["status"]== 0){ // dia lotado?>
																<td class="dialotado"><a class="diaConsultas" data-id="<?php echo $evento['pk_id_profissional'].'|'.$date?>" title="<?php echo $evento["ds_data"]?>"><?php echo $numero?></a></td>
										<?php				
															}else{
										?>
																<td class="<?php echo $classeDia?>"><a class="diaConsultas" href="#"  data-id="<?php echo $evento['pk_id_profissional'].'|'.$date?>" title="<?php echo $evento["ds_data"]?>"><?php echo $numero?></a></td>
										<?php				}		
														}else{
															if($dia == "Sun" || $dia == "Sat"){
										?>
																<td class="<?php echo 'dia_'.$numero.' '.' numvermelho'?>"><?php echo $numero?></td>
										<?php				}else{?>
																<td class="<?php echo 'dia_'.$numero.' '.$classeDia ?>"><a class="diaConsultas" href="#"  data-id="<?php echo $dados[0]['pk_id_profissional'].'|'.$date?>"><?php echo $numero?></a></td>
										<?php				}
														}
                									}else{
														if($dia =="Sun" || $dia == "Sat"){
										?>
															<td class="<?php echo 'dia_'.$numero.' '.'numvermelho'?>"><?php echo $numero?></td>
										<?php			}else{?>
															<td class="<?php echo 'dia_'.$numero.' '.$classeDia ?>"><a class="diaConsultas" href="#"  data-id="<?php echo $dados[0]['pk_id_profissional'].'|'.$date?>"><?php echo $numero?></a></td>
										<?php 
														}
                									}
												}
                								if($y == 7){
                    								$y=0;?>
                    								</tr><tr>
                		<?php 					}
											}?>
													</tr>
							</tbody>
						<?php }?>
        				</table>
                    </div>
			
					<div class="legendas col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="mt-15">
							<li class="green bold">Verde: dia atual.</li>
							<li class="red bold">Vermelho: Todos horários preenchidos.</li>
						</ul>
					<?php
						$naoAtende 		= "FALSE";
						$diasNaoAtende	= "";
						foreach($diasAtendimento as $diaAtendimento){
							if($diaAtendimento["ds_turno_atendimento"] == 0){
								$naoAtende = "TRUE";
								switch($diaAtendimento["ds_dia_semana"]){
									case 1:
										$diaSemAtendimento = "Segunda-feira";
										break;
									case 2:
										$diaSemAtendimento = "Terça-feira";
										break;
									case 3:
										$diaSemAtendimento = "Quarta-feira";
										break;
									case 4:
										$diaSemAtendimento = "Quinta-feira";
										break;
									case 5:
										$diaSemAtendimento = "Sexta-feira";
										break;
								}
								if($diasNaoAtende==""){
									$diasNaoAtende = $diaSemAtendimento;
								}else{
									$diasNaoAtende = $diasNaoAtende.', '.$diaSemAtendimento;
								}
							}
						}
					?>
					<?php 
						if($naoAtende == "TRUE"){
					?>
						<h3 class="">Dias da semana em que esse médico não atende:</h3>
						<span class="font16 red"><?php echo $diasNaoAtende?></span>
					<?php } ?>
						<hr>
					</div>
				
				<table id="datatable-fixed-header" class="table table-striped table-bordered nowrap">
						<thead>
							<tr>
								<?php
								
								for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
							?>
							  <th><?php echo $titulosTabela[$i]?></th>
								  
							<?php 
								}
							?>
								<th>Confirmar Consulta</th>
								<th>Cancelar Consulta</th>
								
							</tr>
						</thead>
						<tbody>
							
								<?php foreach($consultas as $consulta){
										$diaConsulta = date('d/m/Y', strtotime($consulta['ds_data']));
										$horaConsulta = date('H:i', strtotime($consulta['ds_hora']));
										if($consulta['ds_status']!=3){
								?>
							
											<tr>
												<td><?php echo $consulta['ds_nome_cliente']?></td>
												<td align="center"><?php echo $diaConsulta?></td>
												<td align="center"><?php echo $horaConsulta?></td>
												<td align="center"><?php echo $consulta['ds_telefone']?></td>

												<?php 
													if($consulta['ds_status']==2){
												?>
												<td align="center"><a class="green pointer" data-id="<?php	echo '1'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> CONFIRMADO </a>
												</td>
												<?php
													}else{
												?>
												<td align="center"><a class="servicoConsulta pointer" data-id="<?php	echo '1'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> <i class="fa fa-check"></i></a>
												</td>
												<?php
													}
												?>

												<td align="center"><a class="servicoConsulta pointer" data-id="<?php	echo '2'.'|'.$consulta['pk_id_agendaconsulta'].'|'.$consulta['ds_nome_cliente'].'|'.$diaConsulta.'|'.$horaConsulta?>"> <i class="far fa-times-circle red"></i></a>
												</td>
											</tr>
								<?php 	}
									}
								?>
						</tbody>
					</table>
					<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
				</div>
        	</div> 
		</div>
    </div>
</div>

	
<div class="modal fade" id="modalHorariosAtendimento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Horários Disponíveis</h5>
        		
      		</div>
			<div class="modal-body">
				<div class="horarios">

				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="modalConfirmarConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Confirmar agendamento de consulta</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30"><i class="font35 amarelo fas fa-question-circle"></i>  Confirmar a Consulta de:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/confirmarConsulta/false')?>">
					<input class ="input-id"type="hidden" name="chavePrimaria" />
					<label class="label-nome font25 black"></label>
					<label class="label-dia font25 black"></label>
					<label class="label-hora font25 black"></label>
					<div class="modal-footer">
		        	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success botao-refresh">Confirmar</button>
					</div>	
				</form>
			</div>
    	</div>
  	</div>
</div>


<div class="modal fade" id="modalCancelarConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 red bold ta-center">Cancelar o agendamento da consulta</h5>
        		
      		</div>
      		<div class="modal-body">
        		<p class="font30 green"><i class="font35 amarelo fas fa-question-circle"></i>  Cancelar a consulta de:</p>
		  		<form method="POST" action="<?php echo base_url($controler.'/cancelarConsulta/false')?>">
					<input class ="input-id"type="hidden" name="chavePrimaria" />
					<label class="label-nome font25 black"></label>
					<label class="label-dia font25 black"></label>
					<label class="label-hora font25 black"></label>
					<div class="modal-footer">
		        	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success botao-refresh">Confirmar</button>
					</div>	
				</form>
			</div>
    	</div>
  	</div>
</div>






<div class="modal fade" id="modalAgendarConsulta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
        		<h5 class="modal-title font25 bold ta-center">Dados para o agendamento</h5>
        		
      		</div>
			<div class="modal-body">
				<div class="x_title">
					<form class="form-horizontal form-label-left" method="POST" action="<?php echo base_url().'Recepcao/agendarConsulta'?>">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Nome Cliente</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-cliente" name="cliente" class="form-control" value="<?php echo set_value('cliente'); ?>" placeholder="Nome Cliente" required>
								<?php echo form_error('cliente', '<div class="error">', '</div>'); ?>
								<input type="hidden" id="input-idMedico" name="idMedico">
								<input type="hidden" id="input-diaConsulta" name="diaConsulta">
								<input type="hidden" id="input-horaConsulta" name="horaConsulta">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Telefone</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" id="input-telefone" name="telefone" class="form-control telefones"value="<?php echo set_value('telefone'); ?>"  required >
								<?php echo form_error('telefone', '<div class="error">', '</div>'); ?>
							</div>
						</div>
								
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Tipo de atendimento</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="tipoAtendimento" id="tipoAtendimento" class="form-control" required>
									<option value="1"<?php echo set_select('tipoAtendimento',1); ?>>Consulta</option>
									<option value="2"<?php echo set_select('tipoAtendimento',2); ?>>Retorno</option>
								</select>
								<?php echo form_error('tipoAtendimento', '<div class="error">', '</div>'); ?>
							</div>
						</div>
						
						<div id="boxCpfRetorno">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12">CPF</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" id="cpfRetorno" name="cpf" class="form-control cpf"value="<?php echo set_value('cpf'); ?>" >
									<?php echo form_error('cpf', '<div class="error">', '</div>'); ?>
									<input type="hidden" name="idClienteRetorno" id="idClienteRetorno">
									<input type="hidden" name="idConsultaRetorno" id="idConsultaRetorno">
								</div>
							</div>
						</div>
								
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Plano:</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name ="planoSaude" id="edit-planoSaude" class="form-control" required>
									<option></option>
									<?php foreach($planos as $plano){?>

									<option value="<?php echo $plano["pk_id_plano"]?>"<?php echo set_select('planoSaude', $plano["pk_id_plano"]);?> ><?php echo $plano["ds_nome_plano"]?></option>
											<?php } ?>
								</select>
								<?php echo form_error('planoSaude', '<div class="error">', '</div>'); ?>
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
				<div class="horarios">

				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL QUE VERIFICA SE O CPF DESCRITO NO AGENDAMENTO DO RETORNO CONSTA NO REGISTRO DE CLIENTES DA CLÍNICA-->
<div class="modal fade" id="modalNaoVincular" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
				<h5 class="modal-title font20 bold red">Não Encontrado!</h5>
      		</div>
      		<div class="modal-body">
				<p id="modal-aviso" class="font20"></p>
        		<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Voltar</button>
				</div>	
			</div>
		</div>
	</div>
</div>