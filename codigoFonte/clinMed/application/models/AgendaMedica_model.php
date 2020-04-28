<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgendaMedica_model extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
	public function agendaMedicaDias(){
		$default = $this->load->database('default', TRUE);
		$sql ="SELECT pk_id_diasatendimento,pk_id_profissional,ds_nome_profissional,ds_dia_semana,ds_turno_atendimento
				FROM tb_diasatendimento,tb_profissionais 
				WHERE 
				tb_diasatendimento.fk_id_profissional = tb_profissionais.pk_id_profissional
				AND
				tb_profissionais.ds_crm > 0";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	public function diasAtendimentoDoMedico($medico=NULL, $diaSemana=NULL){
		$default = $this->load->database('default', TRUE);
		$sql ="SELECT pk_id_diasatendimento,pk_id_profissional,ds_nome_profissional,ds_dia_semana,ds_turno_atendimento
				FROM tb_diasatendimento,tb_profissionais 
				WHERE 
				tb_diasatendimento.fk_id_profissional = tb_profissionais.pk_id_profissional
				AND
				tb_diasatendimento.fk_id_profissional = $medico
				AND 
				tb_diasatendimento.ds_dia_semana = $diaSemana
				";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	
	public function agendaMedicaHorarios(){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT pk_id_horarios,fk_id_profissional,ds_nome_profissional,ds_horarioini_matutino, ds_horariofim_matutino, ds_horarioini_vespertino,
				ds_horariofim_vespertino,ds_tempo_consulta,ds_qtdatendmanha,ds_qtdatendtarde
				FROM tb_profissionais, tb_horariosatendimento
				WHERE
				tb_profissionais.pk_id_profissional = tb_horariosatendimento.fk_id_profissional
				ORDER BY
				ds_nome_profissional";
		$query = $default->query($sql);
        return $query->result_array();
	}
	public function horariosDoMedico($horario = NULL){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT pk_id_horarios,fk_id_profissional,ds_nome_profissional,ds_horarioini_matutino, ds_horariofim_matutino, ds_horarioini_vespertino,
				ds_horariofim_vespertino,ds_tempo_consulta,ds_qtdatendmanha,ds_qtdatendtarde
				FROM tb_profissionais, tb_horariosatendimento
				WHERE
				tb_profissionais.pk_id_profissional = tb_horariosatendimento.fk_id_profissional
				AND 
				pk_id_horarios = $horario
				ORDER BY
				ds_nome_profissional";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	
	public function medicosSemRegistroAtendimento($tabela = NULL){
		$default = $this->load->database('default', TRUE);
		$query = "SELECT tb_profissionais.pk_id_profissional, tb_profissionais.ds_nome_profissional 
					FROM tb_profissionais,tb_cargos
					WHERE 
					tb_cargos.pk_id_cargo = tb_profissionais.fk_id_cargo
					AND 
					tb_cargos.ds_registro_conselho = 1
					AND 
					tb_profissionais.pk_id_profissional NOT IN ( SELECT fk_id_profissional FROM $tabela)
		";
		$query = $default->query($query);
		return $query->result_array();
	}
	/*============================================================
		Nome: listarHorarioAgendimentoMedico
		Função: Listar os horários de atendimento e quantidade de 
		consultas por turno.
		
	=============================================================*/
	public function listarAgendaMedicaTurnoAtendimento($idMedico = NULL, $diaSemana=NULL){
		$default = $this->load->database('default', TRUE);
		$query = $default->where('ds_dia_semana', $diaSemana);
		$query = $default->where('fk_id_profissional', $idMedico);
		$query = $default->select('ds_turno_atendimento');
		$query = $default->get('tb_diasatendimento');
        return $query->row("ds_turno_atendimento");
	}
	/*============================================================
		Nome: listarHorarioAgendimentoMedico
		Função: Listar os horários de atendimento e quantidade de 
		consultas por turno.
		
	=============================================================*/
	public function listarHorarioAgendamentoMedico($idMedico = NULL){
		$default = $this->load->database('default', TRUE);
		$query = $default->where('fk_id_profissional', $idMedico);
		$query = $default->get('tb_horariosatendimento');
        return $query->result_array();
	}
	
	public function contarConsultasDia($data = NULL){
		$default = $this->load->database('default', TRUE);
		$sql = "SELECT COUNT(tb_agendaconsultas.pk_id_agendaconsulta) AS 'totalConsultas'
				FROM tb_agendaconsultas
				WHERE
				tb_agendaconsultas.ds_data = '$data'
				AND
				ds_status > 0
				";
		$query = $default->query($sql);
        return $query->row("totalConsultas");
	}
	
	public function listarConsultasDoDia($diaConsulta = NULL, $idMedico = NULL){
		$default = $this->load->database('default', TRUE);
		$query = $default->where('ds_status >', 0);
		$query = $default->where('ds_data', $diaConsulta);
		$query = $default->where('fk_id_profissional', $idMedico);
		$query = $default->get('tb_agendaconsultas');
        return $query->result_array();
	}
	
	public function verificarHorario($idMedico = NULL, $diaConsulta = NULL, $horaConsulta = NULL){
		$default = $this->load->database('default', TRUE);
		$query = $default->where('ds_status >', 0);
		$query = $default->where('ds_hora', $horaConsulta);
		$query = $default->where('ds_data', $diaConsulta);
		$query = $default->where('fk_id_profissional', $idMedico);
		$query = $default->get('tb_agendaconsultas');
        return $query->result_array();
	}
	
	public function atendimentosDeHojePorMedico($medico=NULL,$diaAtual=NULL){
		$default = $this->load->database('default', TRUE);
		
		$sql = "SELECT tb_agendaconsultas.pk_id_agendaconsulta,tb_agendaconsultas.fk_id_profissional,tb_agendaconsultas.ds_data,
tb_agendaconsultas.ds_hora,tb_clientes.ds_nome_cliente,tb_clientes.pk_id_cliente,tb_clientes.ds_telcel,
tb_agendaconsultas.ds_status,tb_agendaconsultas.ds_tipo_atendimento,tb_planosaude.ds_nome_plano,tb_agendaconsultas.ds_numero_consulta
				FROM tb_agendaconsultas,tb_planosaude,tb_clientes
				WHERE
				tb_agendaconsultas.fk_id_profissional = $medico
				AND
				ds_data = '$diaAtual'
				AND
				tb_clientes.pk_id_cliente = tb_agendaconsultas.fk_id_cliente
				AND
				tb_planosaude.pk_id_plano = tb_agendaconsultas.ds_plano_saude
				AND
				tb_agendaconsultas.ds_status = 2
				AND
				tb_agendaconsultas.fk_id_cliente > 0
				
				
				ORDER BY
				ds_hora ASC";
		$query = $default->query($sql);
        return $query->result_array();
	}
	public function consultasFinalizadasPorMedico($medico=NULL){
		$default = $this->load->database('default', TRUE);
		
		$sql = "SELECT tb_agendaconsultas.pk_id_agendaconsulta,tb_agendaconsultas.fk_id_profissional,tb_agendaconsultas.ds_data,
tb_agendaconsultas.ds_hora,tb_clientes.ds_nome_cliente,tb_clientes.pk_id_cliente,tb_clientes.ds_telcel,
tb_agendaconsultas.ds_status,tb_agendaconsultas.ds_tipo_atendimento,tb_planosaude.ds_nome_plano,tb_agendaconsultas.ds_numero_consulta
				FROM tb_agendaconsultas,tb_planosaude,tb_clientes
				WHERE
				tb_agendaconsultas.fk_id_profissional = $medico
				AND
				tb_clientes.pk_id_cliente = tb_agendaconsultas.fk_id_cliente
				AND
				tb_planosaude.pk_id_plano = tb_agendaconsultas.ds_plano_saude
				AND
				tb_agendaconsultas.ds_status = 3
				AND
				tb_agendaconsultas.fk_id_cliente > 0
				ORDER BY
				ds_hora ASC";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	public function atendimentosDeHoje($diaAtual=NULL){
		$default = $this->load->database('default', TRUE);
		
		$sql = "SELECT tb_agendaconsultas.pk_id_agendaconsulta,tb_agendaconsultas.ds_data,
				tb_agendaconsultas.ds_hora,tb_agendaconsultas.ds_nome_cliente,
				tb_agendaconsultas.ds_tipo_atendimento,tb_agendaconsultas.fk_id_cliente,
				tb_planosaude.ds_nome_plano,tb_profissionais.ds_nome_profissional
				FROM tb_agendaconsultas,tb_profissionais,tb_planosaude
				WHERE
				ds_data = '$diaAtual'
				AND
				tb_profissionais.pk_id_profissional = tb_agendaconsultas.fk_id_profissional
				AND
				tb_agendaconsultas.ds_status = 2
				AND
				tb_agendaconsultas.ds_plano_saude = tb_planosaude.pk_id_plano
				ORDER BY
				ds_hora ASC";
		$query = $default->query($sql);
        return $query->result_array();
	}
}