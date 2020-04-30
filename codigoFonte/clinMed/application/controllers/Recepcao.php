<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcao extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('AgendaMedica_model', 'Agenda');
		$this->load->model('Profissionais_model', 'Profissionais');
		$this->load->model('Clientes_model', 'Clientes');
		$this->load->model('Consultas_model','Consultas');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
    }
	
	
	public function index(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$diaAtual		=	date('Y-m-d');
		$consultasHoje	=	$this->Consultas->listarAtendimentosDeHoje($diaAtual);
		
		$titulosTabela = array('Consulta','Cliente','Dia','Horário','Consulta/Retorno','Plano','Médico');
		
		$arrayView = array(
			"camada1"		=>	'telas',
			"camada2"		=>	'recepcao',
			"pagina"		=>	'atendimentoRecepcao',
			"usuario"		=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"		=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"	=>	$titulosTabela,
			"consultasHoje"	=>	$consultasHoje,
       );
        $this->load->view('layout',$arrayView);
		
	}
	
	
	public function medicosDisponiveis(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$medicosEspecialidades = $this->Profissionais->listarMedicosEspecialidades();
		$titulosTabela = array('Médico','Especialidade');
		
		$arrayView = array(
			"camada1"		=>	'telas',
			"camada2"		=>	'recepcao',
			"pagina"		=>	'medicosDisponiveis',
			"usuario"		=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"		=>	$this->session->userdata('ds_nivel'),
			"titulosTabela"	=>	$titulosTabela,
			"dados"			=>	$medicosEspecialidades,
			
       );
        $this->load->view('layout',$arrayView);
		
	}
	
	
	
	
	
	
	public function VincularAgendamentoConsulta(){
		$cliente 	=	$this->input->post("idCliente");
		$idAgenda 	=	$this->input->post("idAgendar");
		$idMedico	=	$this->input->post("idMedico");
		
		list($ano,$mes,$dia)		= 	explode("-",date("Y-m-d"));
		$clienteConsulta 			=	zeroEsquerda($cliente);
		$idConsulta					=	$ano.$mes.$dia.$idMedico.$clienteConsulta;
		
		$verificarNumeroConsulta	=	$this->Crud->readCond("tb_agendaconsultas","ds_numero_consulta",$idConsulta,"ds_tipo_atendimento","1","pk_id_agendaconsulta");
		if($verificarNumeroConsulta){
			$this->session->set_flashdata( 'mensagemerror', 'Esse paciente registrou uma consulta hoje. Verificar se é retorno. ' );
			redirect("Medicos/formAtendimentoConsultas");
		}
		
		
		$dados = array(
			"fk_id_cliente"		=>	$cliente,
			"ds_numero_consulta"=>	$idConsulta,
			
		);
		$this->Crud->update( "tb_agendaconsultas",$dados,array( "pk_id_agendaconsulta" => $idAgenda ) );
		$this->Crud->update( "tb_clientes",array( "ds_ativo" => '1' ),array( "pk_id_cliente" => $cliente ) );
		redirect("Recepcao");
	}
	
	
	/*====================================================
	Função: Carregar a Agenda
	Nome: formAgendarConsultas
	Última Modificação: 03/09/2019
	======================================================*/
	public function formAgendarConsultas(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$codMedico = $this->uri->segment(3);
		
		$dados = $this->Profissionais->listarProfissionaisById($codMedico);
		$consultas = $this->Crud->readCond("tb_agendaconsultas","fk_id_profissional",$codMedico,"ds_status >","0","ds_data DESC ,ds_hora ASC ");
		$diasAtendimento = $this->Crud->readBy("tb_diasatendimento","fk_id_profissional",$codMedico,"ds_dia_semana DESC");
		
		
		$horarioAtendimento = $this->Crud->readBy("tb_horariosatendimento","fk_id_profissional",$codMedico,"fk_id_profissional");
		
		if($consultas){
			foreach($consultas as $rowConsultas){
				$data = strtotime($rowConsultas["ds_data"]);
				$diaSemana = date('w',$data); // dia da semana da data
				$dataArray =  date('Y-m-d',$data);
				$turnosAtendimento = $this->Agenda->listarAgendaMedicaTurnoAtendimento($codMedico,$diaSemana);
				$contarConsultasDia = $this->Agenda->contarConsultasDia($dataArray);
				
				switch($turnosAtendimento){
					case 0:
						$consultasPorDia = 0;
						$diaAtendimento = FALSE;
						break;
					case 1:
						$consultasPorDia = $horarioAtendimento[0]["ds_qtdatendmanha"]+$horarioAtendimento[0]["ds_qtdatendtarde"];
						$diaAtendimento = TRUE;
						
						break;
					case 2:
						$consultasPorDia = $horarioAtendimento[0]["ds_qtdatendmanha"];
						$diaAtendimento = TRUE;
						break;
					case 3:
						$consultasPorDia = $horarioAtendimento[0]["ds_qtdatendtarde"];
						$diaAtendimento = TRUE;
						
						break;
				}
				
				if($contarConsultasDia >= $consultasPorDia){
					$status = "0";
				}else{
					$status = "1";
				}

				$agendaConsulta[$dataArray]["pk_id_profissional"] 	= $codMedico;
				$agendaConsulta[$dataArray]["dia_atendimento"]		= $diaAtendimento;
				$agendaConsulta[$dataArray]["qtd_atendimentos"]		= $consultasPorDia;
				$agendaConsulta[$dataArray]["qtd_agendamentos"]		= $contarConsultasDia;
				$agendaConsulta[$dataArray]["total_vagas"]			= $consultasPorDia - $contarConsultasDia;
				$agendaConsulta[$dataArray]["ds_data"] 				= $rowConsultas["ds_data"];
				$agendaConsulta[$dataArray]["status"] 				= $status;
			}
		}else{
			$agendaConsulta = array();
		}
		
		$ano = $this->uri->segment(4);
		$arrayMes = array(
			1 => 'Janeiro',
			2 => 'Fevereiro',
			3 => 'Março',
			4 => 'Abril',
			5 => 'Maio',
			6 => 'Junho',
			7 => 'Julho',
			8 => 'Agosto',
			9 => 'Setembro',
			10 => 'Outubro',
			11 => 'Novembro',
			12 => 'Dezembro'
		);
		$daysWeek = array(
			'Sun',
			'Mon',
			'Tue',
			'Wed',
			'Thu',
			'Fri',
			'Sat'
		);
		$diasSemana = array(
			'Dom',
			'Seg',
			'Ter',
			'Qua',
			'Qui',
			'Sex',
			'Sab'
		);
		
		
		
		$diasMeses = diasMeses($ano);
		$arrayRetorno = array();
	
		for($i =1; $i <= 12; $i++){
			$arrayRetorno[$i] = array();
			for($n=1; $n<= $diasMeses[$i]; $n++){
				$dayMonth = gregoriantojd($i, $n, $ano);
				$weekMonth = substr(jddayofweek($dayMonth, 1),0,3);
					
				if($weekMonth == 'Mun') $weekMonth = 'Mon';
				$arrayRetorno[$i][$n] = $weekMonth;
			}
		}
		//Planos de saúde
		$planSaude = $this->Consultas->listarMedicosPlanos($codMedico);
		
		$titulosTabela = array('Cliente','Dia Consulta','Horário Consulta','Telefone');
		
		$arrayView = array(
			"camada1"			=>	'telas',
			"camada2"			=>	'recepcao',
			"pagina"			=>	'formAgendarConsultas',
			"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"			=>	$this->session->userdata('ds_nivel'),
			"medico"			=>	$codMedico,
			"ano"				=>	$ano,
			"arrayMes"			=>	$arrayMes,
			"daysWeek"			=>	$daysWeek,
			"diasSemana"		=>	$diasSemana,
			"diasAtendimento"	=>	$diasAtendimento,
			"arrayRetorno"		=>	$arrayRetorno,
			"dados" 			=>	$dados,
			"planos"			=>	$planSaude,
			"agendaConsulta"	=>	$agendaConsulta,
			"consultas"			=>	$consultas,
			"titulosTabela"		=>	$titulosTabela,
       );
        $this->load->view('layout',$arrayView);
	}
	
	
	/*===========================================================
	Função: Carregar horários dos dias de consultas e preencher o 
			modal com os hoários disponíveis para consulta
	Nome: 	consultasDoDia
	Última 	
	============================================================*/
	public function consultasDoDia(){
		$idMedico = trim( $_POST[ 'codMedico' ] );
		$diaConsulta = trim( $_POST[ 'data' ] );
		// verificar o dia semana da data
		$diaSemanaConsulta = date('w', strtotime($diaConsulta));
		//procurar o os turnos de atendimento do médico de acordo com a data
		$turnoAtendimento = $this->Agenda->listarAgendaMedicaTurnoAtendimento($idMedico,$diaSemanaConsulta);
		//procurar o turno de atendimento do médico
		$horariosAtendimento 		= 	$this->Agenda->listarHorarioAgendamentoMedico($idMedico);
		$horaManhaInicio			=	$horariosAtendimento[0]["ds_horarioini_matutino"];
		$horaManhaFim				=	$horariosAtendimento[0]["ds_horariofim_matutino"];
		
		$horaTardeInicio			=	$horariosAtendimento[0]["ds_horarioini_vespertino"];
		$horaTardeFim				=	$horariosAtendimento[0]["ds_horariofim_vespertino"];
		
		$tempoConsulta				=	$horariosAtendimento[0]["ds_tempo_consulta"];
		
		$qtdAntedimentoManha		=	$horariosAtendimento[0]["ds_qtdatendmanha"];
		$qtdAntedimentoTarde		=	$horariosAtendimento[0]["ds_qtdatendtarde"];
		
		// selecionar consultas do dia
		$consultasDoDia = $this->Agenda->listarConsultasDoDia($diaConsulta,$idMedico);
		
		// calcular o intervalo do almoço e converter em quantidade de consultas
		$saidaAlmoco = DateTime::createFromFormat('H:i:s', $horaManhaFim);
		$retornoAlmoco = DateTime::createFromFormat('H:i:s', $horaTardeInicio);
		$diferenca = $saidaAlmoco->diff($retornoAlmoco);
		list($horas,$minutos,$segundos) = explode(':',$diferenca->format('%H:%I:%S'));
		$horas = $horas * 60;
		$horaAlmoco = floor(($horas + $minutos)/$tempoConsulta);
		
		
		
		
		switch($turnoAtendimento){
			case 0:
				$totalAtendimentoDia = 0;
				break;
			case 1: //trabalha os dois turnos
				$totalAtendimentoDia = $qtdAntedimentoManha + $qtdAntedimentoTarde+$horaAlmoco;
				$horaConsulta = date('H:i:s', strtotime($horaManhaInicio));
				break;
			case 2:
				$totalAtendimentoDia = $qtdAntedimentoManha;
				$horaConsulta = date('H:i:s', strtotime($horaManhaInicio));
				break;
			case 3:
				$totalAtendimentoDia = $qtdAntedimentoTarde;
				$horaConsulta = date('H:i:s', strtotime($horaTardeInicio));
				break;
		}
		
		
		if($totalAtendimentoDia > 0){
			//Gerando a sequência de horários para consulta
			for($i = 1;$i <= $totalAtendimentoDia; $i++){
				//var_dump("hora consulta: ".$horaConsulta." fim manhã: ".$horaManhaFim." hora incio tarde: ".$horaTardeInicio);
				if($horaConsulta < $horaManhaFim || $horaConsulta >= $horaTardeInicio){
					$verificarHorario = $this->Agenda->verificarHorario($idMedico,$diaConsulta,$horaConsulta);
				 	
					//Se NÃO encontrou horário agendado, significa que está vago, 
					if(!$verificarHorario){
						$horario[$i]['dia'] 		= $diaConsulta;
						$horario[$i]['horas'] 		= date('H:i', strtotime($horaConsulta));
						$horario[$i]['medico'] 		= $idMedico;
					}
					
				}
				$horaConsulta = date('H:i:s', strtotime('+'.$tempoConsulta.' minute', strtotime($horaConsulta)));
				

			}
			jsonMe($horario);
		}
		
	}
	
	public function agendarConsulta(){
		$idMedico			=	$this->input->post("idMedico");
		$diaConsulta		=	$this->input->post("diaConsulta");
		$horaConsulta		=	$this->input->post("horaConsulta");
		$cliente			=	$this->input->post("cliente");
		$telefone			=	$this->input->post("telefone");
		$tipoAtendimento	=	$this->input->post("tipoAtendimento");
		$planoSaude			=	$this->input->post("planoSaude");
		$clienteRetorno		=	$this->input->post("idClienteRetorno");
		$consultaRetorno	=	$this->input->post("idConsultaRetorno");
		
		
		
		$acao = $this->input->post("action");
		$dados = array(
			'fk_id_profissional'	=>	$idMedico,
			'ds_data'				=>	date('Y-m-d', strtotime($diaConsulta)),
			'ds_hora'				=>	$horaConsulta,
			'ds_nome_cliente'		=>	$cliente,
			'ds_telefone'			=>	$telefone,
			'ds_tipo_atendimento'	=>	$tipoAtendimento,
			'ds_plano_saude'		=>	$planoSaude,
			'fk_id_cliente'			=>	$clienteRetorno,
			'ds_numero_consulta'	=>	$consultaRetorno,
			'ds_status'				=>	1,// 0 = CANCELADO, 1 = AGENDADO, 2 = CONFIRMADO, 3 = ATENDIDO
			'ds_usuario'			=>	$this->session->userdata('pk_id_usuario'),
			'ds_data_cadastro'		=>	date('Y-m-d'),
			'ds_hora_cadastro'		=>	date('H:i:s'),
		);
		
		$this->form_validation->set_rules( 'idMedico', 'identificação médica', 'required' );
		$this->form_validation->set_rules( 'diaConsulta', 'Dia da consulta', 'required' );
		$this->form_validation->set_rules( 'horaConsulta', 'hora da consulta', 'required' );
		$this->form_validation->set_rules( 'cliente', 'nome do cliente', 'required' );
		
		if($acao == "create"){
			$duplicidade = $this->Consultas->listarConsultasAgendadasCliente( $cliente,$telefone,date('Y-m-d', strtotime($diaConsulta)),$idMedico,$tipoAtendimento,"ds_nome_cliente" );
			if(!$duplicidade){
				$this->Crud->create( "tb_agendaconsultas", $dados );
				redirect( 'Recepcao/formAgendarConsultas/'.$idMedico.'/'.date('Y') );
			}else{
				$this->session->set_flashdata( 'mensagemerror', 'Já existe um cliente com esse nome e telefone cadastrado pra esse dia e médico!' );
				redirect( 'Recepcao/formAgendarConsultas/'.$idMedico.'/'.date('Y') );
			}
		}
		
		
	}
	
	
	public function formConfirmarConsulta(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		$titulosTabela 				=	array('Cliente','Dia Consulta','Horário Consulta','Médico','Telefone');
		$dadosConsultasAgendadas 	=	$this->Consultas->listarConsultasAgendadas();
		$arrayView = array(
			"camada1"			=>	'telas',
			"camada2"			=>	'recepcao',
			"pagina"			=>	'formConfirmarConsultas',
			"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"			=>	$this->session->userdata('ds_nivel'),
			"consultasAgendadas"=>	$dadosConsultasAgendadas,
			"titulosTabela"		=>	$titulosTabela,
       );
        $this->load->view('layout',$arrayView);
	}
	/*====================================================
	Função: Registrar a confirmação da consulta
	Nome: confirmarConsulta
	Última Modificação: 
	======================================================*/
	public function confirmarConsulta(){
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarStatus = $this->Crud->readBy("tb_agendaconsultas", "pk_id_agendaconsulta",$codigo,"ds_status");
		$confirmar = $this->uri->segment(3);
		
		switch($verificarStatus[0]["ds_status"]){
			//Apesar das consultas canceladas não aparecerem na tela de consultas agendadas
			//Deixei a opção disponível (caso 0) 
			case 0:
				$dados = 2;
				break;
				
			case 1:
				$dados = 2;
				break;
			case 2:
				$this->session->set_flashdata( 'mensagemerror', 'Essa consulta já está confirmada!' );
				redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"]);
				break;
			case 3:
				$this->session->set_flashdata( 'mensagemerror', 'Essa consulta já foi efetuada!' );
				redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"]);
				break;
		}
		
		$this->Crud->update( "tb_agendaconsultas",array( "ds_status" => $dados ),array( "pk_id_agendaconsulta" => $codigo ) );
		if($confirmar == "false"){
			redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"].'/'.date('Y'));
		}else{
			redirect("Recepcao/formConfirmarConsulta");
		}
		
	}
	
	
	
	/*====================================================
	Função: Registrar o cancelamento da consulta
	Nome: cancelarConsulta
	Última Modificação: 
	======================================================*/
	public function cancelarConsulta(){
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarStatus = $this->Crud->readBy("tb_agendaconsultas", "pk_id_agendaconsulta",$codigo,"ds_status");
		$cancelar = $this->uri->segment(3);
		
		switch($verificarStatus[0]["ds_status"]){
			
			case 0:
				$dados = 0;
				break;
			case 1:
				$dados = 0;
				break;
			/*case 2:
				$this->session->set_flashdata( 'mensagemerror', 'Essa consulta já está confirmada!' );
				redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"].'/'.date('Y'));
				break;*/
			case 3:
				$this->session->set_flashdata( 'mensagemerror', 'Essa consulta já foi efetuada!' );
				redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"].'/'.date('Y'));
				break;
		}
		$this->Crud->update( "tb_agendaconsultas",array( "ds_status" => $dados ),array( "pk_id_agendaconsulta" => $codigo ) );
		if($cancelar == "false"){
			redirect("Recepcao/formAgendarConsultas/".$verificarStatus[0]["fk_id_profissional"].'/'.date('Y'));
		}else{
			redirect("Recepcao/formConfirmarConsulta");
		}
		
	}
	/*====================================================
	Função: listar informações e retornar em json
	Nome: AgendaJSON
	======================================================*/
	public function AgendaJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Crud->readBy( "tb_agendaconsulta", "id", $id, "title" );
		// jsonMe é um 'helper' criado por mim e está localizado no arquivo clinica_helper na pasta application/helpers
		jsonMe($data); 
	}
	
	public function listarUltimaConsultaAtiva(){
		$cpf = trim( $_POST[ 'cpf' ] );
		$cliente = $this->Crud->readBy("tb_clientes","ds_cpf_cliente",$cpf);
		if($cliente){
			$ultimaConsulta = $this->Consultas->listarultimaConsultaAtiva($cliente[0]["pk_id_cliente"]);
			if($ultimaConsulta[0]["ds_numero_consulta"]>0){
				jsonMe($ultimaConsulta);
			}else{
				$jsondt[] = array( 
					'retorno' => 'naoJson',
				);
				jsonMe( $jsondt );
			}
		}else{
			$jsondt[] = array( 
					'retorno' => 'naoCliente',
				);
				jsonMe( $jsondt );
		}
	}
	
	public function formImprimirRecibo(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		//Selecionar todas as consultas finalizadas com os dados do paciente e do médico.
		$dadosConsultasFinalizadas 	=	$this->Consultas->listarConsultasFinalizadas();
		$titulosTabela 				=	array('Cliente','Dia Consulta','Médico');
		
		$arrayView = array(
			"camada1"				=>	'telas',
			"camada2"				=>	'recepcao',
			"pagina"				=>	'formImprimirRecibo',
			"usuario"				=>	$this->session->userdata('ds_nome_usuario'),
			"perfil"				=>	$this->session->userdata('ds_nivel'),
			"consultasFinalizadas"	=>	$dadosConsultasFinalizadas,
			"titulosTabela"			=>	$titulosTabela,
       );
        $this->load->view('layout',$arrayView);
		
	}
	public function imprimirRecibo(){
		$idConsulta 	= 	$this->input->post("idConsulta");
		$valor 			=	$this->input->post("valor");
		$valorExtenso 	=	extenso($valor,false,true);
		
		$dadosRecibo	=	$this->Consultas->listarConsultasFinalizadasPorConsulta($idConsulta);
		$dadosMedico	=	$this->Profissionais->listarProfissionaisById($dadosRecibo[0]["pk_id_profissional"]);
		$dataConsulta	=	mesExtenso(date('d/m/Y',strtotime($dadosRecibo[0]["ds_data_consulta"])));
		$arrayRecibo = array(

				"brasao"			=>	FCPATH."external/img/brasao.jpg",
				"fundo"				=>	FCPATH."external/img/fundo.jpg",
				"usuario"			=>	$this->session->userdata('ds_nome_usuario'),
				"perfil"			=>	$this->session->userdata('ds_nivel'),
				"dadosMedico"		=>	$dadosMedico,
				"dadosRecibo"		=>	$dadosRecibo,
				"valor"				=>	$valor,
				"valorExtenso"		=>	$valorExtenso,
				"mesExtenso"		=>	$dataConsulta,
				
			);
			imprimir($arrayRecibo,"recibo_consulta","R");
			
		
	}
}