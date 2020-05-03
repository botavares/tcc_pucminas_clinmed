$(document).ready(function($){
	verificarPlanos();
	verificarResponsaveis();
	verificarAntecedentesFamiliares();
	verificarUsodeMedicamentos();
	verificarAlergiaMedicamentos();
	verificarFezCirurgias();
	verificarAtividadesFisicas();
	verificarAlimentosEvitados();
	
	
	/*-----------------------------------
	MASCARAS PARA CAMPOS DE FORMULÁRIOS
	-----------------------------------*/
	$('.telfixo').inputmask({"mask": "(99) 9999-9999","placeholder":""});
	$('.telcelular').inputmask({"mask": "(99) 9 9999-9999","placeholder":""});
	$(".telefones").inputmask({mask: ['(99) 9999-9999','(99) 9 9999-9999'], keepStatic: true,placeholder: '' });
	$('.cep').inputmask({"mask": "99999-999","placeholder":""});
	$(".input-data").mask("99/99/9999",{placeholder:""});
	$('.cpf').inputmask({"mask": "999.999.999-99","placeholder":""});
	$('.crm').inputmask({"mask": "999999999","placeholder":""});
	$(".horas").inputmask("99:99",{ "placeholder": "" });
	$(".pressao").inputmask("99/99",{ "placeholder": "" });
	$(".dinheiro").inputmask('decimal', {
		'alias': 'numeric',
		'groupSeparator': '.',
		'autoGroup': true,
		'digits': 2,
		'radixPoint': ",",
		'digitsOptional': false,
		'allowMinus': false,
		'prefix': 'R$ ',
		'placeholder': ''
    });
	
	$('#porta-mensagem').delay(3000).fadeOut(300);
	
	/*===============================================================
	COLOCAR MENSAGEM NO CAMPO FILE
	===============================================================*/
	$('.fupload').html('<b>Arquivo Selecionado:</b>');
	$('#postarArquivo').change(function() {
         $('.fupload').html('<b>Arquivo Selecionado:</b>' + $(this).val());
    });
	/*===============================================================
	MODAL QUE EXIME MENSAGEM DE ERRO
	===============================================================*/
	function exibirModalErro($descErro, $tipoMensagem,$mensagem){
		$("#modalErros").modal({ backdrop: 'static' });
		$("#nome-erro").html($descErro);
		var icone;
		if($tipoMensagem == "advert") {
			icone ="<i class=' amarelo fas fa-exclamation-circle fa-2x'></i>";	
		}else{
			icone ="<i class=' red fas fa-exclamation-circle fa-2x'></i>"
		}
		
		$("#descricao-erro").html(icone + " "+$mensagem);
	}
	
	
	$(".validarCPF").on('blur', function () {
		var exp = /\.|\-/g;
		var cpf = $('.cpf').val().replace(exp,'').toString();
		if(cpf.length == 11 ){	
			var v = [];
			//Calcula o primeiro dígito de verificação.
			v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
			v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
			v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
			v[0] = v[0] % 11;
			v[0] = v[0] % 10;

			//Calcula o segundo dígito de verificação.
			v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
			v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
			v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
			v[1] = v[1] % 11;
			v[1] = v[1] % 10;

			//Retorna Verdadeiro se os dígitos de verificação são os esperados.

			  if ((v[0] != cpf[9]) || (v[1] != cpf[10])) {
				  exibirModalErro("CPF inválido","advert","Verifique os números do CPF.");
				  setTimeout(function() { $(".validarCPF").focus() }, 150);
			  }else if (cpf[0] == cpf[1] && cpf[1] == cpf[2] && cpf[2] == cpf[3] && cpf[3] == cpf[4] && cpf[4] == cpf[5] && cpf[5] == cpf[6] && cpf[6] == cpf[7] && cpf[7] == cpf[8] && cpf[8] == cpf[9] && cpf[9] == cpf[10]){
				  exibirModalErro("CPF inválido","advert","Verifique os números do CPF.");
				  setTimeout(function() { $(".validarCPF").focus() }, 150);
			  }       
    	}else {
			exibirModalErro("CPF inválido","advert","Verifique os números do CPF.");
			setTimeout(function() { $(".validarCPF").focus() }, 150);
		}
	});
	

	
	/*===============================================================
	//LIMPAR DADOS DE MODAL ASSIM QUE FECHÁ-LOS
	===============================================================*/
	$('.modal').on('hidden.bs.modal', function () {
		$(this).find("input,textarea,select").val('').end();
		$(this).find(".labelData").html('').end();
		$(this).find(".horarios").html('').end();
		$(this).find("#modalAgendarConsulta").html('').end();
		$(this).find(".diaConsultas").html('').end();
		$(this).find(".tbody-desvincular").html('').end();
	});
	/*====================================================================================
	//QUANDO SAIR DA TELA DE CONSULTA PARA MENU LATERAL PERGUNTAR SE QUER FECHAR CONSULTA
	====================================================================================*/
	$("#sidebar-menu").on('mouseenter', function(event){
		event.preventDefault();
		$("#modalEncerraConsulta").modal({ backdrop: 'static' });
	});
	/*====================================================================================
	//HORARIOS DE ATENDIMENTO DO MÉDICO. VERIFICAR SE A SAIDA MATUTINA É MENOR QUE 12:00
	====================================================================================*/
	$("#saida-matutino").on('blur',function(){
		// Suponhamos que as variáveis time1 e time2 vêm de um input qualquer
		var hora1 = '12:00';
		var hora2 = $(this).val();

		var data1 = new Date('2020-01-01 ' + hora1);
		var data2 = new Date('2020-01-01 ' + hora2);

		if (data1.getTime() < data2.getTime()) {
			$("#saida-matutino").val("12:00");
		}
	})
	
	/*====================================================================================
	//HORARIOS DE ATENDIMENTO DO MÉDICO. VERIFICAR SE A ENTRADA VESPERTINA É MENOR QUE 12:00
	====================================================================================*/
	$("#entrada-vespertino").on('blur',function(){
		// Suponhamos que as variáveis time1 e time2 vêm de um input qualquer
		var hora1 = '12:00';
		var hora2 = $(this).val();

		var data1 = new Date('2020-01-01 ' + hora1);
		var data2 = new Date('2020-01-01 ' + hora2);

		if (data1.getTime() > data2.getTime()) {
			$("#entrada-vespertino").val("12:00");
		}
		
	
	})
	/*=======================================================
	Verificar se cargos possui crm para isolar os campos de 
	crm e especialidades apenas para médicos
	=======================================================*/
	$('#input-cargo').on('change', function(){
		var codigo = $(this).val();
		$.ajax({
			type: "POST",				
			url: path + "Cargos/listarJSON",
			DataType: 'json',					
			data:{id:codigo},
				success: function(e){
					var obj = $.parseJSON(e);
					$.each(obj, function(key, value){
						var a 	= value.ds_registro_conselho;
						if(a != 1){
							$("#grupoCrm").hide();
							$("#input-crm").val('');
							$("#grupoEspecialidade").hide();
							$("#input-especialidade").val('');
						}else{
							$("#grupoCrm").show();
							$("#grupoEspecialidade").show();
						}
					});
				}
		});		
	});
	
	
	if($("#input-crm").val()==""){
		$("#grupoCrm").hide();
		$("#grupoEspecialidade").hide();
	}else{
		$("#grupoCrm").show();
		$("#grupoEspecialidade").show();
	}
	
	/*============================================================
	CADASTRO DE PACIENTES
	=============================================================*/
	function verificarPlanos(){
		if($("#input-planoSaude1").is(":checked") == true){
			$(".boxPlanoSaude").show();
		}else{
			$(".boxPlanoSaude").hide();	
		}
	}
	function verificarResponsaveis(){
		if($("#input-responsavel1").is(":checked") == true){
			$(".boxResponsavel").show();
		}else{
			$(".boxResponsavel").hide();	
		}
	}
	$(".planoSaude").on("click",function(){
		verificarPlanos();	
	});

	$(".responsavel").on("click",function(){
		verificarResponsaveis();	
	});
	
	/*=======================================================
	CONSULTAS MÉDICAS
	=======================================================*/
	function verificarAntecedentesFamiliares(){
		if($("#outrosAntecedentesSim").is(":checked") == true){
			$(".boxAntecedentesFamiliares").show();
		}else{
			$(".boxAntecedentesFamiliares").hide();	
		}
	}
	
	function verificarUsodeMedicamentos(){
		if($("#usoMedicamentosSim").is(":checked") == true){
			$(".boxUsoMedicamentos").show();
		}else{
			$(".boxUsoMedicamentos").hide();	
		}
	}
	
	function verificarAlergiaMedicamentos(){
		if($("#alergiaMedicamentoSim").is(":checked") == true){
			$(".boxAlergiaMedicamentos").show();
		}else{
			$(".boxAlergiaMedicamentos").hide();	
		}
	}
	function verificarFezCirurgias(){
		if($("#fezCirurgiaSim").is(":checked") == true){
			$(".boxCirurgias").show();
		}else{
			$(".boxCirurgias").hide();	
		}
	}
	
	function verificarAtividadesFisicas(){
		if($("#atividadeFisicaSim").is(":checked") == true){
			$(".boxAtividadesFisicas").show();
		}else{
			$(".boxAtividadesFisicas").hide();	
		}
	}
	
	function verificarAlimentosEvitados(){
		if($("#restricaoAlimentoSim").is(":checked") == true){
			$(".boxAlimentosEvitados").show();
		}else{
			$(".boxAlimentosEvitados").hide();	
		}
	}
	
	$(".antecedentesFamiliares").on("ifChecked",function(){
		verificarAntecedentesFamiliares();	
	});
	
	$(".usoMedicamento").on("ifChecked",function(){
		verificarUsodeMedicamentos();	
	});
	
	$(".alergiaMedicamentos").on("ifChecked",function(){
		verificarAlergiaMedicamentos();	
	});
	$(".fezCirurgias").on("ifChecked",function(){
		verificarFezCirurgias();	
	});
	$(".atividadesFisicas").on("ifChecked",function(){
		verificarAtividadesFisicas();	
	});
	
	$(".alimentosEvitados").on("ifChecked",function(){
		verificarAlimentosEvitados();	
	});
	
	$('#input-expedeExames').on('click', function(){
		var numeroConsulta = $(this).attr('data-id')
		
		$.ajax({
			type: "POST",				
			url: path + "Consultas/verificarNumeroConsulta",
			DataType: 'json',				
			data:{numeroConsulta:numeroConsulta},
			success: function(data){
				var obj = $.parseJSON(data);
				$.each(obj, function(key, value){
					var r	=	value.retorno;
					if(r == 'false'){
						$("#modalErros").modal({ backdrop: 'static' });
						$("#nome-erro").html("Consulta não gravada.");
						var icone ="<i class=' amarelo fas fa-exclamation-circle fa-2x'></i>"
						$("#descricao-erro").html(icone + "  A consulta ainda não foi gravada!");
					}else{
						$("#modalExpedirExames").modal({ backdrop: 'static' });
						$("#numeroConsulta").val(numeroConsulta);
					}
				});
			}
		});	
	});
	
	$('#input-prescreveMedicamentos').on('click', function(){
		var numeroConsulta = $(this).attr('data-id')
		
		$.ajax({
			type: "POST",				
			url: path + "Consultas/verificarNumeroConsulta",
			DataType: 'json',				
			data:{numeroConsulta:numeroConsulta},
			success: function(data){
				var obj = $.parseJSON(data);
				$.each(obj, function(key, value){
					var r	=	value.retorno;
					if(r == 'false'){
						$("#modalErros").modal({ backdrop: 'static' });
						$("#nome-erro").html("Consulta não gravada.");
						var icone ="<i class=' amarelo fas fa-exclamation-circle fa-2x'></i>"
						$("#descricao-erro").html(icone + "  A consulta ainda não foi gravada!");
					}else{
						$("#modalPrescreverReceitas").modal({ backdrop: 'static' });
						$("#numeroConsulta").val(numeroConsulta);
					}
				});
			}
		});	
	});
	
	/*===============================================
		ATENDIMENTO / RECEPÇÃO
	=================================================*/
	
	$("#boxCpfRetorno").hide();
	$('#tipoAtendimento').on('change', function(){
		if($(this).val()==2){
			$("#boxCpfRetorno").show();
			setTimeout(function() { $("#cpfRetorno").focus() }, 150);
		}else{
			$("#boxCpfRetorno").hide();
		}
	});
	
	$('#cpfRetorno').on('blur', function(){
		var codigo = $(this).val();
		$.ajax({
			type: "POST",				
			url: path + "Recepcao/listarUltimaConsultaAtiva",
			DataType: 'json',					
			data:{cpf:codigo},
				success: function(e){
					var obj = $.parseJSON(e);
					$.each(obj, function(key, value){
						var a 	= value.fk_id_cliente;
						var b 	= value.ds_numero_consulta;
						
						var r	= value.retorno
						var mensagem;
						if(r == "naoJson"){
							mensagem = "CPF não está vinculado a nenhuma consulta ativa!";
						}
						if(r == "naoCliente"){
							mensagem = "Cliente não encontrado!";
						}
						if(r != "naoJson" || r != "naoCliente"){
							$("#idClienteRetorno").val(a);
							$("#idConsultaRetorno").val(b);
						}
						
						
						
						if(r == "naoJson" || r == "naoCliente"){
							$("#modalNaoVincular").modal({ backdrop: 'static' });
							$("#modal-aviso").text(mensagem);
							$('#modalNaoVincular').on('hidden.bs.modal', function () {
								setTimeout(function() { $("#tipoAtendimento").focus() }, 150);
								$("#tipoAtendimento").val(1).attr('selected','selected');
								$("#cpfRetorno").val("");
								$("#boxCpfRetorno").hide();
							})
							
							
							
						}
						
					});
				}
		});
	});
/*===================================================
CARREGAR DADOS DE CARGOS PARA EDIÇÃO
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemCargos",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Cargos/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a 	= value.pk_id_cargo;
							var b 	= value.ds_nome_cargo;
							var c 	= value.ds_ativar_agenda;
							var d 	= value.ds_registro_conselho;
							var r 	= value.retorno;
							if(r != 'false'){
								$("#modalEditCargos").modal({ backdrop: 'static' });
								$("#edit-id").val(a);
								$("#edit-nome").val(b);
								$("#edit-dependeAgenda").val(c).attr('selected','selected');
								$("#edit-registro").val(d).attr('selected','selected');
							}else{
								exibirModalErro("Não encontrado","erro","Dados do cargo não encontrado.");
								
						    }
						});
					}
		});
	});
	
	
	$("#datatable-fixed-header").on("click",".editItemEspecialidades",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Especialidades/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a 	= value.pk_id_especialidade;
							var b 	= value.ds_nome_especialidade;
							var r	= value.retorno;
							if(r != 'false'){
								$("#modalEditEspecialidades").modal({ backdrop: 'static' });
								$("#edit-id").val(a);
								$("#edit-nome").val(b);
							}else{
								exibirModalErro("Não encontrado","erro","Dados da especialidade não encontrado.");
								
						    }
						});
					}
		});
	});
	
	
	$("#datatable-fixed-header").on("click",".editItemPlanosSaude",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "PlanosSaude/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a 	= value.pk_id_plano;
							var b 	= value.ds_nome_plano;
							var c 	= value.ds_numero_ans;
							var d 	= value.ds_telefone;
							var r 	= value.retorno;
							if(r != 'false'){
								$("#modalEditPlanosSaude").modal({ backdrop: 'static' });
								$("#edit-id").val(a);
								$("#edit-nome").val(b);
								$("#edit-numeroAns").val(c);
								$("#edit-telefone").val(d);
							}else{
								exibirModalErro("Não encontrado","erro","Plano de Saúde não encontrado.");
						    }
						});
					}
		});
	});
	
	$("#datatable-fixed-header").on("click",".vincularPlanoSaude",function(){
		var codigo = $(this).attr('data-id');
		
		$.ajax({
			data:{codigo:codigo},
			success: function(data){
				$("#modalVincularPlanos").modal({ backdrop: 'static' });
				$("#idMedico").val(codigo);
			}
		});			 
	});
	
	$("#datatable-fixed-header").on("click",".desvincularPlanoSaude",function(){
		var codigo = $(this).attr('data-id');
		
		$.ajax({
			type: "POST",				
				url: path + "PlanosSaude/encontrarMedicosPlanos",
				DataType: 'json',					
				data:{id:codigo}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						//$.each(obj, function(){
							
							$.each(obj, function(key, value){
								var a 	= obj[key].pk_id_plano;
								var b 	= obj[key].ds_nome_plano;
								var c 	= obj[key].pk_id_medicosplanos;
								var r 	= value.retorno;
								
								if(r != 'false'){
									$("#modalDesvincularPlanoSaude").modal({ backdrop: 'static' });
									$(".tbody-desvincular").append(
										"<tr class='even pointer'>"+
											"<td class='a-center'>"+
												"<input type='checkbox' id='input-plano"+a+"'"+ "name='idPlano[]' class='flat form-control'"+
													"value="+"'"+c+"'"+">"+
											"</td>"+
											"<td class='a-center'>"+
												b +
											"</td>"+
										"</tr>"
									);
								}else{
									$("#modalErros").modal({ backdrop: 'static' });
									$("#nome-erro").html("Sem Planos de Saúde.")
									var icone ="<i class=' red fas fa-exclamation-circle fa-2x'></i>"
									$("#descricao-erro").html(icone + "  Não encontrei planos de saúde vinculados a esse médico.")
								}
							});
							
						//});
					}
		});			 
	});
	$('#modalDesvincularPlanoSaude').on('hidden.bs.modal', function () {
		$(".tbody-desvincular").append("");
	});
	
	

/*===================================================
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemProfissionais",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Profissionais/listarProfissionaisJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a = value.pk_id_profissional;
							var b = value.ds_nome_profissional;
							var c = value.fk_id_cargo;
							var d = value.ds_cpf;
							var e = value.ds_crm;
							var f = value.ds_cep;
							var g = value.ds_logradouro;
							var h = value.ds_numresidencia;
							var i = value.ds_complemento;
							var j = value.ds_bairro;
							var k = value.ds_telfixo;
							var l = value.ds_telcel;
							var m = value.ds_email;
							var n = value.fk_id_especialidade;
							var o = value.ds_sexo;
							var r = value.retorno;
							if(r != 'false'){
								$("#modalEditProfissionais").modal({ backdrop: 'static' });
								$("#input-id").val(a);
								$("#input-nome").val(b);
								$("#input-cargo").val(c).attr('selected','selected');
								$("#input-cpf").val(d);
								$("#input-crm").val(e);
								$("#input-cep").val(f);
								$("#input-logradouro").val(g);
								$("#input-numero").val(h);
								$("#input-complemento").val(i);
								$("#input-bairro").val(j);
								$("#input-telfixo").val(k);
								$("#input-telcel").val(l);
								$("#input-email").val(m);
								$("#input-especialidade").val(n).attr('selected','selected');
								$("#input-sexo").val(o).attr('selected','selected');
							}else{
								exibirModalErro("Não encontrado!","erro","Profissional não encontrado.");
							}
						});
					}
		});
	});
	/*===================================================
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemClientes",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Clientes/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a = value.pk_id_cliente;
							var b = value.ds_nome_cliente;
							var c = value.ds_cpf_cliente;
							var d = value.ds_responsavel_cliente;
							var e = value.ds_nome_responsavel;
                            var f = value.ds_cpf_responsavel;
                            var g = value.ds_cep;
							var h = value.ds_logradouro;
							var i = value.ds_numresidencia;
							var j = value.ds_complemento;
							var k = value.ds_bairro;
							var l = value.ds_telfixo;
							var m = value.ds_telcel;
                            var n = value.ds_email;
                            var o = value.ds_plano_saude;
                            var p = value.ds_nome_plano;
                            var q = value.ds_numero_plano;
							var r = value.retorno;
							var s = value.ds_sexo_cliente;
							var t = value.ds_nascimento_cliente
							
							var splitData = t.split('-');
							var nascimento = splitData[2]+'/'+splitData[1]+'/'+splitData[0];
							
							if(r != 'false'){
								$("#modalEditClientes").modal({ backdrop: 'static' });
								$("#input-id").val(a);
								$("#input-nomeCliente").val(b);
								$("#input-sexo").val(s).attr('selected','selected');
								$("#input-nascimento").val(nascimento);
								$("#input-cpfCliente").val(c);
                                
								if (d == 1){
                                    $('.boxResponsavel').show();
                                    $('#input-responsavel1').prop('checked',true);
                                }else{
									$('.boxResponsavel').hide();
                                    $('#input-responsavel2').prop('checked',true);
								}
								
								
								$("#input-nomeResponsavel").val(e);
								$("#input-cpfResponsavel").val(f);
								$("#input-cep").val(g);
								$("#input-logradouro").val(h);
								$("#input-numero").val(i);
								$("#input-complemento").val(j);
								$("#input-bairro").val(k);
								$("#input-telfixo").val(l);
								$("#input-telcel").val(m);
                                $("#input-email").val(n);
                                if (o == 1){
                                    $('.boxPlanoSaude').show();
									$('#input-planoSaude1').prop('checked',true);
								}else{
									$('.boxPlanoSaude').hide();
									$('#input-planoSaude2').prop('checked',true);
								}
                               
                                $("#input-nomePlano").val(p).attr('selected','selected');
                                $("#input-numeroPlano").val(q);
							}else{
								exibirModalErro("Não encontrado!","erro","Cliente não encontrado.");
							}
						});
					}
		});
	});
	
	
	
	/*===================================================
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemMedicamentos",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Medicamentos/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a = value.pk_id_medicamento;
							var b = value.ds_nome_generico;
							var c = value.ds_nome_medicamento;
							var d = value.ds_apresentacao;
							var e = value.ds_posologia;
							var f = value.ds_restricoes;
							var g = value.fk_id_classe;
							var h = value.fk_id_fabricante;
							var i = value.fk_id_especialidade;
							
							var r = value.retorno;
							if(r != 'false'){
								$("#modalEditMedicamentos").modal({ backdrop: 'static' });
								$("#edit-id").val(a);
								$("#edit-nomeGenerico").val(b);
								$("#edit-nomeMedicamento").val(c);
								$("#edit-apresentacao").val(d);
								$("#edit-posologia").val(e);
								$("#edit-restricoes").val(f);
								$("#edit-classe").val(g).attr('selected','selected');
								$("#edit-especialidade").val(i).attr('selected','selected');
								$("#edit-fabricante").val(h).attr('selected','selected');
							}else{
								exibirModalErro("Não encontrado!","erro","Medicamento não encontrado.");
							}
						});
					}
		});
	});
	
	/*===================================================
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemUsuarios",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "Usuarios/listarJSON",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a = value.pk_id_usuario;
							var b = value.fk_id_profissional;
							var c = value.ds_nome_usuario;
							var d = value.ds_nivel;
							var e = value.ds_nome_profissional;
							var r = value.retorno;
							
							if(r != "false"){
								
								$("#modalEditUsuarios").modal({ backdrop: 'static' });
								$("#edit-id").val(a);
								$("#edit-idProfissional").val(b);
								$("#edit-nomeUsuario").val(c);
								$("#edit-nivel").val(d).attr('selected','selected');
								$("#edit-nomeProfissional").val(e);
							}else{
								$("#modalErros").modal({ backdrop: 'static' });
								$("#nome-erro").html("Sem Planos de Saúde.")
								var icone ="<i class=' red fas fa-exclamation-circle fa-2x'></i>"
								$("#descricao-erro").html(icone + "  Não encontrei dados desse usuário.");
							}
						});
					},
					
		});
	});
	
	/*===================================================
=====================================================*/
	$("#datatable-fixed-header").on("click",".editItemDiasAtendimento",function(){
		var corte = $(this).attr('data-id').split('|');
		
		var codMedico = corte[0];
		var diaSemana = corte[1];
		
		$.ajax({						
				type: "POST",				
				url: path + "DiasAtendimento/listarDiasAtendimento",
				DataType: 'json',					
				data:{id:codMedico,dia:diaSemana}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a 	= 	value.pk_id_diasatendimento;
							var b 	= 	value.pk_id_profissional;
							var c 	= 	value.ds_dia_semana;
							var d 	= 	value.ds_turno_atendimento;
							var e	=	value.ds_nome_profissional;
							var r 	= 	value.retorno;
							if(r != 'false'){
								var dia ="";
								switch(c){
									case '1':
										dia = "Segunda-feira";
										break;
									case '2':
										dia = "Terça-feira";
										break;
									case '3':
										dia = "Quarta-feira";
										break;
									case '4':
										dia = "Quinta-feira";
										break;
									case '5':
										dia = "Sexta-feira";
										break;
									   }
								$("#modalEditDiasAtendimento").modal({ backdrop: 'static' });
								$("#input-id").val(a);
								$("#input-medico").val(b);
								$("#input-diaSemana").val(c)
								$("#input-nomeDia").val(dia)
								$("#input-turno").val(d).attr('selected','selected');
								$("#input-nome").val(e);
							}else{
								exibirModalErro("Não encontrado!","erro","Dias de atendimento não encontrado.");
						    }
						});
					}
		});
	});
	
	/*=================================================================
	
	====================================================================*/
	$("#datatable-fixed-header").on("click",".editItemHorariosAtendimento",function(){
		var chavePrimaria = $(this).attr('data-id')
		$.ajax({						
				type: "POST",				
				url: path + "HorariosAtendimento/listarHorariosAtendimento",
				DataType: 'json',					
				data:{id:chavePrimaria}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var a 	= 	value.pk_id_horarios;
							var b 	= 	value.fk_id_profissional;
							var c 	= 	value.ds_horarioini_matutino;
							var d 	= 	value.ds_horariofim_matutino;
							var e 	= 	value.ds_horarioini_vespertino;
							var f 	= 	value.ds_horariofim_vespertino;
							var g 	= 	value.ds_tempo_consulta;
							var h 	= 	value.ds_nome_profissional;
							var r 	= 	value.retorno;
							
							if(r != 'false'){
								$("#modalEditHorariosAtendimento").modal({ backdrop: 'static' });
								$("#input-id").val(a);
								$("#input-medico").val(b);
								$("#input-nome").val(h);
								$("#entrada-matutino").val(c);
								$("#saida-matutino").val(d);
								$("#entrada-vespertino").val(e);
								$("#saida-vespertino").val(f);
								$("#input-tmpConsulta").val(g);
							}else{
								exibirModalErro("Não encontrado!","erro","Horários de atendimento não encontrado.");
						    }
						});
					}
		});
	});

	
	
	
