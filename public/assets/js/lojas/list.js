// JqueryMask
$(document).ready(function () {
    $('#addCnpjLoja').mask('00.000.000/0000-00');
    $('#addIeLoja').mask('0#');
    $('#addTelefoneLoja').mask('0#');
    $('#editCnpjLoja').mask('00.000.000/0000-00');
    $('#editIeLoja').mask('0#');
    $('#editTelefoneLoja').mask('0#');
    $("#addNegociacaoLoja").mask('##0,00', {reverse: true});
    $("#editNegociacaoLoja").mask('##0,00', {reverse: true});
    $('#select-single').select2({
        placeholder: "Vincular Bandeira",
        minimumInputLength: 2,
        theme: "bootstrap-5",
        ajax: {
            url: '/api/administracao/lojas/select2',
            dataType: 'json'
        },
        language: getSelect2LangBR(),
        dropdownParent: $("#modalAdd .modal-body"),
    });
    initializePopovers(); 
    show_hide_password();
});


var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/lojas/list',
    columns: [
        {
            data: 'verificado',
            orderable: false,
            render: function(data, type, row, meta) {
                let status = (data == 'sim') ?
                    '<span class="badge bg-success" title="Email Verificado"><i class="bi bi-shield-check"></i></span>' :
                    '<span class="badge bg-info" title="Email não verificado"><i class="bi bi-shield-exclamation"></i></span>';
                let blocked = (row.blocked == 1) ? 
                    '<br/><span class="badge bg-danger mt-1" title="Bloqueado"><i class="bi bi-lock"></i></span>' : 
                    '<br/><span class="badge bg-success mt-1" title="Desbloqueado"><i class="bi bi-unlock"></i></span>';
                return status + blocked; 
            }
        },
        {
            data: 'id_loja'
        },
        {
            data: 'nome_fantasia'
        },
        {
            data: 'razao_social'
        },
        {
            data: 'nome_responsavel'
        },
        {
            data: 'cnpj_loja'
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row, meta) {
                let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Editar" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>`;
                let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` :`<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`
                let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" class="btn btn-secondary" title="Remover"><i class="bi bi-trash"></i></button>`;
                return `${edit} ${block} ${trash}`;
            }
        }
    ],
    responsive: true,
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
    },
    buttons: {
        buttons: ['csv', 'excel', 'pdf', 'print']
    },
    "initComplete": function(settings, json) {
        jquery_datatable.buttons().container().appendTo($('#header-wrapper'));
        jquery_datatable.on('click', 'button.btn-edit', function(e) {
            let data = jquery_datatable.row(e.target.closest('tr')).data();
            console.log(data);
        });
        jquery_datatable.on('click', 'button.btn-delete', function(e) {
            let data = jquery_datatable.row(e.target.closest('tr')).data();
            console.log(data);
        });
    }
});
/* Clear form on close */
clear_on_close('formAddLoja', 'modalAdd', 
() => {
    $('#emailsList').html('<p>Nenhum email adicionado</p>'); 
    $('#telefoneList').html('<p>Nenhum telefone adicionado</p>'); 
});
clear_on_close('formEditLoja', 'modalEdit');
// Submit Form Add
submit_add('formAddLoja','modalAdd',jquery_datatable, 'Loja criada com sucesso!','Erro ao criar Loja!',
    () => {
        $('#emailsList').html('<p>Nenhum email adicionado</p>');
        $('#telefoneList').html('<p>Nenhum telefone adicionado</p>');
        $('#select-single').val(null).trigger('change');
    },
    (result) => {
        let fields = ['emails', 'telefones']
        for(let field of fields){
            if(result.responseJSON.messages[field]){
                let prop = result.responseJSON.messages[field];
                prop.forEach((el) => {
                    for (const [key, value] of Object.entries(el)) {
                        let input = $('#modalAdd').find(`input[value="${key}"]`).parent().parent();
                        $(`<div class='alert alert-danger alert-dismissible show fade'>
                        ${value} 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`).insertAfter(input);
                    }
                });
            }
        }
    }
);
// Submit remove Loja
submit_remove('formRemoveLoja', 'modalRemove', jquery_datatable, 
'Loja excluída com sucesso!', 'Erro ao excluir loja.',
    () => {}, () => {}
);
// Submit Form Block
submit_block('formBlockLoja', 'modalBlock', jquery_datatable, 
    ['Loja desbloqueada com sucesso!', 'Loja bloqueada com sucesso!' ] ,
    ['Erro ao desbloquear loja.', 'Erro ao bloquear loja.'],
    () => {}, () => {}
);

