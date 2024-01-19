// JqueryMask
$(document).ready(function () {
    $('#addCpfRep').mask('000.000.000-00');
    $('#editCpfRep').mask('000.000.000-00');
    $('#select-one').select2({
        placeholder: "Escolha os fornecedores",
        minimumInputLength: 2,
        theme: "bootstrap-5",
        ajax: {
            url: '/api/administracao/fornecedores/select2',
            dataType: 'json'
        },
        language: getSelect2LangBR(),
        dropdownParent: $("#modalAdd .modal-body"),
    });
    $('#select-single').select2({
        placeholder: "Vincular fornecedor",
        minimumInputLength: 2,
        theme: "bootstrap-5",
        ajax: {
            url: '/api/administracao/fornecedores/select2',
            dataType: 'json'
        },
        language: getSelect2LangBR(),
        dropdownParent: $("#modalEdit .modal-body"),
    });
    initializePopovers();
    show_hide_password();
});

// Datatables
var jquery_datatable = $("#tableRepresentantes").DataTable({

    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/representantes/list',
    columns: [
        {
            data: 'verificado',
            orderable: false,
            render: function (data, type, row, meta) {
                let status = (data == 'sim') ?
                    '<span class="badge bg-success" title="Email verificado"><i class="bi bi-shield-check"></i></span>' :
                    '<span class="badge bg-info" title="Email não verificado"><i class="bi bi-shield-exclamation"></i></span>';
                let blocked = (row.blocked == 1) ?
                    '<br/><span class="badge bg-danger mt-1" title="Bloqueado"><i class="bi bi-lock"></i></span>' :
                    '<br/><span class="badge bg-success mt-1" title="Desbloqueado"><i class="bi bi-unlock"></i></span>';
                return status + blocked;
            }
        },
        {
            data: 'id_representante'
        },
        {
            data: 'nome_representante'
        },
        {
            data: 'fornecedores',
            orderable: false,
            render: function (data, type, row, meta) {
                if (data == '0') {
                    return '<button type="button" class="btn btn-link" disabled>Autônomo</button>';
                } else {
                    return `<button type="button" class="btn btn-link detail-modal" data-id="${row.id_representante}">Detalhar</button>`;
                }
            }
        },
        {
            data: null,
            orderable: false,
            render: function (data, type, row, meta) {
                let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1" data-bs-toogle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>`;
                let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-name="${row.nome_representante}" data-bs-id="${row.id_representante}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` : `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-name="${row.nome_representante}" data-bs-id="${row.id_representante}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`;
                let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-nome="${row.nome_representante}" data-bs-id="${row.id_representante}"><i class="bi bi-trash"></i></button>`;
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
    "initComplete": function (settings, json) {
        jquery_datatable.buttons().container().appendTo($('#header-wrapper'));
        jquery_datatable.on('click', 'button.btn-edit', function (e) {
            let data = jquery_datatable.row(e.target.closest('tr')).data();
            console.log(data);
        });
        jquery_datatable.on('click', 'button.btn-delete', function (e) {
            let data = jquery_datatable.row(e.target.closest('tr')).data();
            console.log(data);
        });
    }
});

/* Clear form on close */
clear_on_close('formAddRepresentante', 'modalAdd');
clear_on_close('formEditRepresentante', 'modalEdit');
// Submit Form Add
submit_add('formAddRepresentante','modalAdd',jquery_datatable,'Representante criado com sucesso!','Erro ao criar representante', 
    () => {
        $('#select-one').val(null).trigger('change');
    },
    () => {}
);

// Submit remove Representante
submit_remove('formRemoveRepresentante', 'modalRemove', jquery_datatable, 
'Representante excluído com sucesso!', 'Erro ao excluir representante.',
    () => {}, () => {}
);

// Submit Form Block
submit_block('formBlockRepresentante', 'modalBlock', jquery_datatable, 
    ['Representante desbloqueado com sucesso!', 'Representante bloqueado com sucesso!' ] ,
    ['Erro ao desbloquear representante.', 'Erro ao bloquear representante.'],
    () => {}, () => {}
);

// Submit Form Edit
submit_edit('formEditRepresentante', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {
        $("#modalEdit button[data-bs-target='#tab12']").removeAttr('disabled');
    }, 
    () => {
        $("#modalEdit button[data-bs-target='#tab12']").removeAttr('disabled');
    },
    () => {
        $("#modalEdit button[data-bs-target='#tab12']").attr('disabled', true);
    },
);
// ###########################################
$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveRepresentante"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let nome = e.relatedTarget.getAttribute('data-bs-nome');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalRemove').find('strong').html(nome);
    $('#modalRemove').find('input[name="id_representante"]').val(id);
});
$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockRepresentante"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Representante');
            $('#modalBlock').find('button[form="formBlockRepresentante"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
            break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Representante');
            $('#modalBlock').find('button[form="formBlockRepresentante"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let name = e.relatedTarget.getAttribute('data-bs-name');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalBlock').find('strong').html(name);
    $('#modalBlock').find('input[name="id_representante"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});

// EDIT
function reload_fornecedores_edit() {
    let form = "#formFornecedorRepresentante";
    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: $(form).serialize(),
        beforeSend: () => {
            //$("#modalEdit").find('.loader').addClass('d-flex');
            $("#modalEdit").find('#tab12 .loader').removeClass('d-none');
            $("#modalEdit").find('#tab12 .loader').addClass('d-flex');
            $("#modalEdit button[data-bs-target='#tab11']").attr('disabled', true);
        },
        success: (result) => {
            $("#modalEdit").find('.loader').addClass('d-none');
            let html = "";
            if (result.length) {
                html = "<table class='table table-striped'><tbody>";
                result.forEach((el) => {
                    html += `<tr><td class="w-100">${el.razao_social}</td>
                <td class="w-auto">
                    <button type="button" class="btn btn-primary btn-delete-fornecedor mb-1 ml-1" data-rep="${el.id_fornecedor}"><i class="bi bi-trash"></i></button>
                </td></tr>`;
                });
                html += "</tbody></table>";
                $('.result').html(html);
                setBtnDeleteFornecedorClick();
            } else {
                html = "<p>Este fornecedor está vinculado a fornecedores.</p>"
                $('.result').html(html);
            }
        },
        error: (result) => {
            $('#tab12 .result').html("<div class='alert alert-danger'>Ocorreu um erro ao processar a requisição.</div>");
            
        },
        complete: () => {
            $("#modalEdit").find('#tab12 .loader').removeClass('d-flex');
            $("#modalEdit").find('#tab12 .loader').addClass('d-none');
            $("#modalEdit button[data-bs-target='#tab11']").removeAttr('disabled');
        }
    });
}
/* Abre o edit e joga os dados dentro dos inputs */
jquery_datatable.on('click', 'button.btn-edit', function (e) {
    let data = jquery_datatable.row(e.target.closest('tr')).data();
    $("#modalEdit").find('#formEditRepresentante input[name="nome_representante"]').val(data['nome_representante']);
    $("#modalEdit").find('#formEditRepresentante input[name="cpf_responsavel"]').val(data['cpf_responsavel']);
    $("#modalEdit").find('#formEditRepresentante input[name="id_representante"]').val(data['id_representante']);
    $("#modalEdit").find('#formFornecedorRepresentante input[name="id_representante"]').val(data['id_representante']);
    $("#modalEdit").find('#formVincularRepresentante input[name="id_representante"]').val(data['id_representante']);
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditRepresentante"]').removeClass('d-none');
    // Seleciona a primeira TAB
    var triggerEl = document.querySelector('#tabEdit button[data-bs-target="#tab11"]');
    bootstrap.Tab.getInstance(triggerEl).show();
    $("#modalEdit").modal('show');
});
/* Clique do botão Dados Pessoais da TAB */
$("#modalEdit button[data-bs-target='#tab11']").on('click', function (e) {
    let alert = $('#modalEdit').find('.alert');
    if (!alert.length) {
        $('#modalEdit').find('button[form="formEditRepresentante"]').removeClass('d-none');
    }
});
/* Clique do botão Fornecedores da TAB */
$("#modalEdit button[data-bs-target='#tab12']").on('click', function (e) {
    $('#modalEdit').find('button[form="formEditRepresentante"]').addClass('d-none');
    reload_fornecedores_edit();
});

function setBtnDeleteFornecedorClick(){
    $("button.btn-delete-fornecedor").on('click', function (e) {
        let id_fornecedor = $(this).data('rep');
        let csrf = $("#formVincularRepresentante input[name='csrf_field_name']").val();
        let id_representante = $("#formVincularRepresentante input[name='id_representante']").val()
        $.ajax({
            type: 'post',
            url: '/api/administracao/representantes/desvincular',
            data: {
                'id_representante' : id_representante,
                'id_fornecedor' : id_fornecedor,
                'csrf_field_name': csrf
            },
            beforeSend: () => {
                $("#modalEdit").find('.loader').removeClass('d-none');
                $("#modalEdit").find('.loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                $('.alert-area').append(`<div class="alert alert-success alert-dismissible show fade">           
                Vínculo removido com sucesso.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('.loader').removeClass('d-flex');
                $("#modalEdit").find('.loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                reload_fornecedores_edit();
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
                $('.alert-area').append(`<div class="alert alert-danger alert-dismissible show fade">           
                Ocorreu um erro ao executar a operação. ${text_error}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                $("#modalEdit").find('.loader').removeClass('d-flex');
                $("#modalEdit").find('.loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
    
            }
        });
    });
}

/* Vincular Fornecedor */
$(".btn-add-fornecedor").on('click', function (e) {
    let form = "#formVincularRepresentante";
    if ($(form + " select").val() !== null) {
        $.ajax({
            type: $(form).attr('method'),
            url: $(form).attr('action'),
            data: $(form).serialize(),
            beforeSend: () => {
                $("#modalEdit").find('.loader').removeClass('d-none');
                $("#modalEdit").find('.loader').addClass('d-flex');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').attr('disabled', true);
            },
            success: (result) => {
                $('.alert-area').append(`<div class="alert alert-success alert-dismissible show fade">           
            Vínculo executado com sucesso.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
                $("#modalEdit").find('.loader').removeClass('d-flex');
                $("#modalEdit").find('.loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');
                reload_fornecedores_edit();
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
                $('.alert-area').append(`<div class="alert alert-danger alert-dismissible show fade">           
            Ocorreu um erro ao executar a operação. ${text_error}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
                $("#modalEdit").find('.loader').removeClass('d-flex');
                $("#modalEdit").find('.loader').addClass('d-none');
                $("#modalEdit").find('button[data-bs-dismiss="modal"]').removeAttr('disabled');

            }
        });
    }
});

/* Desvincular Fornecedor */

/* Abre o modal de detalhe e faz a consulta pelos fornecedores */
jquery_datatable.on('click', 'button.detail-modal', function (e) {
    let id = e.target.dataset.id;
    let form = "#formDetalhesRepresentante";
    $(form).find('input[name="id_representante"]').val(id);
    let modal = "#modalDetalheRepresentante";
    $("#modalDetalheRepresentante").find('div.alert').remove();
    $(modal).modal('show');
    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: $(form).serialize(),
        beforeSend: () => {
            $(modal).find('.loader').addClass('d-flex');
        },
        success: (result) => {
            $(modal).find('.loader').addClass('d-none');
            let html = "<table class='table table-striped'><thead><tr><th>Fornecedor</th></tr></thead><tbody>";
            result.forEach((el) => {
                html += `<tr><td>${el.razao_social}</td></tr>`;
            });
            html += "</tbody></table>";
            $(modal + " .modal-body").append(html);
        },
        error: (result) => {
            $(modal).find('.loader').addClass('d-none');
            $('#modalDetalheRepresentante .modal-body').prepend(`<div class="alert alert-danger alert-dismissible show fade">           
            Ocorreu um erro ao executar a operação.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
        }
    });
});
$('#modalDetalheRepresentante').on('hide.bs.modal', (e) => {
    $("#modalDetalheRepresentante").find('table').remove();
});