<?php
$controler = "Consultas";
$anoAtual = date('Y');
$refer =  base_url()."Home/iniciar/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Controle de recebimentos de exames</h2>
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
			
			<table id="datatable-fixed-header" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php
							for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
						?>
						<th ><?php echo $titulosTabela[$i]?></th>
						<?php 
							}
						?>
						<th>Postar arquivo do exame</th>
						<th>Registrar recebimento</th>
						
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($examesAbertos as $exameAberto){?>
					<tr>
						<form class="form-horizontal" method="POST" action="<?php echo base_url().'Exames/registrarRecebimentoExame'?>"  enctype="multipart/form-data">
							<input type="hidden" name="numeroConsulta" value="<?php echo $exameAberto['ds_numero_consulta']?>">
							<input type="hidden" name="idPaciente" value="<?php echo $exameAberto['fk_id_cliente']?>">
							<input type="hidden" name="idMedico" value="<?php echo $exameAberto['fk_id_profissional']?>">
							<input type="hidden" name="dataRecebimento" value="<?php echo date("Y-m-d") ?>">
							
							
							<td class="red" align="center"><?php echo $exameAberto['ds_numero_consulta']?></td>
							<td><?php echo $exameAberto['ds_nome_cliente']?></td>
							<td align="center"><?php echo date("d/m/Y",strtotime($exameAberto['ds_data_consulta']))?></td>
							<td align="center">
								<select  class="form-control origemRecebimentoExame" name="origemRecebimento" >
									<option value="1">Email</option>
									<option value="2">Entrega direta do laboratório</option>
									<option value="3">pelo próprio paciente</option>
								</select>
							</td>
							<td id="colunaArquivos">
          								<input type="file" id="postarArquivo" class="fupload form-control" name="postarArquivo">
							</td>
							<td align="center"><button type="submit" class="btn btn-success">Registrar recebimento</button></td>
						</form>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
			<h2>Atenção:</h2>
			<p>
				Conforme preceitua o Código de Ética Médica (Resolução CFM nº. 1.246/88), nos seus artigos n°. 102 e 108:
			</p>
			<p>
				<i>
					É vedado ao médico:<br>
			        Artigo n°. 102 – Revelar fato de que tenha conhecimento em virtude do exercício de sua profissão, salvo por justa causa, dever legal ou autorização expressa do paciente.
				</i>
			</p>
			<p>
				<i>
					É vedado ao médico:<br>
					Artigo n°. 108 – <span class="red">Facilitar o manuseio</span> e conhecimento dos prontuários, papeletas e demais folhas de observações médicas sujeitas ao segredo profissional, <span class="red">por pessoas não obrigadas ao mesmo compromisso</span>.
				</i>
			</p>
			<p>
					Portanto, informações referentes a exames dos pacientes cabe somente ao médico ter acesso de forma física e/ou digital através de emails ou outro tipo de comunicação eletrônica.
			</p>
		</div>
	</div>
</div>