$(function(){
    // Captura o url pelo meta base
    var page = $('meta[name=base]').attr('content');

    //ABRIR MODAL
    $(".open_modal").click(function(){
        $(".modal").fadeIn(400);
        $(".modal").css("display", "flex");
    });
	
    //FECHA MODAL
    $(".modal-close").click(function(){
        $(".modal").fadeOut(10);
        $(".new").fadeOut(10);
        $(".delete").fadeOut(10);
    });
	
	//FECHA MODAL CATEGORY
    $(".modal-close-cat").click(function(){
        $(".category").fadeOut(10);
    });

    //FECHA NOTIFICAÇÕES
    $(".open_notification").click(function(){
        $(".notification-container").fadeIn(400);
        $(".notification-container").css("display", "flex");
    });
    //FECHA MODAL
    $(".notification-close").click(function(){
        $(".notification-container").fadeOut(400);
    });

	//LIMPA FORMULÁRIO DO CEP
	function limpa_formulario_cep() {
		// Limpa valores do formulário de cep.
		$(".address").val("");
		$(".neighborhood").val("");
		$(".city").val("");
		$(".state").val("");
	}
   //CEP AUTOMÁTICO - VIA CEP
   $(".zipcode").blur(function() {
       var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

               //Consulta o webservice viacep.com.br/
				$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

					if (!("erro" in dados)) {
						//Atualiza os campos com os valores da consulta.
						$(".address").val(dados.logradouro);
						$(".neighborhood").val(dados.bairro);
						$(".city").val(dados.localidade);
						$(".state").val(dados.uf);
					} //end if.
					else {
						//CEP pesquisado não foi encontrado.
						limpa_formulario_cep();
						
					}
				});

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
              
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
	});

	//Relatórios, se período for selecionado mostra os campos com as datas inicial e FinalizationRegistry
	$("#type").change(function(){
        
		var selected = $('#type').val();
		
		if(selected == 5){
			$(".date").css('display', 'block');
		}else{
			$(".date").css('display', 'none');
		}
		
	});
	
	//CPF ou CNPJ
	$("#doc").click(function(){
		
		var selected = $(this).val();
		
		if(selected == 1 || selected == 'n'){
			$(".cpf").css('display', 'block');
			$(".cnpj").css('display', 'none');
		}else{
			$(".cnpj").css('display', 'block');
			$(".cpf").css('display', 'none');
		}
		
	});
    //Abre a modal do editar cliente
    $(document).on('click', '.editClient', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        $('.modal').css('display', 'flex');
        $('#client_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Usuarios/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar clientes"
                $('#client').val(data['client']);
                $('#email').val(data['email']); 
                $('#phone').val(data['phone']); 
                $('#zipcode').val(data['zipcode']); 
                $('#address').val(data['address']); 
                $('#number').val(data['number']);
                $('#neighborhood').val(data['neighborhood']); 
                $('#city').val(data['city']); 
                $('#state').val(data['state']);
                // Trabalhar com o doc
                if(data['doc'] == 1){
                    $("#cpf").val(data['document']);
                    $("#doc").html('<option	value="1" selected>CPF</option><option value="2">CNPJ</option>');
                    $('.cpf').css('display', 'block');
                    $('.cnpj').css('display', 'none');
                } else {
                    $("#cnpj").val(data['document']);
                    $("#doc").html('<option	value="2" selected>CNPJ</option><option value="1">CPF</option>');
                    $('.cpf').css('display', 'none');
                    $('.cnpj').css('display', 'block');
                }
            }
        }); 
    });
	//Abre a modal do editar Usuario
	$(document).on('click', '.editUser', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        $('.modal').css('display', 'flex');
        $('#user_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Usuarios/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',   
            data: value,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar clientes"
                $('#username').val(data['user']);
                $('#useremail').val(data['email']);
                // Trabalhar com o level
                $usuarios_level = parseInt(data.level, 10);
                switch($usuarios_level){
                    case 10:
                    $("#userlevel").html('<option	value="1">Operador</option><option value="2">Estoquista</option><option	value="9">Administrador</option><option value="10" selected>Super Administrador</option>');
                    break;
                    case 9:
                    $("#userlevel").html('<option   value="1">Operador</option><option value="2">Estoquista</option><option	value="9" selected>Administrador</option><option value="10">Super Administrador</option>');
                    break;
                    case 2:
                    $("#userlevel").html('<option	value="1">Operador</option><option value="2" selected>Estoquista</option><option	value="9">Administrador</option><option value="10">Super Administrador</option>');
                    break;
                    default:
                    $("#userlevel").html('<option	value="1" selected>Operador</option><option value="2">Estoquista</option><option	value="9">Administrador</option><option value="10">Super Administrador</option>');
                    break;
                }
            }
        }); 
    });

	//Abre a modal do remover usuário
	$(".deleteUser").click(function(){
		$('.delete').css('display', 'flex');
	});
	
	//Abre a modal do novo usuário
	$(".newUser").click(function(){
		$('.new').css('display', 'flex');
	});
		
	//Abre a modal do editar cliente
	$(document).on('click', '.editClient', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        $('.modal').css('display', 'flex');
        $('#client_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Clientes/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar clientes"
                $('#client').val(data['client']);
                $('#email').val(data['email']); 
                $('#phone').val(data['phone']); 
                $('#zipcode').val(data['zipcode']); 
                $('#address').val(data['address']); 
                $('#number').val(data['number']);
                $('#neighborhood').val(data['neighborhood']); 
                $('#city').val(data['city']); 
                $('#state').val(data['state']); 
                // Trabalhar com o doc
                if(data['doc'] == 1){
                    $("#cpf").val(data['document']);
                    $("#doc").html('<option	value="1" selected>CPF</option><option value="2">CNPJ</option>');
                    $('.cpf').css('display', 'block');
                    $('.cnpj').css('display', 'none');
                } else {
                    $("#cnpj").val(data['document']);
                    $("#doc").html('<option	value="2" selected>CNPJ</option><option value="1">CPF</option>');
                    $('.cpf').css('display', 'none');
                    $('.cnpj').css('display', 'block');
                }
            }
        });
    });
    
	//Abre a modal do remover usuario
	$(document).on('click', '.deleteUser', function(e){
        e.preventDefault();
		$('.delete').css('display', 'flex');
        var value = $('.deleteUser').attr('data-id');
        $('.removeUser').attr('data-id', value);
	});
    //Abre a modal do remover cliente
    $(document).on('click', '.deleteClient', function(e){
        e.preventDefault();

        $('.delete').css('display', 'flex');
        var value = $('.deleteClient').attr('data-id');
        $('.removeClient').attr('data-id', value);
    });
	//Abre a modal do novo cliente
	$(".newClient").click(function(){
		$('.new').css('display', 'flex');
	});
	
	
	//Abre a modal do editar fornecedor
    $(document).on('click', '.editProvider', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        $('.modal').css('display', 'flex');
        $('#provider_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Fornecedores/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar fornecedores"
                $('#provider_id').val(data['provider_id']);
                $('#company').val(data['nome']);
                $('#email').val(data['email']); 
                $('#phone').val(data['phone']); 
                $('#zipcode').val(data['zipcode']); 
                $('#address').val(data['address']); 
                $('#number').val(data['number']);
                $('#neighborhood').val(data['neighborhood']); 
                $('#city').val(data['city']); 
                $('#state').val(data['state']); 
                $("#cnpj").val(data['document']);                    
            }
        });
    });
	
	//Abre a modal do remover fornecedor
	$(document).on('click', '.deleteProvider', function(e){
        e.preventDefault();
		$('.delete').css('display', 'flex');
        var value = $('.deleteProvider').attr('data-id');
        $('.removeProvider').attr('data-id', value);
	});
	
	//Abre a modal do novo fornecedor
	$(".newProvider").click(function(){
		$('.new').css('display', 'flex');
	});
	
	
	//Abre a modal do nova categoria
	$(".newCategory").click(function(){
		$('.category').css('display', 'flex');
	});
	
	//Abre a modal do editar produto
	$(document).on('click', '.editProduct', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        $('.modal').css('display', 'flex');
        $('#product_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Produtos/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar fornecedores"
                $('#product_id').val(data[0]['product_id']);
                $('#productEdit').val(data[0]['product']);
                $('#quantityEdit').val(data[0]['quantity']); 
                $('#priceEdit').val(data[0]['price']);         
                
                //Para limpar o select
                $('#categoryEdit').html('');
                for(var i in data){
                    if(data[i]['category_id'] == data[0]['product_category']){
                        var options = "<option value='"+ data[i]['category_id'] + "'selected>" + data[i]['category'] + "</option>"; 
                        $('#categoryEdit').prepend(options); 
                    }else{
                        var options = "<option value='"+ data[i]['category_id'] + "'>" + data[i]['category'] + "</option>"; 
                        $('#categoryEdit').prepend(options); 
                    }
                }
            }
        });
    });
	
	//Abre a modal do remover produto
    $(document).on('click', '.deleteProduct', function(e){
        e.preventDefault();

        $('.delete').css('display', 'flex');
        var value = $('.deleteProduct').attr('data-id');
        $('.removeProduct').attr('data-id', value);
    });
	
	//Abre a modal do novo produto
	$(".newProduct").click(function(){
		$('.new').css('display', 'flex');
	});
	
	
	//Abre a modal do editar pedidos
	$("body").on('click', '.editOrder', function(e){
		e.preventDefault();
        $('.modal_Order').css('display', 'flex');
        var value = $(this).attr('data-id');
        $('#product_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Pedidos/Search.php?val=" + value;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar fornecedores"
                $('#numberOrders').val(data['numberOrder']);
                $('#numberInvoices').val(data['numberInvoice']);
                $('#citys').val(data['city']); 
                $('#states').val(data['state']); 
                $('#prices').val(data['price']);         
                
                //Para limpar o select
                $('#types').html('');
                $('#typeOrders').html('');

                //Select do Status
                if(data['statusOrder'] == 1){
                    var options = "<option value='n'> Escolha uma opção </option>" +
                    "<option value='1' selected> Pendente </option>" +
                    "<option value='2'> Aguardando </option>" +
                    "<option value='3'> Despachado </option>" + 
                    "<option value='4'> Devolvido </option>"; 
                    
                }else if(data['statusOrder'] == 2){
                    var options = "<option value='n'> Escolha uma opção </option>" +
                    "<option value='1'> Pendente </option>" +
                    "<option value='2' selected> Aguardando </option>" +
                    "<option value='3'> Despachado </option>" + 
                    "<option value='4'> Devolvido </option>"; 
                }else if(data['statusOrder'] == 3){
                    var options = "<option value='n'> Escolha uma opção </option>" +
                    "<option value='1'> Pendente </option>" +
                    "<option value='2'> Aguardando </option>" +
                    "<option value='3' selected> Despachado </option>" + 
                    "<option value='4'> Devolvido </option>";  
                }else{
                    var options = "<option value='n'> Escolha uma opção </option>" +
                    "<option value='1'> Pendente </option>" +
                    "<option value='2'> Aguardando </option>" +
                    "<option value='3'> Despachado </option>" + 
                    "<option value='4' selected> Devolvido </option>";  
                    
                }

                $('#types').prepend(options); 
            
            //Select do tipo de remessa
                if(data['type'] == 1){
                    var tp = "<option value='n'> Selecione uma opção </option>" +
                    "<option value='1' selected> Correios </option>" +
                    "<option value='2'> Transportadora </option>" +
                    "<option value='3'> Retira No Local </option>"; 
                    
                }else if(data['type'] == 2){
                    var tp = "<option value='n'> Selecione uma opção </option>" +
                    "<option value='1'> Correios </option>" +
                    "<option value='2' selected> Transportadora </option>" +
                    "<option value='3'> Retira No Local </option>"; 
                
                }else{
                    var tp = "<option value='n'> Selecione uma opção </option>" +
                    "<option value='1'> Correios </option>" +
                    "<option value='2'> Transportadora </option>" +
                    "<option value='3' selected> Retira No Local </option>";
                }

                $('#typeOrders').prepend(tp); 

            }
        });
	});
	
	//Abre a modal do remover pedido
	$(document).on('click', '.deleteOrder', function(e){
        e.preventDefault();

        $('.delete').css('display', 'flex');
        var id = $('.deleteOrder').attr('data-id');
        var number = $('.deleteOrder').attr('data-value');
        $('.removeOrder').attr('data-id', id);
        $('.removeOrder').attr('data-value', number);
    });
	
	//Abre a modal do novo pedidos
	$(".newOrder").click(function(){
		$('.new').css('display', 'flex');
	});
	
	
	//Abre a modal do visualizar pedido - OS
    $(document).on('click', '.viewOrder', function(e){
        e.preventDefault();

        var value = $(this).attr('data-id');
        $('.new').css('display', 'flex');
        $('#numberOrder').val(value);
    });
	
	
	//Abre a modal do editar estoque
	$(document).on('click', '.editStock', function(e){
        e.preventDefault();
        var value = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        $('.modal').css('display', 'flex');
        $('#product_id').val(value);
    
        // Trazer os dados para o formulário de modal de edição de dados
    
        var url = page + "Ajax/Estoque/Search.php?searching="+value+"&type="+type;
    
        $.ajax({
            url: url,
            type: 'POST',
            data: { value: value },
            dataType: 'JSON',
            success: function (data, textStatus, jqXHR) {
                // Alimenta o formulário na modal "editar fornecedores"
                $('#idStock').val(data['id']);
                $('#qtdStock').val(data['quantity']);
                $('#productEditStock').val(data['produto']);
                $('#quantityEditStock').val(data['quantity']); 
                //$('#statusEditStock').val(data['stat']);  
                //$('#typeEditStock').val(data['operacao']);         
                
                //Para limpar o select
                $('#typeEditStock').html('');
                $('#statusEditStock').html('');

                //Insere o campo de operações
                if(data['operacao'] == 'Entrada'){
                    var optionsType = "<option value='1' selected> Entrada </option><option value='2'>Saída</option><option value='3'> Devolução </option><option value='4'>Cancelado</option>"; 
                }else if(data['operacao'] == 'Saída'){
                    var optionsType = "<option value='1'> Entrada </option><option value='2' selected>Saída</option><option value='3'> Devolução </option><option value='4'>Cancelado</option>"; 
                }else if(data['operacao'] == 'Devolução'){
                    var optionsType = "<option value='1'> Entrada </option><option value='2'>Saída</option><option value='3' selected> Devolução </option><option value='4'>Cancelado</option>"; 
                }else if(data['operacao'] == 'Cancelado'){
                    var optionsType = "<option value='1'> Entrada </option><option value='2'>Saída</option><option value='3'> Devolução </option><option value='4' selected>Cancelado</option>"; 
                }else{
                    var optionsType = "<option value='n' selected> Selecione uma opção </option><option value='1'> Entrada </option><option value='2'>Saída</option><option value='3'> Devolução </option><option value='4' selected>Cancelado</option>"; 
                }
                $('#typeEditStock').prepend(optionsType); 

                //Insere o campo de status
                if(data['stat'] == 1){
                    var options = "<option value='1'selected>Aguardando</option><option value='2'>Liberado</option>"; 
                    $('#statusEditStock').prepend(options); 
                }else{
                    var options = "<option value='1'>Aguardando</option><option value='2'selected>Liberado</option>"; 
                    $('#statusEditStock').prepend(options); 
                }

                //Se a operação for "Devolução"
                if(data['operacao'] == 'Devolução'){
                    //Habilitar os campos
                    $('.inputDevolution').css('display' , 'block');
                    //Alimenta os campos
                    $("#nfEditStock").val(data['nf']);
                    $("#nfValueEditStock").val(data['nfValor']);
                    $("#msgEditStock").val(data['motivo']);
                    $("#providerEditStock").val(data['fornecedor']);

                }
            
            }
        });
    });
	
	//Abre a modal do remover estoque
	$(document).on('click', '.deleteStock', function(e){
        e.preventDefault();

        $('.delete').css('display', 'flex');
        var id = $('.deleteStock').attr('data-id');
        var value = $('.deleteStock').attr('data-value');
        $('.removeStock').attr('data-id', id);
        $('.removeStock').attr('data-value', value);
    });
	
	//Abre a modal do novo estoque
	$(".newStock").click(function(){
		$('.new').css('display', 'flex');
	});

    // Abre os inputs da operação de devolução
    $("#typeNew").click(function(){
        var value = $(this).val();

        if(value == 3){
            $('.activeInputs').css('display', 'block');
        }else{
            $('.activeInputs').css('display', 'none');
            return false;
        }

	});

    //Atualiza a tabela de novo pedido
    var cart = setInterval(function(){

        $(".loader").load(page+"orders .loader");
        $(".loaders").load(page+"orders .loaders");
        $(".loaderOrder").load(page+"services .loaderOrder");
    }, 1000);

    //Manter os dados na modal de pedido e limpar os campos produto e quantidade - ORDER 
	$(document).on('click', ".plusOrder", function(e){
        e.preventDefault();
		$('#product').val('');
        $('#quantity').val('');

        $('.orderNew').css('display', 'none');
	});
    
    //Fechar a modal de pedido e limpar todos os campos - ORDER 
	$(document).on('click', ".orderHide, .modal-close", function(e){
        e.preventDefault();
        
		//Limpa o formulário antes de fechar a modal
        $('#form_newOrder')[0].reset();

        $('.orderNew').css('display', 'none');

        //Limpar e excluir a sessão
        var value = 1;
        var url = page+"Ajax/Pedidos/Session.php?val="+value;
        
        $.ajax({
            url: url,
            type: 'POST',
            data: value,
            dataType: 'JSON',

            success: function (data, textStatus, jqXHR) {
                setTimeout(function () {                    
                    if(data['redirect'] != ''){
                        window.location.href = data['redirect'];
                    }
                }, 1000);        
            } 
	    });
    });
});
//AUTOCARREGAMENTO DE IMAGENS - PREVIEW
var loadFile = function(event){
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById("loadPhoto");
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
};

