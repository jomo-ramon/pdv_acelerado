var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/api/administracao/campanhas/list',
    columns: [
        {
            data: 'id_campanha',
            // orderable: false,
            // render: function(data, type, row, meta) {
            //     let status = (data == 'sim') ?
            //         '<span class="badge bg-success" title="Email Verificado"><i class="bi bi-shield-check"></i></span>' :
            //         '<span class="badge bg-info" title="Email não verificado"><i class="bi bi-shield-exclamation"></i></span>';
            //     let blocked = (row.blocked == 1) ? 
            //         '<br/><span class="badge bg-danger mt-1" title="Bloqueado"><i class="bi bi-lock"></i></span>' : 
            //         '<br/><span class="badge bg-success mt-1" title="Desbloqueado"><i class="bi bi-unlock"></i></span>';
            //     return status + blocked; 
            // }
        },
        {
            data: 'nome_campanha'
        },
        {
            data: 'descricao'
        },
        {
            data: 'data_inicio',
            render: function(data, type, row, meta){
                return convert_data_to_br(data);
            }
        },
        {
            data: 'data_final',
            render: function(data, type, row, meta){
                return convert_data_to_br(data);
            }
        },
        {
            data: 'status'
        },
        {
            data: 'observacao',
            // orderable: false,
            // render: function(data, type, row, meta) {
            //     let edit = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Editar" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="bi bi-pencil"></i></button>`;
            //     let block = (row.blocked == 1) ? `<button type="button" class="btn btn-primary mb-1 ml-1"  title="Desbloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" data-bs-action='0'"><i class="bi bi-unlock-fill"></i></button>` :`<button type="button" class="btn btn-primary mb-1 ml-1"  title="Bloquear" data-bs-toggle="modal" data-bs-target="#modalBlock" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" data-bs-action='1'><i class="bi bi-lock-fill"></i></button>`
            //     let trash = `<button type="button" class="btn btn-primary btn-delete mb-1 ml-1"  data-bs-toggle="modal" data-bs-target="#modalRemove" data-bs-razao-social="${row.razao_social}" data-bs-id="${row.id_loja}" class="btn btn-secondary" title="Remover"><i class="bi bi-trash"></i></button>`;
            //     return `${edit} ${block} ${trash}`;
            // }
        },
        {
            data: 'tipo'
        },
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
        // jquery_datatable.on('click', 'button.btn-edit', function(e) {
        //     let data = jquery_datatable.row(e.target.closest('tr')).data();
        //     console.log(data);
        // });
        // jquery_datatable.on('click', 'button.btn-delete', function(e) {
        //     let data = jquery_datatable.row(e.target.closest('tr')).data();
        //     console.log(data);
        // });
    }
});