/*===================================================
DISPARAR MODAL PARA A DELEÇÃO DE REGISTROS
===================================================*/
	$("#datatable-fixed-header").on("click",".deleteItem",function(){
		var corte = $(this).attr('data-id').split('|');
		var chavePrimaria = corte[0];
		var nomeItem = corte[1];
		
		$.ajax({
			data:{chavePrimaria:chavePrimaria,nomeItem:nomeItem},
			success: function(data){
				$("#modalDeleteItens").modal({ backdrop: 'static' });
				$("#chavePrimaria").val(chavePrimaria);
				$("#nomeItem").html(nomeItem);
			}
		});			 
		
		
	});

/*===================================================================
DISPARAR MODAL PARA A RECUPERAÇÃO DE REGISTROS DELETADOS LOGICAMENTE
===================================================================*/
	$("#datatable-fixed-header").on("click",".recuperaItem",function(){
		var corte = $(this).attr('data-id').split('|');
		var chavePrimaria = corte[0];
		var nomeItem = corte[1];
		
		$.ajax({
			data:{chavePrimaria:chavePrimaria,nomeItem:nomeItem},
			success: function(data){
				$("#modalRecuperaItens").modal({ backdrop: 'static' });
				$("#recuperarChavePrimaria").val(chavePrimaria);
				$("#recuperarNomeItem").html(nomeItem);
				
				$("#chaveReativar").val(chavePrimaria);
				$("#nomeReativar").html(nomeItem);
			}
		});			 
		
		
	});
	
	
	/*===========================================================
		Gerar botões com as horas disponíveis para consultas
	============================================================*/
	$('.diaConsultas').on('click', function(){
		var corte = $(this).attr('data-id').split('|');
		var codMedico = corte[0];
		var data = corte[1];
		
		$.ajax({						
				type: "POST",				
				url: path + "Recepcao/consultasDoDia",
				DataType: 'json',					
				data:{codMedico:codMedico,data:data}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							
							var a 	= value.dia;
							var b 	= value.horas;
							var c 	= value.medico;
							$("#modalHorariosAtendimento").modal({ backdrop: 'static' });
							$('.horarios').append('<a class="btn btn-success horaAgendar" data-id="'+a+'|'+b+'|'+c+'" >'+b+'</a>');
							
						});
					}
		});
	});//
	/*==================================================================
		Ao clicar em um horário disponível, abrir modal para agendamento
	================================================================*/
	$('.horarios').on('click','a', function(){
		var corte = $(this).attr('data-id').split('|');
		var a = corte[0];
		var b = corte[1];
		var c = corte[2];
		
		$.ajax({
			data:{dia:a,horas:b,medico:c},
			success: function(data){
				$("#modalHorariosAtendimento").modal('hide');
				$("#modalAgendarConsulta").modal({ backdrop: 'static' });
				$('#modalAgendarConsulta').find(".horarios").html('').end();
				$("#input-diaConsulta").val(a);
				$("#input-horaConsulta").val(b);
				$("#input-idMedico").val(c);
				
				$('#modalAgendarConsulta').on('hidden.bs.modal', function () {
					/*$("#cpfRetorno").blur(function(event){
  						event.preventDefault();
					});*/
				})
				
				
				
			}
		});	
	});
	/*==================================================================
		Abre o modal de CANCELAR, CONFIRMAR ou REMANEJAR consultas
	================================================================*/
	$("#datatable-fixed-header").on("click",".servicoConsulta",function(){
		var corte = $(this).attr('data-id').split('|');
		var a	= corte[0];
		var b	= corte[1];
		var c 	= corte[2];
		var d 	= corte[3];
		var e 	= corte[4];
		$.ajax({
			data:{servico:a,id:b,nome:c,dia:d,hora:e},
			success: function(data){

				if(a==1){
					$("#modalConfirmarConsulta").modal({ backdrop: 'static' });
				}else if(a == 2){
					$("#modalCancelarConsulta").modal({ backdrop: 'static' });
				}

				$(".input-id").val(b);
				$(".label-nome").html(c);
				$(".label-dia").html(d);
				$(".label-hora").html(e);
			}
		});
	});
	
	
	$('#procurarClienteCadastrado').on('click', function(){
		var idAgendamento = $("#idAgendamento").val();
		var cpfCliente = $("#input-cpfCliente").val();
		$.ajax({						
				type: "POST",				
				url: path + "Clientes/listarClientesCpfJSON",
				DataType: 'json',					
				data:{cpf:cpfCliente}, 				
					success: function(s){
						var obj = $.parseJSON(s);
						$.each(obj, function(key, value){
							var a = value.pk_id_cliente;
							var b = value.ds_nome_cliente;
							var r = value.retorno
							if(a > 0){
								$("#modalVincularCliente").modal({ backdrop: 'static' });
								$("#idCliente").val(a);
								$("#idAgendar").val(idAgendamento);
								$("#nomeClienteCadastrado").html(b);
								$("#modalLabel").html("Vincular o cliente ao angedamento?");
								$("#btnVinculos").html("VINCULAR");
							}
							if(r == "false"){
								$("#modalCadastrarCliente").modal({ backdrop: 'static' });
								
							}
						});
					},
		});
	});
	
	
	
	$("#datatable-fixed-header").on("click",".vincularCliente",function(){
		var corte = $(this).attr('data-id').split('|');
		var idAgendamento	= corte[0];
		var nomeCliente		= corte[1];
		var idMedico		= corte[2];
		
		$.ajax({						
			data:{idAgendamento:idAgendamento,nomeCliente:nomeCliente,idMedico:idMedico}, 				
				success: function(data){
					$("#modalVincularCliente").modal('hide');
					$("#modalprocurarClienteCadastrado").modal({ backdrop: 'static' });
					$("#idAgendamento").val(idAgendamento);
					$("#nomeCliente").val(nomeCliente);
					$("#idMedico").val(idMedico);
				}
		});
	});
	
	$("#datatable-fixed-header").on("click",".desvincularCliente",function(){
		var corte = $(this).attr('data-id').split('|');
		var idAgendamento	= corte[0];
		var idCliente		= 0;
		var nomeCliente		= corte[1];
		
		$.ajax({						
			data:{idAgendamento:idAgendamento,nomeCliente:nomeCliente,idCliente:idCliente}, 				
				success: function(data){
					$("#modalVincularCliente").modal({ backdrop: 'static' });
					$("#idAgendar").val(idAgendamento);
					$("#idCliente").val(idCliente);
					$("#nomeClienteCadastrado").val(nomeCliente);
					$("#modalLabel").html("Desvincular o cliente ao angedamento?");
					$("#btnVinculos").html("DESVINCULAR");
				}
		});
	});
	
	$(".tabela-consulta").on("click","#insereResultadoExame",function(){
		var idExame = $(this).attr('data-id');
		$.ajax({						
				type: "POST",				
				url: path + "Exames/consultarExames",
				DataType: 'json',					
				data:{idExame:idExame}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var idPedidoExame	=	value.pk_id_exameconsulta;
							var codExame		=	value.fk_id_exame;
							var nomeExame		=	value.ds_nome_exame;
							var resultado		=	value.ds_resultado_exame;
							var consulta		=	value.ds_numero_consulta;
							var medico				=	value.fk_id_profissional;
							
							$("#modalResultadoExames").modal({ backdrop: 'static' });
							$("#exameNrConsulta").text(consulta);
							$(".numeroConsulta").val(consulta);
							$("#nomeExame").text(nomeExame);
							$("#idPedidoExame").val(idPedidoExame);
							$("#resultadoExame").val(resultado);
							$("#medicoExame").val(medico);
						});
					}
		});
	});
	
	$(".tabela-consulta").on("click","#insereOrientacao",function(){
		var idReceita = $(this).attr('data-id');
		$.ajax({						
				type: "POST",				
				url: path + "Receitas/consultarReceita",
				DataType: 'json',					
				data:{idReceita:idReceita}, 				
					success: function(e){
						var obj = $.parseJSON(e);
						$.each(obj, function(key, value){
							var pkIdReceita			=	value.pk_id_receita_consulta;
							var nomeMedicamento		=	value.ds_nome_generico + " ("+ value.ds_nome_medicamento + ")";
							var orientacao			=	value.ds_posologia;
							var consulta			=	value.ds_numero_consulta;
							var medico				=	value.fk_id_profissional;
							
							$("#modalOrientacao").modal({ backdrop: 'static' });
							$("#nrConsulta").text(consulta);
							$("#numConsulta").val(consulta);
							$("#nomeMedicamento").text(nomeMedicamento);
							$("#idReceita").val(pkIdReceita);
							$("#orientacaoReceita").val(orientacao);
							$("#medicoReceita").val(medico);
							
							
						});
					}
		});
	});
	
	$("#datatable-fixed-header").on("change",".origemRecebimentoExame",function(){
		if($(".origemRecebimentoExame").val() == 1){
			$("#postarArquivo").show();
		}else{
			$("#postarArquivo").hide();
		}
	})
	
	$('#dataFinal').on('blur', function(){
		var dataInicial = $("#dataInicial").val();
		var splitInicial = dataInicial.split('/');
		var novaDataInicial = new Date (splitInicial[2]+'-'+splitInicial[1]+'-'+splitInicial[0]);
		
		var dataFinal = $("#dataFinal").val();
		var splitFinal = dataFinal.split('/');
		var novaDataFinal = new Date (splitFinal[2]+'-'+splitFinal[1]+'-'+splitFinal[0]);
		
		if(novaDataInicial >= novaDataFinal){
			$(".btnRelatorio").prop('disabled',true)
			exibirModalErro("Data errada","advert","Data final é mais antiga que data inicial.");
		}else{
			$(".btnRelatorio").prop('disabled',false)
		}
	});
});