//INTERVALO DE TEMPO - MODAIS
setInterval(function(){
    $(".notification-container").fadeOut(1000);
}, 5000);

//TABELAS ZEBRADAS
$("table tbody tr:odd").css("background-color", "#d2d2d2");
$("table tbody tr:even").css("background-color", "#e4e4e4");
$("table tbody td").css("padding", "10px 20px");

/*RG - Permitir somente números */
$(function(){
	/*$(".rg").on('input', function (e) {
		$(this).val($(this).val().replace(/[^0-9]/g, ''));
	});*/
});

//VALIDAR CPF
function CPF(){"user_strict";function r(r){
    for(var t=null,n=0;9>n;++n)t+=r.toString().charAt(n)*(10-n);var i=t%11;return i=2>i?0:11-i}function t(r){
    for(var t=null,n=0;10>n;++n)t+=r.toString().charAt(n)*(11-n);var i=t%11;return i=2>i?0:11-i}var n="(CPF Inválido)",
    i="";this.gera=function(){for(var n="",i=0;9>i;++i)n+=Math.floor(9*Math.random())+"";var o=r(n),a=n+"-"+o+t(n+""+o);
    return a},this.valida=function(o){for(var a=o.replace(/\D/g,""),u=a.substring(0,9),f=a.substring(9,11),v=0;10>v;v++)
    if(""+u+f==""+v+v+v+v+v+v+v+v+v+v+v)return n;var c=r(u),e=t(u+""+c);return f.toString()===c.toString()+e.toString()?i:n}}

