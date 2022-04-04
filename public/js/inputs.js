
$(document).on('click', '#enviar_quantidade', function(e) {

    e.preventDefault();

    if ($('#quantidade').val().length > 0) {

        $('.formulario_quantidade').addClass('d-none');
        $('.formulario_dados').removeClass('d-none');
        let quantidade = $('#quantidade').val();

    } else {
        $('#erro_quantidade').html('Preencha uma quantidade');
    }

});

// Arrays para armazenar todos participantes do plano escolhido
let nome = [];
let dataNascimento = [];

$(document).on('click', '#enviar', function(e) {

    e.preventDefault()

    if($('#nome').val().length < 2) {
        $('#erro_dados').html('Preencha o campo "Nome"');
    } else if ($('#dataNascimento').val().length != 10) {
        $('#erro_dados').html('Preencha o campo "Data de nascimento"');        
    } else {

        // Variável ano pega os 4 digitos da data de nascimento vinda do formulário
        ano = $('#dataNascimento').val().substring(0, 4);

        var data_atual = new Date(); // data atual
        ano_atual = data_atual.getFullYear(); // Pegando somente o ano da data atual

        ano_int = parseInt(ano); // convertendo o ano vindo do formulario de string pra inteiro
        ano_atual_int = parseInt(ano_atual); // convertendo ano atual de string pra inteiro

        // soma do ano atual e ano vindo do formulario para verificar se é realmente possivel a pessoa ter a idade que diz ter
        soma = ano_atual_int - ano_int;

        // se a pessoa tiver entre 0 e 90 anos pode continuar a execução do código
        if (soma < 80 && soma >= 0) {

            // Adicionar valores no final do array
            nome.push($('#nome').val());
            dataNascimento.push($('#dataNascimento').val());
        
            // se no array nao conter a quantidade de nomes sendo igual a quantidade de pessoas pra participar do plano
            if (nome.length < $('#quantidade').val()) {

                let quantos_falta = $('#quantidade').val() - nome.length;

                // Exibir quantas pessoas faltam pra ser cadastradas
                if ($('#quantidade').val() - nome.length == 1){

                    // erro no singular
                    $('#erro_dados').html('Você precisa cadastrar mais '+quantos_falta+' pessoa');

                } else {
                    
                    // erro no plural
                    $('#erro_dados').html('Você precisa cadastrar mais '+quantos_falta+' pessoas');
                }
            } else if(nome.length == $('#quantidade').val() && dataNascimento.length == $('#quantidade').val()) {

                $.ajax({
                    url: '/tratar_dados',
                    method: 'get',
                    data: {nome: nome, dataNascimento: dataNascimento, quantidade: $('#quantidade').val()},
                    dataType: 'text',
                    success: function(resposta) {

                        if (resposta == 'true') {
                            location.href="/orcamento";
                        } else {
                            $('#erro_dados').html('É preciso efetuar o cadastro');
                        }

                    }
                });

            }

            // Limpar campos para serem preenchidos novamente
            $('#nome').val('');
            $('#dataNascimento').val('');

        }

    }

});