// Submit Form Edit
submit_edit('formEditLoja', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {}, (r) => { console.log(r) }
);
// ###########################################
/* Abre o edit e joga os dados dentro dos inputs */
jquery_datatable.on('click', 'button.btn-edit', function (e) {
    let data = jquery_datatable.row(e.target.closest('tr')).data();
    console.log($("#modalEdit").find('#formEditloja'));
    $("#modalEdit").find('#formEditLoja input[name="id_loja"]').val(data['id_loja']);
    $("#modalEdit").find('#formEditLoja input[name="nome_fantasia"]').val(data['nome_fantasia']);
    $("#modalEdit").find('#formEditLoja input[name="razao_social"]').val(data['razao_social']);
    $("#modalEdit").find('#formEditLoja input[name="nome_responsavel"]').val(data['nome_responsavel']);
    $("#modalEdit").find('#formEditLoja input[name="cnpj_loja"]').val(data['cnpj_loja']);
    $("#modalEdit").find('#formEditLoja input[name="ie_loja"]').val(data['ie_loja']);
    let negociacao = data['negociacao'].replace(".", ",");
    $("#modalEdit").find('#formEditLoja input[name="negociacao"]').val(negociacao);
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditLoja"]').removeClass('d-none');
    /// Emails e telefones
    $("#modalEdit").find('#formLojasEmails input[name="id_loja"]').val(data['id_loja']);
    $("#modalEdit").find('#formLojasTelefones input[name="id_loja"]').val(data['id_loja']);
    $("#modalEdit").find('#formVincularEmail input[name="id_loja"]').val(data['id_loja']);
    $("#modalEdit").find('#formVincularTelefone input[name="id_loja"]').val(data['id_loja']);
    // Seleciona a primeira TAB
    var triggerEl = document.querySelector('#tabEdit button[data-bs-target="#tab11"]');
    bootstrap.Tab.getInstance(triggerEl).show();
    $("#modalEdit").modal('show');
});

function reload_telefones_edit() {
    let form = "#formLojasTelefones";
    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: $(form).serialize(),
        beforeSend: () => {
            $("#modalEdit").find('#tab13 .loader').removeClass('d-none');
            $("#modalEdit").find('#tab13 .loader').addClass('d-flex');
            $("#modalEdit button[data-bs-target='#tab11']").attr('disabled', true);
            $("#modalEdit button[data-bs-target='#tab12']").attr('disabled', true);
        },
        success: (result) => {
            $("#modalEdit").find('.loader').addClass('d-none');
            let html = "";
            if (result.length) {
                html = "<table class='table table-striped'><tbody>";
                result.forEach((el) => {
                    let info = (el.is_whats == 0) ? 'Telefone' : 'Whatsapp';
                    html += `<tr><td class="w-100">${el.num_telefone}</td><td>${info}</td>
                <td class="w-auto">
                    <button type="button" class="btn btn-primary btn-delete-telefone-loja mb-1 ml-1" data-id-telefone="${el.id_telefone_loja}"><i class="bi bi-trash"></i></button>
                </td></tr>`;
                });
                html += "</tbody></table>";
                $('#tab13 .result').html(html);
                $('#tab13 input[type="text"], #tab13 button').removeAttr('disabled');
                setBtnDeleteTelefoneClick();
            } else {
                html = "<p>Esta loja não possuí telefones</p>"
                $('#tab13 .result').html(html);
            }
        },
        error: (result) => {
            $('#tab13 .result').html("<div class='alert alert-danger'>Ocorreu um erro ao processar a requisição.</div>");
            $('#tab13 input[type="text"], #tab13 button').attr('disabled', true);
        },
        complete: () => {
            $("#modalEdit").find('#tab13 .loader').removeClass('d-flex');
            $("#modalEdit").find('#tab13 .loader').addClass('d-none');
            $("#modalEdit button[data-bs-target='#tab11']").removeAttr('disabled');
            $("#modalEdit button[data-bs-target='#tab12']").removeAttr('disabled');
        }
    });
}

