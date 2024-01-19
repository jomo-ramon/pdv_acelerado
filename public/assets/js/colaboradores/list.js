// JqueryMask
$(document).ready(function () {
    $('#addCpfColaborador').mask('000.000.000-00');
    $('#addTelefone').mask('0#');
    $('#editCpfColaborador').mask('000.000.000-00');
    $('#editTelefone').mask('0#');
    $('#select-single').select2({
        placeholder: "Vincular Loja",
        minimumInputLength: 2,
        theme: "bootstrap-5",
        ajax: {
            url: '/api/administracao/colaboradores/select2',
            dataType: 'json'
        },
        language: getSelect2LangBR(),
        dropdownParent: $("#modalAdd .modal-body"),
    });
    setMask('add');
    initializePopovers();
    show_hide_password();
});


var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/colaboradores/list',
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
            data: 'id_colaborador'
        },
        {
            data: 'nome_colaborador'
        },
        {
            data: 'telefone'
        },
        {
            data: 'nome_fantasia'
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row, meta) {
                let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Editar" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>`;
                let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-nome-colaborador="${row.nome_colaborador}" data-bs-id="${row.id_colaborador}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` :`<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-nome-colaborador="${row.nome_colaborador}" data-bs-id="${row.id_colaborador}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`
                let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-nome-colaborador="${row.nome_colaborador}" data-bs-id="${row.id_colaborador}" class="btn btn-secondary" title="Remover"><i class="bi bi-trash"></i></button>`;
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
clear_on_close('formAddColaborador', 'modalAdd');
clear_on_close('formEditColaborador', 'modalEdit');
// Submit Form Add
submit_add('formAddColaborador','modalAdd',jquery_datatable, 'Colaborador criado com sucesso!','Erro ao criar Colaborador!',
    () => {
        setTimeout(()=>{
            $('#addTipoPix').prop("selectedIndex", 0);
            $('#select-single').val(null).trigger('change');
        }, 500);
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
submit_remove('formRemoveColaborador', 'modalRemove', jquery_datatable, 
'Colaborador excluída com sucesso!', 'Erro ao excluir colaborador.',
    () => {}, () => {}
);
// Submit Form Block
submit_block('formBlockColaborador', 'modalBlock', jquery_datatable, 
    ['Colaborador desbloqueada com sucesso!', 'Colaborador bloqueada com sucesso!' ] ,
    ['Erro ao desbloquear colaborador.', 'Erro ao bloquear colaborador.'],
    () => {}, () => {}
);

// Submit Form Edit
submit_edit('formEditColaborador', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {}, (r) => { console.log(r) }
);
// ###########################################
/* Abre o edit e joga os dados dentro dos inputs */
jquery_datatable.on('click', 'button.btn-edit', function (e) {
    let data = jquery_datatable.row(e.target.closest('tr')).data();
    console.log($("#modalEdit").find('#formEditColaborador'));
    $("#modalEdit").find('#formEditColaborador input[name="id_colaborador"]').val(data['id_colaborador']);
    $("#modalEdit").find('#formEditColaborador input[name="nome_colaborador"]').val(data['nome_colaborador']);
    $("#modalEdit").find('#formEditColaborador input[name="cpf_responsavel"]').val(data['cpf_responsavel']);
    $("#modalEdit").find('#formEditColaborador input[name="telefone"]').val(data['telefone']);
    $("#modalEdit").find('#formEditColaborador select[name="tipo_pix"]').val(data['tipo_pix']);
    setMask('edit');
    $("#modalEdit").find('#formEditColaborador input[name="chave_pix"]').val(data['chave_pix']);
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditColaborador"]').removeClass('d-none');
    $("#modalEdit").modal('show');
});


$('#modalEdit').on('show.bs.modal', (e) => {
    $('#modalEdit').find('div.alert').remove();
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditColaborador"]').removeClass('d-none');

});

$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveColaborador"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let nome_colaborador = e.relatedTarget.getAttribute('data-bs-nome-colaborador');
    $('#modalRemove').find('strong').html(nome_colaborador);
    $('#modalRemove').find('input[name="id_colaborador"]').val(id);
});

$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockColaborador"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Colaborador');
            $('#modalBlock').find('button[form="formBlockColaborador"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
          break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Colaborador');
            $('#modalBlock').find('button[form="formBlockColaborador"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let nome_colaborador = e.relatedTarget.getAttribute('data-bs-nome-colaborador');
    $('#modalBlock').find('strong').html(nome_colaborador);
    $('#modalBlock').find('input[name="id_colaborador"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});

$('#addTipoPix').on('change', () => {
    setMask('add');
    // let selected = $('#addTipoPix').find('option:selected').val();
    // switch (selected) {
    //     case 'cpf':
    //         $('#addChavePix').mask('000.000.000-00');
    //         $('#addChavePix').attr('type', 'text');
    //         break;
    //     case 'cnpj':
    //         $('#addChavePix').mask('00.000.000/0000-00');
    //         $('#addChavePix').attr('type', 'text');
    //         break;
    //     case 'telefone':
    //         $('#addChavePix').mask('00000000000');
    //         $('#addChavePix').attr('type', 'text');
    //         break;
    //     case 'email':
    //         $('#addChavePix').unmask();
    //         $('#addChavePix').attr('type', 'email');
    //         break;
    //     case 'aleatorio':
    //         $('#addChavePix').mask('AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA');
    //         $('#addChavePix').attr('type', 'text');
    //         break;
    //     default:
    //         console.log(`Erro no tipo de pix`);
    //   }
});

$('#editTipoPix').on('change', () => {
    setMask('edit');
    // let selected = $('#editTipoPix').find('option:selected').val();
    // switch (selected) {
    //     case 'cpf':
    //         $('#editChavePix').mask('000.000.000-00');
    //         $('#editChavePix').attr('type', 'text');
    //         break;
    //     case 'cnpj':
    //         $('#editChavePix').mask('00.000.000/0000-00');
    //         $('#editChavePix').attr('type', 'text');
    //         break;
    //     case 'telefone':
    //         $('#editChavePix').mask('00000000000');
    //         $('#editChavePix').attr('type', 'text');
    //         break;
    //     case 'email':
    //         $('#editChavePix').unmask();
    //         $('#editChavePix').attr('type', 'email');
    //         break;
    //     case 'aleatorio':
    //         $('#editChavePix').mask('AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA');
    //         $('#editChavePix').attr('type', 'text');
    //         break;
    //     default:
    //         console.log(`Erro no tipo de pix`);
    //   }
});

function setMask(option){
    let selected = $('#'+option+'TipoPix').find('option:selected').val();
    switch (selected) {
        case 'cpf':
            $('#'+option+'ChavePix').mask('000.000.000-00');
            $('#'+option+'ChavePix').attr('type', 'text');
            break;
        case 'cnpj':
            $('#'+option+'ChavePix').mask('00.000.000/0000-00');
            $('#'+option+'ChavePix').attr('type', 'text');
            break;
        case 'telefone':
            $('#'+option+'ChavePix').mask('00000000000');
            $('#'+option+'ChavePix').attr('type', 'text');
            break;
        case 'email':
            $('#'+option+'ChavePix').unmask();
            $('#'+option+'ChavePix').attr('type', 'email');
            break;
        case 'aleatorio':
            $('#'+option+'ChavePix').mask('AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA');
            $('#'+option+'ChavePix').attr('type', 'text');
            break;
        default:
            console.log(`Erro no tipo de pix`);
      }
}