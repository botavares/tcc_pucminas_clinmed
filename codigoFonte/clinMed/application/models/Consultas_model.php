<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

	
	public function listarAtendimentosDeHoje($diaAtual=NULL){
		$default = $this->load->database('default', TRUE);
		
		$sql = "SELECT tb_agendaconsultas.pk_id_agendaconsulta,tb_agendaconsultas.ds_data,
				tb_agendaconsultas.ds_hora,tb_agendaconsultas.ds_nome_cliente,tb_agendaconsultas.ds_numero_consulta,
				tb_agendaconsultas.ds_tipo_atendimento,tb_agendaconsultas.fk_id_cliente,
				tb_planosaude.ds_nome_plano,tb_profissionais.pk_id_profissional ,tb_profissionais.ds_nome_profissional
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
	
	
	public function listarexamesAbertos($idMedico){
		$default = $this->load->database('default', TRUE);
		$sql = "
				SELECT distinct a.ds_numero_consulta,a.fk_id_cliente,a.fk_id_profissional, b.ds_nome_cliente,a.ds_data_consulta
from tb_consultas AS a,tb_clientes AS b, tb_examesconsultas AS c
WHERE 
a.fk_id_cliente = b.pk_id_cliente
AND 
a.ds_numero_consulta IN (SELECT ds_numero_consulta FROM tb_examesconsultas)
AND
a.ds_numero_consulta NOT IN (SELECT ds_numero_consulta FROM tb_recebimentoexames)
";
		$query = $default->query($sql);
        return $query->result_array();
	}
	
	public function listarDadosExames($idExame){
		$default = $this->load->database('default', TRUE);
		$query 		= $default->order_by("b.ds_nome_exame", 'ASC');
		$query 		= $default->where("a.pk_id_exameconsulta",$idExame);
		$query		= $default->join('tb_consultas as c', 'c.ds_numero_consulta = a.ds_numero_consulta');
		$query		= $default->join('tb_exames as b', 'b.pk_id_exame = a.fk_id_exame');		
		$query		= $default->from("tb_examesconsultas as a");
		$query		= $default->select("a.pk_id_exameconsulta,a.fk_id_exame,b.ds_nome_exame,c.fk_id_profissional,a.ds_numero_consulta,a.ds_resultado_exame,a.ds_data_registro");	
		$query = $default->get();
        return $query->result_array();
	}
	
	public function listarDadosReceita($idReceita=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by("b.ds_nome_medicamento", 'ASC');
		$query 		= $default->where("a.pk_id_receita_consulta",$idReceita);
		$query		= $default->join('tb_consultas as c', 'c.ds_numero_consulta = a.ds_numero_consulta');
		$query		= $default->join('tb_medicamentos as b', 'b.pk_id_medicamento = a.fk_id_medicamento');
		$query 		= $default->from("tb_receitasconsultas as a");
		$query 		= $default->select("a.pk_id_receita_consulta,a.ds_numero_consulta,a.fk_id_medicamento,c.fk_id_profissional,b.ds_nome_medicamento,b.ds_nome_generico,b.ds_apresentacao,a.ds_posologia,a.ds_data_registro");
		$query 		= $default->get();
		return $query->result_array();
	}
	
	public function listarultimaConsultaAtiva($cliente = NULL){
		$default = $this->load->database('default', TRUE);
		
		$query 		=	$default->where("fk_id_cliente", $cliente);
		$query 		=	$default->where("ds_tipo_atendimento", '1');
		$query		=	$default->select_max('ds_numero_consulta');
		$query		=	$default->select("fk_id_cliente");
		$query 		= 	$default->get('tb_consultas');
		return 			$query->result_array();
	
	}
	
	public function listarConsultasAgendadas(){
		$default 	= $this->load->database('default', TRUE);
		
		$query 		=	$default->where("ds_status >", "0");
		$query 		=	$default->order_by("a.ds_data", 'DESC');
		$query 		=	$default->order_by("a.ds_hora", 'ASC');
		
		$query		=	$default->join('tb_profissionais as b', 'b.pk_id_profissional = a.fk_id_profissional');
		$query 		=	$default->from('tb_agendaconsultas as a');
		$query 		=	$default->select("a.pk_id_agendaconsulta,a.ds_nome_cliente,a.ds_data,a.ds_hora,b.ds_nome_profissional,a.ds_status,a.ds_telefone");
		$query 		= $default->get();
		return $query->result_array();
	}
	
	
	public function listarConsultasAgendadasCliente($cliente=NULL, $telefone=NULL, $diaConsulta=NULL, $idMedico=NULL,$tipoAtendimento = NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		
		$query 		= $default->order_by("ds_nome_cliente", 'ASC');
		$query 		= $default->where("ds_status <=", "2");
		$query 		= $default->where("ds_status >", "0");
		$query 		= $default->where("ds_tipo_atendimento ", $tipoAtendimento);
		$query 		= $default->where("fk_id_profissional", $idMedico);
		$query 		= $default->where("ds_data", $diaConsulta);
		$query 		= $default->where("ds_telefone", $telefone);
		$query 		= $default->where("ds_nome_cliente", $cliente);
		$query 		= $default->get("tb_agendaconsultas");
		return $query->result_array();
	}
	
	public function listarConsultasFinalizadas(){
		$default 	= $this->load->database('default', TRUE);
		
		
		$query 		= $default->where("d.ds_plano_saude",'1');
		$query 		= $default->where("a.ds_tipo_atendimento",'1');
		$query 		= $default->where("d.ds_status",'3');
		$query 		= $default->where("a.ds_status",'3');
		$query		= $default->join('tb_agendaconsultas as d', 'a.ds_numero_consulta = d.ds_numero_consulta');
		$query		= $default->join('tb_profissionais as c', 'c.pk_id_profissional = a.fk_id_profissional');
		$query		= $default->join('tb_clientes as b', 'a.fk_id_cliente = b.pk_id_cliente');
		$query 		= $default->from("tb_consultas as a");
		$query 		= $default->select("a.pk_id_consulta, a.ds_numero_consulta,a.ds_data_consulta,b.ds_nome_cliente,b.ds_cpf_cliente,c.pk_id_profissional,c.ds_nome_profissional");
		
		$query 		= $default->get();
		return $query->result_array();
		
	}
	
	public function listarConsultasFinalizadasPorConsulta($idConsulta=NULL){
		$default 	= $this->load->database('default', TRUE);
		
		
		$query 		= $default->where("a.pk_id_consulta",$idConsulta);
		$query 		= $default->where("d.ds_plano_saude",'1');
		$query 		= $default->where("a.ds_status",'3');
		$query		= $default->join('tb_agendaconsultas as d', 'a.fk_id_cliente = d.fk_id_cliente');
		$query		= $default->join('tb_profissionais as c', 'c.pk_id_profissional = a.fk_id_profissional');
		$query		= $default->join('tb_clientes as b', 'a.fk_id_cliente = b.pk_id_cliente');
		$query 		= $default->from("tb_consultas as a");
		$query 		= $default->select("a.pk_id_consulta, a.ds_numero_consulta,a.ds_data_consulta,b.ds_nome_cliente,b.ds_cpf_cliente,c.ds_nome_profissional,c.pk_id_profissional");
		
		$query 		= $default->get();
		return $query->result_array();
		
	}
	
	public function listarReceitaMedica($numeroConsulta=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by("b.ds_nome_medicamento", 'ASC');
		$query 		= $default->where("a.ds_numero_consulta",$numeroConsulta);
		$query		= $default->join('tb_medicamentos as b', 'b.pk_id_medicamento = a.fk_id_medicamento');
		$query 		= $default->from("tb_receitasconsultas as a");
		$query 		= $default->select("a.pk_id_receita_consulta,a.fk_id_medicamento,b.ds_nome_medicamento,b.ds_nome_generico,b.ds_apresentacao,a.ds_posologia");
		$query 		= $default->get();
		return $query->result_array();
	}
	
	
	public function listarExamesMedico($numeroConsulta=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by("b.ds_nome_exame", 'ASC');
		$query 		= $default->where("a.ds_numero_consulta",$numeroConsulta);
		$query		= $default->join('tb_exames as b', 'b.pk_id_exame = a.fk_id_exame');
		$query 		= $default->from("tb_examesconsultas as a");
		$query 		= $default->select("a.pk_id_exameconsulta,a.fk_id_exame,b.ds_nome_exame,a.ds_resultado_exame,a.ds_data_registro");
		$query 		= $default->get();
		return $query->result_array();
		
	}
	
	public function listarMedicosPlanos($medico=NULL){
		$default 	= $this->load->database('default', TRUE);
	
		$query 		= $default->where("b.fk_id_profissional",$medico);
		$query		= $default->join('tb_medicosplanos as b', 'b.fk_id_plano = a.pk_id_plano');
		$query		= $default->join('tb_profissionais as c', 'b.fk_id_profissional = c.pk_id_profissional');
		$query 		= $default->from("tb_planosaude as a");
		$query 		= $default->select("a.pk_id_plano, a.ds_nome_plano,b.pk_id_medicosplanos");
		$query 		= $default->get();
		return $query->result_array();
		
	}
	
	public function listarReceitasExpedidas(){
		$default 	= $this->load->database('default', TRUE);
		$default->_protect_identfiers = false;
		
		$query		= $default->where('c.pk_id_cliente = a.fk_id_cliente');
		$query		= $default->where('d.pk_id_profissional = a.fk_id_profissional');
		$query		= $default->join('tb_consultas as b', 'b.ds_numero_consulta = a.ds_numero_consulta');
		$query		= $default->join('tb_clientes as c', 'c.pk_id_cliente = b.fk_id_cliente');
		$query		= $default->join('tb_profissionais as d', 'd.pk_id_profissional = b.fk_id_profissional');
		$query 		= $default->from("tb_receitasconsultas as a");
		$query 		= $default->select("a.pk_id_receita_consulta, a.ds_numero_consulta,b.fk_id_cliente,b.ds_data_consulta,c.ds_nome_cliente,d.pk_id_profissional,d.ds_nome_profissional");
		$query 		= $default->get();
		return $query->result_array();
	}
	public function somarConsultasPeriodo($idMedico,$dataInicio,$dataFim,$status){
		$default 	= $this->load->database('default', TRUE);
		
		$default->where("ds_status",$status);
		$idMedico == "99" ? :$default->where("fk_id_profissional",$idMedico);
		$default->where("ds_data_consulta >=",$dataInicio);
		$default->where("ds_data_consulta <=",$dataFim);
		$default->select('count(*)');
		$default->from("tb_consultas");
		$query = $default->count_all_results();
		return $query;
		
	}
	
	public function somarConsultasCanceladas($idMedico,$dataInicio,$dataFim,$status){
		$default 	= $this->load->database('default', TRUE);
		
		$default->where("ds_status",$status);
		$idMedico == "99" ? :$default->where("fk_id_profissional",$idMedico);
		$default->where("ds_data >=",$dataInicio);
		$default->where("ds_data <=",$dataFim);
		$default->select('count(*)');
		$default->from("tb_agendaconsultas");
		$query = $default->count_all_results();
		return $query;
		
	}
		
	public function planosSaudePeriodo($idMedico,$dataInicio,$dataFim,$status){
		$default 	= $this->load->database('default', TRUE);
		$default->group_by("ds_nome_plano");
		$idMedico == "99" ? :$default->where("fk_id_profissional",$idMedico);
		$default->where("b.ds_status",$status);
		$default->where("b.ds_data >=",$dataInicio);
		$default->where("b.ds_data <=",$dataFim);
		$default->join('tb_agendaconsultas as b', 'b.ds_plano_saude = a.pk_id_plano');
		$default->select('a.ds_nome_plano,count(*) as contagem');
		$default->from("tb_planosaude as a");
		$query 		= $default->get();
		return $query->result_array();
	}
	

	
	
	


	
}