var CPF = new CPF();
$(".cpf").keypress(function(){
    $("#validateCPF").html(CPF.valida($(this).val()));
});

$(".cpf").blur(function(){
    $("#validateCPF").html(CPF.valida($(this).val()));
});

//VALIDAR CNPJ
function cnpj(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14)
        return false;


    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;


    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) return false;
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}

function validarCNPJ(el){
    if(cnpj(el.value) == false){
        $("#validateCNPJ").html('(CNPJ Inválido)');
    }else{
        $("#validateCNPJ").html('');
    }
}

/* MÁSCARA DE CEP 1*/
jQuery("input.zipcode")
    .mask("99999-999")
    .focusout(function(event){
        var target, zipcode, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        zipcode = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();

        if(zipcode.length > 9){
            element.mask("99999-999");
        }else{
            element.mask("99999-999");
        }
    });


/* MÁSCARA DE TELEFONE */
jQuery("input.phone")
    .mask("(99) 9999-9999?9")
    .focusout(function(event){
        var target, phone, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        phone = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();

        if(phone.length > 10){
            element.mask("(99) 99999-999?9");
        }else{
            element.mask("(99) 9999-9999?9");
        }
    });

/* MÁSCARA DE DATA */
jQuery("input.datebirth")
    .mask("99/99/9999")
    .focusout(function(event){
        var target, datebirth, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        datebirth = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();

        if(datebirth.length > 10){
            element.mask("99/99/9999");
        }else{
            element.mask("99/99/9999");
        }
    });

/* MÁSCARA DE CPF */
jQuery("input.cpf")
    .mask("999.999.999-99")
    .focusout(function(event){
        var target, cpf, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        cpf = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();

        if(cpf.length > 14){
            element.mask("999.999.999-99");
        }else{
            element.mask("999.999.999-99");
        }
    });

/* MÁSCARA DE CNPJ */
jQuery("input.cnpj")
    .mask("99.999.999/9999-99")
    .focusout(function(event){
        var target, cnpj, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        cnpj = target.value.replace(/\D/g, '');
        element = $(target);
        element.unmask();

        if(cnpj.length > 18){
            element.mask("99.999.999/9999-99");
        }else{
            element.mask("99.999.999/9999-99");
        }
    });

/* MÁSCARA DE MOEDA */
$(".money").maskMoney();