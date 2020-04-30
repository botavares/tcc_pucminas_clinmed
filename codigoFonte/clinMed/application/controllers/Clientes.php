<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Crud_model', 'crud');
		$this->load->library( 'form_validation' );
    }
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		//carregar clientes para combo
		$this->uri->segment(3) == "Inativos" ? $status =  0 : $status =  1;
		//$consultaRecuperada == "" ? $queixa = "": $queixa = $consultaRecuperada["ds_queixa"] 
		
		$dados = $this->crud->readBy("tb_clientes","ds_ativo",$status,"ds_nome_cliente");
		$planosSaude = $this->crud->read("tb_planosaude","ds_nome_plano");
		
		 $tituloTabelas = array(
            "Cliente","Telefone"
        );
        $arrayView = array(
            "camada1"		=>	'telas',
            "camada2"		=>	'clientes',
            "pagina"		=>	'clientes',
            "usuario"		=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>	$this->session->userdata('ds_nivel'),
			"dados"			=>	$dados,
			"planosSaude"	=>	$planosSaude,
			"titulosTabela"	=>	$tituloTabelas,
			"status"		=>	$status //ativos ou inativos
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function formClientes(){
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		/*========================================================
		Vincular um cliente é associar a sua chave primária à uma 
		chave primária da tabela de consultas. Caso o cliente ainda
		não esteja cadastrado, é necessário cadastrar primeiro para
		depois vinculá-lo.
		===========================================================*/
		$acao = $this->input->post("action");
		if($this->uri->segment(3) == "vincular"){
			$vincularClienteAgendamento = "TRUE";
		}else{
			$vincularClienteAgendamento = "FALSE";
		}
		
		$planosSaude = $this->crud->read("tb_planosaude","ds_nome_plano");
		 $arrayView = array(
            "camada1"						=>	'telas',
            "camada2"						=>	'clientes',
            "pagina"						=>	'formClientes',
            "usuario"						=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"						=>	$this->session->userdata('ds_nivel'),
			"vincularClienteAgendamento"	=>	$vincularClienteAgendamento,
			"planosSaude"					=>	$planosSaude,
        );
        $this->load->view('layout',$arrayView);
	}
	
	public function registrarDados(){
		
		$nascimento			=	str_replace("/", "-", $this->input->post("nascimento"));
		$acao 		   		=	$this->input->post("action");
		$vinculo			=	$this->input->post("vinculo");
		
		$dados = array(
			"ds_nome_cliente"			=>	$this->input->post("nomeCliente"),
			"ds_cpf_cliente"			=>	$this->input->post("cpfCliente"),
			"ds_nascimento_cliente"		=>	date('Y-m-d', strtotime($nascimento)),
			"ds_sexo_cliente"			=>	$this->input->post("sexo"),
			"ds_responsavel_cliente"	=>	$this->input->post("responsavel"),
            "ds_nome_responsavel"		=>	$this->input->post("nomeResponsavel"),
            "ds_cpf_responsavel"		=>	$this->input->post("cpfResponsavel"),
			"ds_cep"					=>	$this->input->post("cep"),
			"ds_logradouro"				=>	$this->input->post("logradouro"),
			"ds_numresidencia"			=>	$this->input->post("numero"),
			"ds_complemento"			=>	$this->input->post("complemento"),
			"ds_bairro"					=>	$this->input->post("bairro"),
			"ds_cidade"					=>	$this->input->post("cidade"),
			"ds_telfixo"				=>	$this->input->post("telfixo"),
			"ds_telcel"					=>	$this->input->post("telcel"),
			"ds_email"					=>	$this->input->post("email"),
			"ds_plano_saude"			=>	$this->input->post("planoSaude"),
			"ds_nome_plano"				=>	$this->input->post("nomePlano"),
			"ds_numero_plano"			=>	$this->input->post("numeroPlano"),
			"ds_ativo"					=> 	1,
		);
		$this->form_validation->set_rules( 'nomeCliente', 'Nome do cliente', 'required' );
        $this->form_validation->set_rules( 'cpfCliente', 'CPF do cliente', 'required' );
		$this->form_validation->set_rules( 'nascimento', 'Data de nascimento do cliente', 'required' );
		$this->form_validation->set_rules( 'sexo', 'Sexo do cliente', 'required' );
		$this->form_validation->set_rules( 'planoSaude', 'O cliente possui plano de saude?', 'required' );
		
        if(!empty($this->input->post("responsavel"))){
			if($this->input->post("responsavel") == 1){
				$this->form_validation->set_rules( 'nomeResponsavel', 'Responsável pelo cliente', 'required' );    
				$this->form_validation->set_rules( 'cpfResponsavel', 'O CPF do responsável pelo cliente', 'required' );    
			}
		}else{
			$this->form_validation->set_rules( 'responsavel', 'O cliente possui um responsável legal?', 'required' );    
		}
		 if(!empty($this->input->post("planoSaude"))){
			if($this->input->post("planoSaude") == 1){
				$this->form_validation->set_rules( 'nomePlano', 'Nome do Plano de Saúde', 'required' );    
				$this->form_validation->set_rules( 'numeroPlano', 'Número do Plano de Saúde', 'required' );    
			}
		 }else{
			 $this->form_validation->set_rules( 'planoSaude', 'O cliente possui um Plano de saúde?', 'required' );    
		 }
        
		$this->form_validation->set_rules( 'cep', 'CEP do cliente', 'required' );
		$this->form_validation->set_rules( 'logradouro', 'Rua de residência', 'required' );
		$this->form_validation->set_rules( 'numero', 'Número da Residência do cliente', 'required' );
		$this->form_validation->set_rules( 'bairro', 'Bairro do cliente', 'required' );
		$this->form_validation->set_rules( 'cidade', 'Cidade do cliente', 'required' );
		$this->form_validation->set_rules( 'telcel', 'Telefone do cliente', 'required' );
		$this->form_validation->set_rules( 'email', 'Email do cliente', 'required|valid_email' );
		
		if ( $this->form_validation->run() == true ) {
			
			if ( $acao == 'create' ) {
				$duplicidade = $this->crud->readBy( "tb_clientes", "ds_cpf_cliente", $this->input->post("cpfCliente"),"ds_nome_cliente" );
				if ( !$duplicidade ) {
					$this->crud->create( "tb_clientes", $dados );
					if($vinculo == "FALSE"){
						redirect( 'Clientes' );
					}else if($vinculo == "TRUE"){
						
						
						redirect("Recepcao");
					}
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um cliente com esse cpf cadastrado!' );
					redirect( 'Clientes' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->crud->update( "tb_clientes", $dados, array( "pk_id_cliente" => $this->input->post( 'id' ) ) );
				redirect( 'Clientes' );
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formClientes();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Clientes');
			}
		}
	}

	public function delete() {
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarVinculo = $this->crud->readBy("tb_consultas", "fk_id_cliente",$codigo,"fk_id_cliente");
		if(!$verificarVinculo){
			$dados  = array(
				"ds_ativo"	=>	0,
			);
			$this->crud->update( "tb_clientes", $dados, array( "pk_id_cliente" => $codigo ) );
			redirect("Clientes");
		}else{
			$this->session->set_flashdata( 'mensagemerror', 'Não posso excluir cliente vínculados à consultas registradas!' );
			redirect("Clientes");
		}
	}
	
	public function reativar() {
		$codigo = $this->input->post( "chaveReativar" );
		$dados  = array(
			"ds_ativo"	=>	1,
		);
		$this->crud->update( "tb_clientes", $dados, array( "pk_id_cliente" => $codigo ) );
		redirect("Clientes");
		
	}
	

	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->crud->readBy( "tb_clientes", "pk_id_cliente", $id, "ds_nome_cliente" );
		// jsonMe é um 'helper' criado por mim e está localizado no arquivo clinica_helper na pasta application/helpers
		jsonMe($data); 
	}
	
	public function listarClientesCpfJSON(){
		$cpf = trim( $_POST[ 'cpf' ] );
		$data = $this->crud->readBy( "tb_clientes", "ds_cpf_cliente", $cpf, "ds_nome_cliente" );
		if(!$data){
			$jsondt = array( 
				array(
					'retorno' => 'false'
				),
			);
			echo json_encode( $jsondt );
		}else{
			jsonMe($data);
		}
	}
	
}