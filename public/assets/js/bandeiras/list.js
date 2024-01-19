// JqueryMask
$(document).ready(function () {
    $('#addCpfBandeira').mask('000.000.000-00');
    $('#editCpfBandeira').mask('000.000.000-00');
    $('#addCnpjBandeira').mask('00.000.000/0000-00');
    $('#editCnpjBandeira').mask('00.000.000/0000-00');
    $("#addNegociacaoBandeira").mask('##0,00', {reverse: true});
    $("#editNegociacaoBandeira").mask('##0,00', {reverse: true});
    $('#addTelefoneBandeira').mask('0#');
    $('#addIeBandeira').mask('0#');
    $('#editIeBandeira').mask('0#');
    initializePopovers();
    show_hide_password();
});

var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/bandeiras/list',
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
            data: 'id_bandeira'
        },
        {
            data: 'nome_bandeira'
        },
        {
            data: 'nome_responsavel'
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row, meta) {
                let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Editar" data-bs-toggle="modal" data-bs-target="#modalEdit" data-bs-id="${row.id_bandeira}" data-negociacao="${row.negociacao}" data-bs-bandeira="${row.nome_bandeira}" data-bs-responsavel="${row.nome_responsavel}" data-bs-cpf="${row.cpf}" data-bs-razao-social="${row.razao_social}" data-bs-cnpj="${row.cnpj}" data-bs-telefone="${row.telefone}" data-bs-ie="${row.ie}"><i class="bi bi-pencil"></i></button>`;
                let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-bandeira="${row.nome_bandeira}" data-bs-id="${row.id_bandeira}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` :`<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-bandeira="${row.nome_bandeira}" data-bs-id="${row.id_bandeira}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`
                let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-bandeira="${row.nome_bandeira}" data-bs-id="${row.id_bandeira}" class="btn btn-secondary" title="Remover"><i class="bi bi-trash"></i></button>`;
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
clear_on_close('formAddBandeira', 'modalAdd');
clear_on_close('formEditBandeira', 'modalEdit');
// Submit Form Add
submit_add('formAddBandeira', 'modalAdd', jquery_datatable, 'Bandeira criada com sucesso!', 'Erro ao criar bandeira!',
    () => {},
    (e) => {console.log(e)},
);
// Submit remove Bandeira
submit_remove('formRemoveBandeira', 'modalRemove', jquery_datatable, 
'Bandeira excluída com sucesso!', 'Erro ao excluir bandeira.',
    () => {}, () => {}
);
// Submit Form Block
submit_block('formBlockBandeira', 'modalBlock', jquery_datatable, 
    ['Bandeira desbloqueada com sucesso!', 'Bandeira bloqueada com sucesso!' ] ,
    ['Erro ao desbloquear bandeira.', 'Erro ao bloquear bandeira.'],
    () => {}, () => {}
);
// Submit Form Edit
submit_edit('formEditBandeira', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {}, () => {}
);
// ###########################################

$('#modalEdit').on('show.bs.modal', (e) => {
    form_clean_validation("formEditBandeira");
    $('#modalEdit').find('div.alert').remove();
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('.input-group').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditBandeira"]').removeClass('d-none');        
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let nome_bandeira = e.relatedTarget.getAttribute('data-bs-bandeira');
    let nome_responsavel = e.relatedTarget.getAttribute('data-bs-responsavel');
    let cpf = e.relatedTarget.getAttribute('data-bs-cpf');
    let razao_social = e.relatedTarget.getAttribute('data-bs-razao-social');
    let cnpj = e.relatedTarget.getAttribute('data-bs-cnpj');
    let telefone = e.relatedTarget.getAttribute('data-bs-telefone');
    let ie = e.relatedTarget.getAttribute('data-bs-ie');
    let negociacao = e.relatedTarget.getAttribute('data-negociacao').replace(".", ",");
    $('#modalEdit').find('input[name="id_bandeira"]').val(id);
    $('#modalEdit').find('input[name="nome_bandeira"]').val(nome_bandeira);
    $('#modalEdit').find('input[name="nome_responsavel"]').val(nome_responsavel);
    $('#modalEdit').find('input[name="cpf"]').val(cpf);
    $('#modalEdit').find('input[name="razao_social"]').val(razao_social);
    $('#modalEdit').find('input[name="cnpj"]').val(cnpj);
    $('#modalEdit').find('input[name="telefone"]').val(telefone);
    $('#modalEdit').find('input[name="ie"]').val(ie);
    $('#modalEdit').find('input[name="negociacao"]').val(negociacao);
});
$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveBandeira"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let bandeira = e.relatedTarget.getAttribute('data-bs-bandeira');
    $('#modalRemove').find('strong').html(bandeira);
    $('#modalRemove').find('input[name="id_bandeira"]').val(id);
});
$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockBandeira"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Usuário');
            $('#modalBlock').find('button[form="formBlockBandeira"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
          break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Usuário');
            $('#modalBlock').find('button[form="formBlockBandeira"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let id = e.relatedTarget.getAttribute('data-bs-id');
    let bandeira = e.relatedTarget.getAttribute('data-bs-bandeira');
    $('#modalBlock').find('strong').html(bandeira);
    $('#modalBlock').find('input[name="id_bandeira"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});