function reload_emails_edit() {
    let form = "#formLojasEmails";
    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: $(form).serialize(),
        beforeSend: () => {
            $("#modalEdit").find('#tab12 .loader').removeClass('d-none');
            $("#modalEdit").find('#tab12 .loader').addClass('d-flex');
            $("#modalEdit button[data-bs-target='#tab11']").attr('disabled', true);
            $("#modalEdit button[data-bs-target='#tab13']").attr('disabled', true);
        },
        success: (result) => {
            let html = "";
            if (result.length) {
                html = "<table class='table table-striped'><tbody>";
                result.forEach((el) => {
                    html += `<tr><td class="w-100">${el.email_loja}</td>
                <td class="w-auto">
                    <button type="button" class="btn btn-primary btn-delete-email-loja mb-1 ml-1" data-id-email="${el.id_email_loja}"><i class="bi bi-trash"></i></button>
                </td></tr>`;
                });
                html += "</tbody></table>";
                $('#tab12 .result').html(html);
                $('#tab12 input[type="text"], #tab12 button').removeAttr('disabled');
                setBtnDeleteEmailClick();
            } else {
                html = "<p>Esta loja não possuí emails</p>"
                $('#tab12 .result').html(html);
            }
        },
        error: (result) => {
            $('#tab12 .result').html("<div class='alert alert-danger'>Ocorreu um erro ao processar a requisição.</div>");
            $('#tab12 input[type="text"], #tab12 button').attr('disabled', true);
        },
        complete: () => {
            $("#modalEdit").find('#tab12 .loader').removeClass('d-flex');
            $("#modalEdit").find('#tab12 .loader').addClass('d-none');
            $("#modalEdit button[data-bs-target='#tab11']").removeAttr('disabled');
            $("#modalEdit button[data-bs-target='#tab13']").removeAttr('disabled');
        }
    });
}

// Deleta o email da loja
// function setBtnDeleteEmailLojaClick(){
//     $(".btn-delete-email-loja").on('click', function (e) {
//         let id_email_loja = $(this).data('loja');
//         let csrf = $("#formVincularEmails input[name='csrf_field_name']").val();
//         let id_loja = $("#formVincularEmails input[name='id_loja']").val()
//         $.ajax({
//             type: 'post',
//             url: '/api/administracao/lojas/destroy/email',
//             data: {
//                 'id_email_loja' : id_email_loja,
//                 'id_loja' : id_loja,
//                 'csrf_field_name': csrf
//             },
//             beforeSend: () => {
//                 $("#modalEdit").find('.loader').removeClass('d-none');
//                 $("#modalEdit").find('.loader').addClass('d-flex');
//                 $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
//             },
//             success: (result) => {
//                 $('.alert-area').append(`<div class="alert alert-success alert-dismissible show fade">           
//                 Email removido com sucesso.
//                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//                 </div>`);
//                 $("#modalEdit").find('.loader').removeClass('d-flex');
//                 $("#modalEdit").find('.loader').addClass('d-none');
//                 $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
//                 reload_emails_edit();
//                 jquery_datatable.ajax.reload();
//             },
//             error: (result) => {
//                 let text_error = "";
//                 if (result.responseJSON.messages) {
//                     for (const key in result.responseJSON.messages) {
//                         if (result.responseJSON.messages.hasOwnProperty(key)) {
//                             text_error += `<br/><strong>${result.responseJSON.messages[key]}</strong>`;
//                         }
//                     }
//                 }
//                 $('.alert-area').append(`<div class="alert alert-danger alert-dismissible show fade">           
//                 Ocorreu um erro ao executar a operação. ${text_error}
//                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//                 </div>`);
//                 $("#modalEdit").find('.loader').removeClass('d-flex');
//                 $("#modalEdit").find('.loader').addClass('d-none');
//                 $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
    
//             }
//         });
//     });
// }

