// JqueryMask
$(document).ready(function () {
    $('#addCpfForn').mask('000.000.000-00');
    $('#addCnpjForn').mask('00.000.000/0000-00');
    $('#editCpfForn').mask('000.000.000-00');
    $('#editCnpjForn').mask('00.000.000/0000-00');
    $("#addNegociacaoFornecedor").mask('##0,00', {reverse: true});
    $("#editNegociacaoFornecedor").mask('##0,00', {reverse: true});
    initializePopovers();
    show_hide_password();
});

var jquery_datatable = $("#tableFornecedores").DataTable({
    
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/fornecedores/list',
    columns: [
    {
        data: 'verificado',
        orderable: false,
        render: function(data, type, row, meta) {
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
        data: 'id_fornecedor'
    },
    {
        data: 'razao_social'
    },
    {
        data: 'nome_responsavel'
    },
    {
        data: 'descricao'
    },
    {
        data: 'cnpj'
    },
    {
        data: null,
        orderable: false,
        render: function (data, type, row, meta) {
            let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1" data-bs-toogle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>`;
            let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-name="${row.nome_responsavel}" data-bs-id="${row.id_fornecedor}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` :`<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-name="${row.nome_responsavel}" data-bs-id="${row.id_fornecedor}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`;
            let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-nome="${row.nome_responsavel}" data-bs-id="${row.id_fornecedor}"><i class="bi bi-trash"></i></button>`;
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
        });
        jquery_datatable.on('click', 'button.btn-delete', function (e) {
            let data = jquery_datatable.row(e.target.closest('tr')).data();
        });
    }
});
/* Clear form on close */
clear_on_close('formAddFornecedor', 'modalAdd');
// Submit Form Add
submit_add('formAddFornecedor', 'modalAdd', jquery_datatable, 'Fornecedor criado com sucesso!', 'Erro ao criar fornecedor!',
    () => {},
    () => {},
);

// Submit remove Fornecedor
submit_remove('formRemoveFornecedor', 'modalRemove', jquery_datatable, 
'Fornecedor excluído com sucesso!', 'Erro ao excluir fornecedor.',
    () => {}, () => {}
);
// Submit Form Block
submit_block('formBlockFornecedor', 'modalBlock', jquery_datatable, 
    ['Fornecedor desbloqueado com sucesso!', 'Fornecedor bloqueado com sucesso!' ] ,
    ['Erro ao desbloquear fornecedor.', 'Erro ao bloquear fornecedor.'],
    () => {}, () => {}
);
// Submit Form Edit
submit_edit('formEditFornecedor', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {}, () => {}
);
// ###########################################


$('#modalEditFornecedor').on('show.bs.modal', (e) => {
    //$('#modalEditFornecedor').find('div.alert').remove();
    // $('#modalEditFornecedor').find('.form-floating').removeClass('d-none');
    // $('#modalEditFornecedor').find('button[form="formEditFuncionario"]').removeClass('d-none');        
    // let name = e.relatedTarget.getAttribute('data-bs-name');
    // let id = e.relatedTarget.getAttribute('data-bs-id');
    // $('#modalEditFornecedor').find('input[name="id_administrador"]').val(id);
    // $('#modalEditFornecedor').find('input[name="nome_administrador"]').val(name);
});
$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveFornecedor"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let nome = e.relatedTarget.getAttribute('data-bs-nome');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalRemove').find('strong').html(nome);
    $('#modalRemove').find('input[name="id_fornecedor"]').val(id);
});
$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockFornecedor"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Fornecedor');
            $('#modalBlock').find('button[form="formBlockFornecedor"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
          break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Fornecedor');
            $('#modalBlock').find('button[form="formBlockFornecedor"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let name = e.relatedTarget.getAttribute('data-bs-name');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalBlock').find('strong').html(name);
    $('#modalBlock').find('input[name="id_fornecedor"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});

/* Abre o edit e joga os dados dentro dos inputs */
jquery_datatable.on('click', 'button.btn-edit', function (e) {
    /* Apaga Alterações */
    $('#modalEdit').find('div.alert').remove();
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('.input-group').removeClass('d-none');
    $('#modalEdit').find('*[form="formEditFornecedor"]').removeClass('d-none');
    /* Adiciona dados ao Formulario */
    let data = jquery_datatable.row(e.target.closest('tr')).data();
    $("#modalEdit").find('input[name="id_fornecedor"]').val(data['id_fornecedor']);
    $("#modalEdit").find('input[name="nome_responsavel"]').val(data['nome_responsavel']);
    $("#modalEdit").find('input[name="cpf_responsavel"]').val(data['cpf_responsavel']);
    $("#modalEdit").find('input[name="razao_social"]').val(data['razao_social']);
    $("#modalEdit").find('select[name="tipo_fornecedor"] option').each(function() {
        if( $(this).text().trim() == data['descricao'] ){
            $(this).prop('selected', true);
        }
    });
    $("#modalEdit").find('input[name="cnpj"]').val(data['cnpj']);
    let negociacao = data['negociacao'].replace(".", ",");
    $("#modalEdit").find('input[name="negociacao"]').val(negociacao);
    $("#modalEdit").modal('show')
});