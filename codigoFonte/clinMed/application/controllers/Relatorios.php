<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Usuarios_model', 'Usuarios');
		$this->load->model('Crud_model', 'Crud');
		$this->load->model('Clientes_model', 'Clientes');
		$this->load->model('Consultas_model', 'Consultas');
    }
	
	
	public function relatoriosClientes(){
		
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		if($this->session->userdata('ds_nivel') == 3){
			$idProfissional		=	$this->session->userdata('fk_id_profissional');
			$nomeProfisssional	=	$this->session->userdata('ds_nome_profissional');
			$relacaoClientes	=	$this->Clientes->clientesMedico($idProfissional);
		}else{
			$idProfissional		=	"99";
			$nomeProfisssional	=	"Clínica ClinMed";
			$relacaoClientes	=	$this->Crud->read("tb_clientes","ds_nome_cliente");
		}
		$dados = array(
			"brasao"				=>	FCPATH."external/img/brasao.jpg",
			"fundo"					=>	FCPATH."external/img/fundo.jpg",
			"profissional"			=>	$nomeProfisssional,
			"relacaoClientes"		=>	$relacaoClientes,
			
		);
		imprimir($dados,"relacao_clientes","R");//"R = Retrato e P = paisagem"
		
	}
	
	public function analiticoPeriodo(){
		$dataInicio = date("Y-m-d",strtotime($this->input->post("dataInicio")));
		list($dia,$mes,$ano) = explode("/",$this->input->post("dataFim"));
		$dateEnd = $ano.'-'.$mes.'-'.$dia;
		$dataFim 	=  date("Y-m-d",strtotime($dateEnd));
		
		if($this->session->userdata('ds_nivel') == 3){
			$idProfissional		=	$this->session->userdata('fk_id_profissional');
			$nomeProfisssional	=	$this->session->userdata('ds_nome_profissional');
			$relacaoClientes	=	$this->Clientes->clientesMedico($idProfissional);
		}else{
			$idProfissional		=	"99";
			$nomeProfisssional	=	"Clínica ClinMed";
			$relacaoClientes	=	$this->Crud->read("tb_clientes","ds_nome_cliente");
		}
		
		$statusConsulta = 3;
		$somarConsultasFinalizadasPeriodo 	= $this->Consultas->somarConsultasPeriodo($idProfissional,$dataInicio,$dataFim,$statusConsulta);

		$somarConsultasCanceladasPeriodo 	= $this->Consultas->somarConsultasCanceladas($idProfissional,$dataInicio,$dataFim,0);
		
		$contarPlanosSaude = $this->Consultas->planosSaudePeriodo($idProfissional,$dataInicio,$dataFim,$statusConsulta);
		
		
			$dados = array(
				"brasao"				=>	FCPATH."external/img/brasao.jpg",
				"fundo"					=>	FCPATH."external/img/fundo.jpg",
				"profissional"			=>	$nomeProfisssional,
				"consultasFinalizadas"	=>	$somarConsultasFinalizadasPeriodo,
				"consultasCanceladas"	=>	$somarConsultasCanceladasPeriodo,
				"planosDeSaude"			=>	$contarPlanosSaude,
				"dataInicio"			=>	$this->input->post("dataInicio"),
				"dataFim"				=>	$this->input->post("dataFim"),

			);
			imprimir($dados,"relatorio_analitico","R");//"R = Retrato e P = paisagem"
		
	}
}