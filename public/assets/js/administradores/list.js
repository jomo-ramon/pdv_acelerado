$(document).ready(function () {
    initializePopovers();
    show_hide_password();
});

var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/administradores/list',
    columns: [
        {
            data: 'verificado',
            orderable: false,
            render: function (data, type, row, meta) {
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
            data: 'id_administrador'
        },
        {
            data: 'nome_administrador'
        },
        {
            data: 'email'
        },
        {
            data: null,
            orderable: false,
            render: function (data, type, row, meta) {
                let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Editar" data-bs-toggle="modal" data-bs-target="#modalEdit" data-bs-id="${row.id_administrador}" data-bs-name="${row.nome_administrador}"><i class="bi bi-pencil"></i></button>`;
                let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-mail="${row.email}" data-bs-id="${row.id_administrador}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` : `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-mail="${row.email}" data-bs-id="${row.id_administrador}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`
                let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-mail="${row.email}" data-bs-id="${row.id_administrador}" class="btn btn-secondary" title="Remover"><i class="bi bi-trash"></i></button>`;
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
clear_on_close('formAddAdministrador', 'modalAdd');
clear_on_close('formEditAdministrador', 'modalEdit');
// Submit Form Add
submit_add('formAddAdministrador', 'modalAdd', jquery_datatable, 
'Administrador criado com sucesso!', 'Erro ao criar administrador!',
    () => {},
    () => {},
);
// Submit Form Remove
submit_remove('formRemoveAdministrador', 'modalRemove', jquery_datatable, 
'Administrador excluído com sucesso!', 'Erro ao excluir administrador.',
    () => {}, () => {}
);
// Submit Form Block
submit_block('formBlockAdministrador', 'modalBlock', jquery_datatable, 
    ['Administrador desbloqueado com sucesso!', 'Administrador bloqueado com sucesso!' ] ,
    ['Erro ao desbloquear administrador.', 'Erro ao bloquear administrador.'],
    () => {}, () => {}
);

// Submit Form Edit
submit_edit('formEditAdministrador', 'modalEdit', jquery_datatable,
'Alterações efetuadas com sucesso!', 'Ocorreu um erro ao efetuar alterações!',
    () => {}, () => {}
);
// ###########################################

$('#modalEdit').on('show.bs.modal', (e) => {
    $('#modalEdit').find('div.alert').remove();
    $('#modalEdit').find('.form-floating').removeClass('d-none');
    $('#modalEdit').find('button[form="formEditAdministrador"]').removeClass('d-none');
    let name = e.relatedTarget.getAttribute('data-bs-name');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalEdit').find('input[name="id_administrador"]').val(id);
    $('#modalEdit').find('input[name="nome_administrador"]').val(name);
});
$('#modalRemove').on('show.bs.modal', (e) => {
    $('#modalRemove').find('div.alert').remove();
    $('.modal-message-delete').removeClass('d-none');
    $('#modalRemove').find('button[form="formRemoveAdministrador"]').removeClass('d-none');
    $('#modalRemove').find('button[data-bs-dismiss="modal"]').html('Não');
    let mail = e.relatedTarget.getAttribute('data-bs-mail');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalRemove').find('strong').html(mail);
    $('#modalRemove').find('input[name="id_administrador"]').val(id);
});
$('#modalBlock').on('show.bs.modal', (e) => {
    $('#modalBlock').find('div.alert').remove();
    $('.modal-message-block').removeClass('d-none');
    $('#modalBlock').find('button[form="formBlockAdministrador"]').removeClass('d-none');
    $('#modalBlock').find('button[data-bs-dismiss="modal"]').html('Não');
    let action = e.relatedTarget.getAttribute('data-bs-action');
    switch (action) {
        case '0':
            $('#modalBlock').find('#modalBlockLabel').html('Desbloquear Administrador');
            $('#modalBlock').find('button[form="formBlockAdministrador"]').text('Desbloquear');
            $('#modalBlock').find('span').html('desbloquear');
            break;
        case '1':
            $('#modalBlock').find('#modalBlockLabel').html('Bloquear Administrador');
            $('#modalBlock').find('button[form="formBlockAdministrador"]').text('Bloquear');
            $('#modalBlock').find('span').html('bloquear');
            break;
    }
    let mail = e.relatedTarget.getAttribute('data-bs-mail');
    let id = e.relatedTarget.getAttribute('data-bs-id');
    $('#modalBlock').find('strong').html(mail);
    $('#modalBlock').find('input[name="id_administrador"]').val(id);
    $('#modalBlock').find('input[name="acao"]').val(action);
});