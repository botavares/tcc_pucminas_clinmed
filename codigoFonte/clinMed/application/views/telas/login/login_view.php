<body class="login">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

       
       
       
       	 <?php
    if($this->session->flashdata('mensagemok')):?>
		<div id="porta-mensagem">
			<div class="mensagem alert alert-success alert-block alert-aling" role="alert">
				<?php echo $this->session->flashdata('mensagemok')?>
			</div>
		</div>
	<?php endif;?>
	<?php
	if($this->session->flashdata('mensagemError')):?>
		<div id="porta-mensagem">
			<div class="mensagem alert alert-danger alert-block alert-aling" role="alert">
				<?php echo $this->session->flashdata('mensagemerror')?>
			</div>
		</div>
	<?php endif;?>
		<div>
			<h1 id="sistema">GERENCIAMENTO DE CLÍNICA MÉDICA - CLINMED</h1>
			<h1 id="subtitulo">Trabalho de conclusão de curso - PUC Minas Gerais</h1>
       		<!--<img src="<?php echo base_url()."external/img/logo.png"?>"/>-->
		</div>
        <div class="login_wrapper">
			
            <div class="animate form login_form">
                <section class="login_content">

                    <form id="loginForm" method="post" action="<?php echo base_url().'Usuarios/logar'?>">
                        <h1>Acesso</h1>
                        <div>
							<label for="usuario" class="sr-only">Usuário</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" required />
                        </div>
                        <div>
							<label for="senha" class="sr-only">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required />
                        </div>
                        <div>
                            <input type="submit" class="btn btn-default" value="acessar"/>
                             <p class="change_link">Alterar sua senha?
                                <a href="#signup" class="red to_register"> Clique aqui. </a>
                           </p>
                             
                            <!--<a class="reset_pass" href="#">Esqueceu sua senha?</a>-->
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="separator">
                        
                           
                         
                            <div class="clearfix"></div>
                            <br />

                            <div>
								<h1><img src="<?php echo base_url()."external/img/enfermeira.png"?>" width="48"</img><?php echo " Clínica Médica" ?> </h1>
                                <p>©<?php echo date('Y')?></p>
                            </div>
                        </div>
                       
                    </form>
                </section>
            </div>
            
            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form id="" method="post" action="<?php echo base_url().'Usuarios/alterarSenha'?>">
                        <h1>Alterar Senha</h1>
                        <div>
                            <input type="text" class="form-control" name="usuario" placeholder="Usuário" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="senhaatual" placeholder="Senha Atual" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="novasenha" placeholder="Senha Nova" required="" />
                        </div>
                        <div>
                            <input type="submit" class="btn btn-default" value="Alterar"/>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">
                                <a href="#signin" class="to_register"> Voltar ao Login </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fas fa-chalkboard-teacher"></i><?php echo " Clínica Médica"?> </h1>
                                <p>©<?php echo date('Y')?></p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            
        </div>
    </div>
</body>