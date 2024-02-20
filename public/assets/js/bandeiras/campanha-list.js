var jquery_datatable = $("#table1").DataTable({
    dom: "<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-3'lf>t<'d-flex flex-sm-row flex-column align-items-center justify-content-between gap-2 my-2'ipr>",
    ajax: '/bandeira/campanha/list',
    columns: [
        {
            data: 'id_campanha',
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
            data: 'status',
            render: function(data, type, row, meta){
                console.log("Status: ", data);
                switch (data) {
                    case '0':
                        return "Aguardando comprovante"
                        break;
                
                    default:
                        return "Dados inconsistentes"
                        break;
                }
            }
        },
        {
            data: null,
            orderable: false,
            render: function(data, type, row, meta) {
                let buttons = "";
                switch (row.status) {
                    case '0':
                        buttons = `<button type="button" class="btn btn-primary btn-edit mb-1 ml-1"  title="Anexar comprovante" data-bs-toggle="modal" data-bs-target="#modalComprovante"><i class="bi bi-file-earmark-image"></i></button>`; 
                        break;
                }
                return `${buttons}`;
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