/* Clique do botão Dados Pessoais da TAB */
$("#modalEdit button[data-bs-target='#tab11']").on('click', function (e) {
    let alert = $('#modalEdit').find('.alert');
    if (!alert.length) {
        $('#modalEdit').find('button[form="formEditLoja"]').removeClass('d-none');
    }
});
/* Clique do botão Emails da TAB */
$("#modalEdit button[data-bs-target='#tab12']").on('click', function (e) {
    $('#modalEdit').find('button[form="formEditLoja"]').addClass('d-none');
    $('#tab12 .alert-area').html('');
    reload_emails_edit();
});
/* Clique do botão Telefones da TAB */
$("#modalEdit button[data-bs-target='#tab13']").on('click', function (e) {
    $('#modalEdit').find('button[form="formEditLoja"]').addClass('d-none');
    $('#tab13 .alert-area').html('');
    reload_telefones_edit();
});


$('#modalEdit').on('show.bs.modal', (e) => {
    $('#modalEdit').find('div.alert').remove();
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('.input-group').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditRepresentante"]').removeClass('d-none');

});
// $('#modalEdit').on('show.bs.modal', (e) => {
//     $('#modalEdit').find('div.alert').remove();
//     $('#modalEdit').find('.form-floating').removeClass('d-none');
//     $('#modalEdit').find('button[form="formEditBandeira"]').removeClass('d-none');        
//     let id = e.relatedTarget.getAttribute('data-bs-id');
//     let nome_loja = e.relatedTarget.getAttribute('data-bs-nome-loja');
//     let nome_responsavel = e.relatedTarget.getAttribute('data-bs-responsavel');
//     let cpf = e.relatedTarget.getAttribute('data-bs-cpf');
//     $('#modalEdit').find('input[name="id_loja"]').val(id);
//     $('#modalEdit').find('input[name="nome_loja"]').val(nome_loja);
//     $('#modalEdit').find('input[name="nome_responsavel"]').val(nome_responsavel);
//     $('#modalEdit').find('input[name="cpf"]').val(cpf);
// });
$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveLoja"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let razao_social = e.relatedTarget.getAttribute('data-bs-razao-social');
    $('#modalRemove').find('strong').html(razao_social);
    $('#modalRemove').find('input[name="id_loja"]').val(id);
});
$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockLoja"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Loja');
            $('#modalBlock').find('button[form="formBlockLoja"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
          break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Loja');
            $('#modalBlock').find('button[form="formBlockBandeira"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let razao_social = e.relatedTarget.getAttribute('data-bs-razao-social');
    $('#modalBlock').find('strong').html(razao_social);
    $('#modalBlock').find('input[name="id_loja"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});
/* Adiciona campo Email */
$('#buttonAddEmail').on('click', function(e){
    let value = $('#addEmailsLoja').val();
    let test = $(`#emailsList .item-mail input[value='${value}']`).length === 0;
    let regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let isEmail = value.match(regex);
    if(value && test && isEmail){
        $('#emailsList').find('p').remove();
        let main_container = document.createElement('div');
        main_container.classList.add('d-flex', 'align-items-center', 'gap-1', 'mb-2', 'item-mail');
        let group = document.createElement('div');
        group.classList.add('input-group');
        let span = document.createElement('span');
        span.classList.add('input-group-text', 'd-flex');
        span.textContent = '@';
        let hidden = document.createElement('input');
        hidden.setAttribute('type', 'hidden');
        hidden.setAttribute('name', 'emails[]');
        hidden.setAttribute('value', `${value}`);
        let input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('value', value);
        input.setAttribute('readonly', true);
        input.classList.add('form-control');
        group.appendChild(hidden);
        group.appendChild(span);
        group.appendChild(input);
        let button = document.createElement('button');
        button.setAttribute('type', 'button');
        button.classList.add('btn', 'btn-primary');
        button.innerHTML = '<i class="bi bi-trash"></i>';
        button.addEventListener('click', () => {
            let list = document.querySelectorAll('#emailsList .item-mail');
            let container = button.parentElement;
            let next = $(container).next();
            if(next.is('.alert')){
                next.remove();
            }
            container.remove();
            if(list.length == 1){
                $('#emailsList').append("<p>Nenhum telefone adicionado</p>");
            }
        });
        main_container.appendChild(group);
        main_container.appendChild(button);
        $('#emailsList').append(main_container);
        $('#addEmailsLoja').val('');
    }
});

/* Adiciona campo Telefone */
$('#buttonAddTelefone').on('click', function(e){
    let value = $('#addTelefoneLoja').val();
    let whats = $('#checkWhats').is(":checked");
    let phone_type = whats ? '1' : '0';
    let text_phone = (whats) ? 'Whatsapp' : 'Telefone';
    let test = $(`#telefoneList .item-phone input[value='${value},${phone_type}']`).length === 0;
    if(value && test){
        $('#telefoneList').find('p').remove();
        let main_container = document.createElement('div');
        main_container.classList.add('d-flex', 'align-items-center', 'gap-1', 'mb-2', 'item-phone');
        let group = document.createElement('div');
        group.classList.add('input-group');
        let span = document.createElement('span');
        span.classList.add('input-group-text', 'd-flex');
        span.textContent = text_phone;
        let hidden = document.createElement('input');
        hidden.setAttribute('type', 'hidden');
        hidden.setAttribute('name', 'telefones[]');
        hidden.setAttribute('value', `${value},${phone_type}`);
        let input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('value', value);
        input.setAttribute('readonly', true);
        input.classList.add('form-control');
        group.appendChild(hidden);
        group.appendChild(span);
        group.appendChild(input);
        let button = document.createElement('button');
        button.setAttribute('type', 'button');
        button.classList.add('btn', 'btn-primary');
        button.innerHTML = '<i class="bi bi-trash"></i>';
        button.addEventListener('click', () => {
            let list = document.querySelectorAll('#telefoneList .item-phone');
            let container = button.parentElement;
            let next = $(container).next();
            if(next.is('.alert')){
                next.remove();
            }
            container.remove();
            if(list.length == 1){
                $('#telefoneList').append("<p>Nenhum telefone adicionado</p>");
            }
        });
        main_container.appendChild(group);
        main_container.appendChild(button);
        $('#telefoneList').append(main_container);
        $('#addTelefoneLoja').val('');
        $('#checkWhats').prop('checked', false);
    }
});

// Adiciona Email no Editar
$("#buttonEditAddEmail").on('click', function (e) {
    let form = "#formVincularEmail";
    let value = $('#editEmailLoja').val();
    let test = value.length > 0;
    let regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let isEmail = value.match(regex);
    if(test && isEmail){
        $.ajax({
            type: $(form).attr('method'),
            url: $(form).attr('action'),
            data: $(form).serialize(),
            beforeSend: () => {
                $("#modalEdit").find('#tab12 .loader').removeClass('d-none');
                $("#modalEdit").find('#tab12 .loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                $('#tab12  .alert-area').append(`<div class="alert alert-success alert-dismissible show fade">           
                    Email criado com sucesso.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab12 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab12 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                $('#editEmailLoja').val('');
                reload_emails_edit();
                jquery_datatable.ajax.reload();
            },
            error: (result) => {
                console.log(result);
                let text_error = "";
                if (result.responseJSON.messages) {
                    for (const key in result.responseJSON.messages) {
                        if (result.responseJSON.messages.hasOwnProperty(key)) {
                            text_error += `<br/><strong>${result.responseJSON.messages[key]}</strong>`;
                        }
                    }
                }
                $('#tab12  .alert-area').html(`<div class="alert alert-danger alert-dismissible show fade">           
                    Ocorreu um erro ao executar a operação. ${text_error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab12  .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab12  .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
            }
        });
    }
});

// Adiciona Telefone no Editar
$("#buttonEditAddTelefone").on('click', function (e) {
    let form = "#formVincularTelefone";
    let value = $('#editTelefoneLoja').val();
    let id_loja = $(form + ' input[name="id_loja"]').val();
    let whats = $('#editCheckWhats').is(":checked");
    let phone_type = whats ? '1' : '0';
    let csrf = $(form + ' input[name="csrf_field_name"]').val();
    let regex = /^\d+$/;
    let test_value = value.match(regex);
    let test_whats = (phone_type == '1' || phone_type == '0');
    if(test_value && test_whats){
        $.ajax({
            type: $(form).attr('method'),
            url: $(form).attr('action'),
            data: {
                'num_telefone': value,
                'id_loja': id_loja,
                'is_whats': phone_type,
                'csrf_field_name': csrf
            },
            beforeSend: () => {
                $("#modalEdit").find('#tab13 .loader').removeClass('d-none');
                $("#modalEdit").find('#tab13 .loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                console.log(result);
                $('#tab13  .alert-area').html(`<div class="alert alert-success alert-dismissible show fade">           
                    Telefone criado com sucesso.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab13 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab13 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                $('#editTelefoneLoja').val('');
                $('#editCheckWhats').prop("checked", false);
                reload_telefones_edit();
                jquery_datatable.ajax.reload();
            },
            error: (result) => {
                console.log(result);
                let text_error = "";
                if (result.responseJSON.messages) {
                    for (const key in result.responseJSON.messages) {
                        if (result.responseJSON.messages.hasOwnProperty(key)) {
                            text_error += `<br/><strong>${result.responseJSON.messages[key]}</strong>`;
                        }
                    }
                }
                $('#tab13  .alert-area').html(`<div class="alert alert-danger alert-dismissible show fade">           
                    Ocorreu um erro ao executar a operação. ${text_error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab13  .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab13  .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
            }
        });
    }
});

/* Coloca uma ação no botão de excluir email */
function setBtnDeleteEmailClick(){
    $("button.btn-delete-email-loja").on('click', function (e) {
        let id_email = $(this).data('id-email');
        let csrf = $("#formVincularEmail input[name='csrf_field_name']").val();
        let id_loja = $("#formVincularEmail input[name='id_loja']").val()
        $.ajax({
            type: 'post',
            url: '/api/administracao/lojas/emails/remove', 
            data: {
                'id_email_loja' : id_email,
                'id_loja' : id_loja,
                'csrf_field_name': csrf
            },
            beforeSend: () => {
                $("#modalEdit").find('#tab12 .loader').removeClass('d-none');
                $("#modalEdit").find('#tab12 .loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                console.log(result);
                $('#tab12 .alert-area').append(`<div class="alert alert-success alert-dismissible show fade">           
                Email removido com sucesso.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab12 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab12 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                reload_emails_edit();
                jquery_datatable.ajax.reload();
            },
            error: (result) => {
                let text_error = "";
                if (result.responseJSON.messages) {
                    for (const key in result.responseJSON.messages) {
                        if (result.responseJSON.messages.hasOwnProperty(key)) {
                            text_error += `<br/><strong>${result.responseJSON.messages[key]}</strong>`;
                        }
                    }
                }
                $('#tab12 .alert-area').html(`<div class="alert alert-danger alert-dismissible show fade">           
                    Ocorreu um erro ao executar a operação. ${text_error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab12 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab12 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
            }
        });
    });
}

/* Coloca uma ação no botão de excluir telefone */
function setBtnDeleteTelefoneClick(){
    $("button.btn-delete-telefone-loja").on('click', function (e) {
        let id_telefone = $(this).data('id-telefone');
        let csrf = $("#formVincularTelefone input[name='csrf_field_name']").val();
        let id_loja = $("#formVincularTelefone input[name='id_loja']").val()
        $.ajax({
            type: 'post',
            url: '/api/administracao/lojas/telefones/remove', 
            data: {
                'id_telefone_loja' : id_telefone,
                'id_loja' : id_loja,
                'csrf_field_name': csrf
            },
            beforeSend: () => {
                $("#modalEdit").find('#tab13 .loader').removeClass('d-none');
                $("#modalEdit").find('#tab13 .loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                console.log(result);
                $('#tab13 .alert-area').html(`<div class="alert alert-success alert-dismissible show fade">           
                Telefone removido com sucesso.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab13 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab13 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                reload_telefones_edit();
                jquery_datatable.ajax.reload();
            },
            error: (result) => {
                let text_error = "";
                if (result.responseJSON.messages) {
                    for (const key in result.responseJSON.messages) {
                        if (result.responseJSON.messages.hasOwnProperty(key)) {
                            text_error += `<br/><strong>${result.responseJSON.messages[key]}</strong>`;
                        }
                    }
                }
                $('#tab12 .alert-area').append(`<div class="alert alert-danger alert-dismissible show fade">           
                    Ocorreu um erro ao executar a operação. ${text_error}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('#tab13 .loader').removeClass('d-flex');
                $("#modalEdit").find('#tab13 .loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
            }
        });
    });
}