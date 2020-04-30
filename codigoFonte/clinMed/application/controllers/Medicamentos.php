<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicamentos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Medicamentos_model', 'medicamentos');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
    }
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		//carregar Medicamentos cadastrados
		$dados = $this->medicamentos->medicamento_fabricantes();
		$especialidadeMedica = $this->Crud->read("tb_especialidades","ds_nome_especialidade");
		//carregar fabricantes
		$fabricantes = $this->Crud->read("tb_fabricantemedicamentos","ds_nome_fabricante");
		
		//carregar classes de medicamentos
		$classes = $this->Crud->read("tb_classesmedicamentos","ds_nome_classe");
		
		//carregar medicamentos inativos para o modal de recuperação de medicamentos deletados
		$medicamentosExcluidos = $this->medicamentos->medicamentosInativos();
		
		 $tituloTabelas = array(
            "Nome do medicamento","Princípio Ativo","Apresentação","Fabricante"
        );
        $arrayView = array(
            "camada1"		=> 'telas',
            "camada2"		=> 'medicamentos',
            "pagina"		=> 'medicamentos',
            "usuario"		=> $this->session->userdata('ds_nome_profissional'),
            "perfil"		=> $this->session->userdata('ds_nivel'),
			"dados"			=> $dados,
			"especialidades"=>$especialidadeMedica,
			"fabricantes"	=> $fabricantes,
			"classe"		=> $classes,
			"medExcluidos"	=> $medicamentosExcluidos,
			"titulosTabela"	=> $tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	public function formMedicamentos(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$especialidadeMedica = $this->Crud->read("tb_especialidades","ds_nome_especialidade");
		//carregar fabricantes
		$fabricantes = $this->Crud->read("tb_fabricantemedicamentos","ds_nome_fabricante");
		
		//carregar classes de medicamentos
		$classes = $this->Crud->read("tb_classesmedicamentos","ds_nome_classe");
		
		 $arrayView = array(
            "camada1"		=>'telas',
            "camada2"		=>'medicamentos',
            "pagina"		=>'formMedicamentos',
			"fabricantes"	=>$fabricantes,
			"classe"		=>$classes,
			"especialidades"=>$especialidadeMedica,
            "usuario"		=>$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>$this->session->userdata('ds_nivel'),
        );
        $this->load->view('layout',$arrayView);
	}
	
	public function create(){
		
		$generico	 		= $this->input->post("nomeGenerico");
		$nomeMedicamento 	= $this->input->post("nomeMedicamento");
		$apresentacao		= $this->input->post("apresentacao");
		$especialidade		= $this->input->post("especialidade");
		$posologia			= $this->input->post("posologia");
		$restricoes			= $this->input->post("restricoes");
		$classe				= $this->input->post("classe");
		$fabricante			= $this->input->post("fabricante");
		$acao 	 			= $this->input->post("action");
		
		$dados = array(
			"ds_nome_generico"		=> $generico,
			"ds_nome_medicamento"	=> $nomeMedicamento,
			"ds_apresentacao"		=> $apresentacao,
			"ds_posologia"			=> $posologia,
			"ds_restricoes"			=> $restricoes,
			"fk_id_classe"			=> $classe,
			"fk_id_fabricante"		=> $fabricante,
			
		);
		
		
		$this->form_validation->set_rules( 'nomeGenerico', 'Nome genérico do medicamento', 'required' );
		$this->form_validation->set_rules( 'nomeMedicamento', 'Nome Comercial do medicamento', 'required' );
		$this->form_validation->set_rules( 'apresentacao', 'apresentacao do medicamento', 'required' );
		$this->form_validation->set_rules( 'especialidade', 'especialidade do medicamento', 'required' );
		$this->form_validation->set_rules( 'classe', 'classe do medicamento', 'required' );
		$this->form_validation->set_rules( 'fabricante', 'Nome do fabricante', 'required' );
		
		if ( $this->form_validation->run() == TRUE ) {
			
			if ( $acao == 'create' ) {
				$duplicidade = $this->medicamentos->duplicidadeMedicamentos($generico,$nomeMedicamento,$apresentacao,$fabricante);
				if ( !$duplicidade ) {
					$this->Crud->create( "tb_medicamentos", $dados );
					redirect( 'Medicamentos' );
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um medicamento com essas caracaterísticas cadastradas!' );
					redirect( 'Medicamentos' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->Crud->update( "tb_medicamentos", $dados, array( "pk_id_medicamento" => $this->input->post( 'id' ) ) );
					redirect( 'Medicamentos' );
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formMedicamentos();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Medicamentos');
			}
		}
	}
	/*====================================================
	Função: Deletar de forma Lógica um item
	Nome: delete
	Última Modificação: 03/09/2019
	======================================================*/
	public function deleteLogico() {
		$codigo = $this->input->post( "chavePrimaria" );
			$this->Crud->update( "tb_medicamentos", array( "ds_dellogico" => 'TRUE' ), array( "pk_id_medicamento" => $codigo ));
			redirect("Medicamentos");
	}
	/*====================================================
	Função: Deletar de forma Lógica um item
	Nome: delete
	Última Modificação: 03/09/2019
	======================================================*/
	public function recuperaLogico() {
		$codigo = $this->input->post( "chavePrimaria" );
			$this->Crud->update( "tb_medicamentos", array( "ds_dellogico" => 'FALSE' ), array( "pk_id_medicamento" => $codigo ));
			redirect("Medicamentos");
	}
	/*====================================================
	Função: listar informações e retornar em json
	Nome: listarJSON
	Última Modificação: 10/06/2019
	======================================================*/
	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Crud->readBy( "tb_medicamentos", "pk_id_medicamento", $id, "ds_nome_medicamento" );
		jsonMe($data);
	}
	
	
}