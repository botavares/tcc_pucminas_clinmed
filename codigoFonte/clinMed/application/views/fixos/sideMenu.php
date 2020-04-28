<body class="nav-md">
    <div class="container body" id="container">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><span class="nome_sistema">Clínica Médica</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				  <?php 
					$this->session->userdata('ds_sexo')==1 ? $nomeAvatar = "usuaria.png" : $nomeAvatar = 'usuario.png';
				 ?>
                <img src="<?php echo base_url()."external/img/".$nomeAvatar ?>" alt="avatar do usuário" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bem vindo,</span>
                <p id="nome_usuario"><?php echo $this->session->userdata('ds_nome_profissional')?></p>
              </div>
            </div>
			  <hr>
            <!-- /menu profile quick info -->
<!-- sidebar menu -->
			<section id="menu-lateral" alt="menu lateral">
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">


				<?php 
					if($this->session->userdata('ds_nivel')==1){
				?>
				<div class="menu_section">
					<ul class="nav side-menu">
						<li><a href="<?php echo base_url()."Home/iniciar" ?>"><i class="fas fa-home fa-2x" alt="Tela inicial"></i> Início</a></li>
					</ul>
				</div>	
				<div class="menu_section">
					<h3 class="title-side-menu">Administrativo</h3>
					<ul class="nav side-menu">
						<li><a><i class="fas fa-print fa-2x"></i>Relatórios <span class="fa fa-chevron-down"></span></a>
                    		<ul class="nav child_menu">
                      			<li><a href="<?php echo base_url()."Relatorios/relatoriosClientes"?>" target="_blank">Relação de Clientes</a></li>
								<li><a href="#" data-toggle="modal" data-target="#modalAnaliticoClinica">Relatório Analítico</a></li>
                      			
                    		</ul>
                  		</li>
						<li>
							<a href="<?php echo base_url()."Cargos"?>"><i class="fas fa-sitemap fa-2x"></i><span class="label-side-menu">Cargos</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Profissionais"?>"><i class="far fa-id-card fa-2x"></i><span class="label-side-menu">Profissionais</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Usuarios"?>"><i class="fas fa-users fa-2x"></i><span class="label-side-menu">Usuários</span> </span></a>
						</li>
		  				<li>
							<a href="<?php echo base_url()."HorariosAtendimento"?>"><i class="far fa-clock fa-2x"></i></i><span class="label-side-menu">Horários de atendimento</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."DiasAtendimento"?>"><i class="far fa-calendar-alt fa-2x"></i><span class="label-side-menu">Dias de atendimento</span> </span></a>
						</li>
						


					</ul>
				</div>
				<?php } ?>
				<div class="menu_section">
				<?php 
					if($this->session->userdata('ds_nivel')==2){
				?>
					<h3 class="title-side-menu">Atendimento</h3>
					<div class="menu_section">
						<ul class="nav side-menu">
							<li><a href="<?php echo base_url()."Home/iniciar" ?>"><i class="fas fa-home fa-2x" alt="Tela inicial"></i> Início</a></li>
						</ul>
					</div>	
					<ul class="nav side-menu">
						<li><a><i class="fas fa-print fa-2x"></i>Relatórios <span class="fa fa-chevron-down"></span></a>
                    		<ul class="nav child_menu">
                      			<li><a href="<?php echo base_url()."Relatorios/relatoriosClientes"?>" target="_blank">Relação de Clientes</a></li>
                    		</ul>
                  		</li>
						<li>
							<a href="<?php echo base_url()."Recepcao"?>"><i class="fas fa-user-nurse fa-2x"></i><span class="label-side-menu">Recepção</span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Clientes"?>"><i class="fas fa-user-injured fa-2x"></i><span class="label-side-menu">Cliente</span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Recepcao/medicosDisponiveis"?>"><i class="far fa-calendar-alt fa-2x">	</i>Agendar Consultas</a>
						</li>
						
						
					</ul>
				<?php } ?>
				</div>
				<div class="menu_section">
				<?php 
					if($this->session->userdata('ds_nivel')==3){
				?>
					 <h3 class="title-side-menu">Área Médica</h3>
					<div class="menu_section">
						<ul class="nav side-menu">
							<li><a href="<?php echo base_url()."Home/iniciar" ?>"><i class="fas fa-home fa-2x" alt="Tela inicial"></i> Início</a></li>
						</ul>
					</div>	
					<ul class="nav side-menu">
						<li><a><i class="fas fa-print fa-2x"></i>Relatórios <span class="fa fa-chevron-down"></span></a>
                    		<ul class="nav child_menu">
                      			<li><a href="<?php echo base_url()."Relatorios/relatoriosClientes"?>" target="_blank">Relação de Clientes</a></li>
								<li><a href="#" data-toggle="modal" data-target="#modalAnaliticoClinica">Relatório Analítico</a></li>
                      			
                    		</ul>
                  		</li>
						<li>
							<a href="<?php echo base_url()."Medicos/formAtendimentoConsultas"?>"><i class="fas fa-stethoscope fa-2x"></i><span class="label-side-menu">Iniciar Consulta</span> </span></a>
						</li>

						<li>
							<a href="<?php echo base_url()."Medicos/formPacienteHistorico"?>"><i class="fas fa-book-medical fa-2x"></i><span class="label-side-menu">Prontuários Pacientes</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Exames/formRecebimentoExame"?>"><i class="fas fa-file-medical fa-2x"></i><span class="label-side-menu">Recebimento Exames</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Receitas/formSegundaReceita"?>"><i class="fas fa-copy fa-2x"></i><span class="label-side-menu">Segunda via Receitas</span> </span></a>
						</li>
						<li>
							<a href="<?php echo base_url()."Medicamentos"?>"><i class="fas fa-pills fa-2x"></i><span class="label-side-menu">Medicamentos</span> </span></a>
						</li>
						
					</ul>

					<?php } ?><!-- FIM ADMINISTRATIVO-->
				 </div><!-- fim menu section-->
		</section>
		</div>
            <div class="sidebar-footer hidden-small">
				<a data-toggle="tooltip" data-placement="top" title="Sair" href="<?php echo base_url()."Usuarios/logOut"?>">
                	<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              	</a>
				
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="" aria-hidden="true"></span>
              </a>
              
            </div><!-- /menu footer buttons -->
</div><!-- left-col-->
 </div>           