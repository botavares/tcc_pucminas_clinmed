<!-- page content -->
		
        <div class="right_col" role="main">
			<div class="x_panel">
				<div class="x_content">
					<div class="x_title">
						
						<?php if($this->session->userdata('ds_nivel')==1 ){?>
						<h2>ADMINISTRADOR</h2>
						<?php }?>
						
						<?php if($this->session->userdata('ds_nivel')==2 ){?>
						<h2>RECEPÇÃO</h2>
						<?php }?>
						
						<?php if($this->session->userdata('ds_nivel')==3 ){?>
						<h2>MÉDICOS</h2>
						<?php }?>
						
						<div class="clearfix"></div>
					</div>
					<?php if($this->session->userdata('ds_nivel')==1 ){?>
					<div class="ferramentas col-lg-12 col-md-12 col-sm-12 col-xs-12" id="ferramentas-administrador">

						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Cargos"?>">
								<img src="<?php echo base_url()."external/img/enfermeira.png"?>"alt="Gerenciar Cargos" title="Gerenciar os cargos da clínica">
								<p>Cargos</p>
							</a>
						</div>
						<div class="icones col-md-3 col-xs-6">
							<a href="<?php echo base_url()."Profissionais"?>">
								<img src="<?php echo base_url()."external/img/profissionais.png"?>" alt="Gerenciar profissionais" title="Cadastrar os profissionais da clínica">
								<p>Profissionais</p>
							</a>

						</div>
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Usuarios"?>">
								<img src="<?php echo base_url()."external/img/usuario.png"?>" alt="Gerenciar usuários" title="Cadastrar quem terá acesso ao sistema">
								<p>Usuários</p>
							</a>

						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."HorariosAtendimento"?>">
								<img src="<?php echo base_url()."external/img/horarios.png"?>" alt="horário de atendimento de cada médico" title="horário de atendimento de cada médico">
								<p>Horários de atendimento<br>dos médicos</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."DiasAtendimento"?>">
								<img src="<?php echo base_url()."external/img/diasatendimento.png"?>" alt="Dias da semana em que o médico atende" title="Dias da semana em que o médico atende">
								<p>Dias de atendimento<br>dos médicos</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."PlanosSaude"?>">
								<img src="<?php echo base_url()."external/img/planosaude.png"?>" alt="Gerenciar Planos de saúde" title="Gerenciar Planos de saúde">
								<p>Planos de saúde</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."PlanosSaude/planosEMedicos"?>">
								<img src="<?php echo base_url()."external/img/medicoPlanos.png"?>" alt="Vincular planos de saúde aos médicos" title="Vincular planos de saúde aos médicos">
								<p>Médicos <br>&<br> Planos de Saúde </p>
							</a>
						</div>
						
					</div>
					<?php } ?>
					<?php if($this->session->userdata('ds_nivel')==2 ){?>
					
					<div class="ferramentas" id="ferramentas-recepcionista">
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Recepcao/medicosDisponiveis"?>">
								<img src="<?php echo base_url()."external/img/agenda_consulta.png"?>" alt="Agendar consultas" title="agendamento de consultas">
								<p>Agendar Consultas</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Recepcao/formConfirmarConsulta"?>">
								<img src="<?php echo base_url()."external/img/confirmar.png"?>" alt="Confirmar consultas" title="Confirmar o agendamento de consultas">
								<p>Confirmar Consultas</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Recepcao"?>">
								<img src="<?php echo base_url()."external/img/atendimento.png"?>" alt="Recepção da Clínica" title="Atender os clientes da clínica presencialmente">
								<p>Recepção</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Clientes"?>">
								<img src="<?php echo base_url()."external/img/paciente.png"?>" alt="Gerenciar dados dos clientes da clínica" title="cadastrar dados pessoais dos clientes">
								<p>Clientes da Clínica</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Recepcao/formImprimirRecibo"?>">
								<img src="<?php echo base_url()."external/img/conta.png"?>" alt="imprimir recibos de consultas particulares" title="imprimir recibos de consultas particulares">
								<p>Imprimir recibos</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Receitas/formSegundaReceita"?>">
								<img src="<?php echo base_url()."external/img/relatorioenviar.png"?>" alt="imprimir segunda via de receitas" title="imprimir segunda via de receitas">
								<p>Segunda via de receitas</p>
							</a>
						</div>
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Exames/formRecebimentoExame"?>">
								<img src="<?php echo base_url()."external/img/receita4.png"?>" alt="Registrar recebimento de Exames" title="registrar recebimento de exames">
								<p>Recebimento<br> de Exames</p>
							</a>
						</div>
						
						

					</div>
					<?php } ?>
					
					
					
					
					<?php if($this->session->userdata('ds_nivel')== 3 ){?>
					<div class="ferramentas" id="ferramentas-medicos">
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Medicos/formAtendimentoConsultas"?>">
								<img src="<?php echo base_url()."external/img/iniciarconsulta.png"?>" alt="Iniciar Consultas aos pacientes agendados" title="Iniciar Consultas aos pacientes agendados">
								<p>Iniciar consultas</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Medicos/formPacienteHistorico"?>">
								<img src="<?php echo base_url()."external/img/historico.png"?>" alt="Acessar histórico dos pacientes" title="Acessar prontuário dos pacientes">
								<p>Prontuários dos<br> Pacientes</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Exames/formRecebimentoExame"?>">
								<img src="<?php echo base_url()."external/img/receita4.png"?>" alt="Registrar recebimento de Exames" title="registrar recebimento de exames">
								<p>Recebimento<br> de Exames</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Receitas/formSegundaReceita"?>">
								<img src="<?php echo base_url()."external/img/relatorioenviar.png"?>" alt="imprimir segunda via de receitas" title="imprimir segunda via de receitas">
								<p>Segunda via de receitas</p>
							</a>
						</div>
						
						<div class="icones col-md-3  col-xs-6">
							<a href="<?php echo base_url()."Medicamentos"?>">
								<img src="<?php echo base_url()."external/img/receitas.png"?>" alt="Gerenciar dados dos medicamentos" title="Gerenciar dados dos medicamentos">
								<p>Medicamentos</p>
							</a>
						</div>
						
					</div>
					<?php } ?>
				</div>
			</div>
        </div>
        <!-- /page content -->

<div class="modal fade" id="modalAnaliticoClinica" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
				<h5 class="modal-title font25 blue bold ta-center">Relatório Analítico por Período</h5>
      		</div>
      		<div class="modal-body">
        		<form method="POST" action="<?php echo base_url()."Relatorios/analiticoPeriodo"?>" target="_blank">
					<div class="form-group">
						<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Data Inicial</label>
						<input type="text" name="dataInicio" id="dataInicial" class="input-data form-control" required>
					</div>
					<div class="form-group">
						<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Data Final</label>
						<input type="text" name="dataFim" id="dataFinal" class="input-data form-control" required>
					</div>
					
					<label class="font20 green" id="nomeClienteCadastrado"></label>
					<div class="modal-footer">
		        		<button type="button" class="btn btn-warning" data-dismiss="modal">voltar</button>
						<button type="submit" id="btnsubmit" class="btnRelatorio btn btn-success">Imprimir</button>
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