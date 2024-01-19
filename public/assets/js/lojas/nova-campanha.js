function is_valid_date(value){
    const regexExp = /(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})/gi;
    if(regexExp.test(value)){
        return true; 
    }
    return false;
}

function is_date_gretter(value, min_date){
    let value_formated = format_date(value);
    let min_date_formated = format_date(min_date);
    let value_date = new Date(value_formated);
    let min_date_date = new Date(min_date_formated);
    if(value_date > min_date_date){
        return true;
    }
    return false;
}

function format_date(value){
    let dateAux = value.split('/');
    let newDate = `${dateAux[2]}-${dateAux[1]}-${dateAux[0]}`;
    return newDate;
}

function add_product(product){
    let id = product.split(":")[0];
    let ean = product.split(":")[1];
    let value = product.split(":")[3];
    let qtd = product.split(":")[4];
    let inputs = $("#inputsProducts").find(`input[data-ean="${ean}"]`);
    console.log(inputs);
    if(inputs.length > 0){
        console.log("Ja existe!");
    }else{
        $("#inputsProducts").append(`<input type="hidden" data-ean="${ean}" data-fields="${product}" name="produtos[]" value="${id}:${value}:${qtd}">`);
        console.log("Não existe!");
    }
}

function reload_products_list(){
    let inputs = $("#inputsProducts").find(`input[type='hidden']`);
    let products_size = 0;
    let total = 0.00;
    if(inputs.length > 0){
        $('#listaProdutosArea p').addClass('d-none');
        $('#listaProdutosArea table tbody').html("");
        let html = "";
        inputs.each((element) => {
            let val = inputs[element].dataset.fields;
            let split = val.split(":");
            let tr = `<tr>
            <td>${split[1]}</td>
            <td>${split[2]}</td>
            <td>${split[3]}</td>
            <td>${split[4]}</td>
            <td><button class="btn btn-danger btn-rm-produto" data-ean="${split[1]}"><i class="bi bi-trash"></i></button></td></tr>`;
            html += tr;
            products_size++;
            total += parseFloat(split[3].replace(',','.')) * parseFloat(split[4]);
        });
        $('#listaProdutosArea table tbody').html(html);
        $('#listaProdutosArea table').removeClass("d-none");
        document.querySelectorAll('.btn-rm-produto').forEach((el) => {
            el.addEventListener('click', (e) => {
                let ean = e.currentTarget.dataset.ean;
                $(`#inputsProducts input[data-ean='${ean}']`).remove();
                reload_products_list();
            });
        });
    }else{
        $('#listaProdutosArea p').removeClass('d-none');
        $('#listaProdutosArea table').addClass('d-none');
    }
    $("#addQtdProdutos").val("Quantidade de produtos: " + products_size);
    let percent = $("input[name='percent']").val();
    let negociacao = $("input[name='negociacao']").val();
    let discount = parseFloat((total * negociacao) / 100);
    let total_discount = parseFloat(total - discount);
    let total_ac = parseFloat(total_discount + ((total_discount *  percent) / 100));
    console.log(total_ac);
    let discout_text = (negociacao == 0.00) ? "" : `- ${negociacao}%`;
    $("#addTotalCampanha").val(`Total da campanha: R$ ${total} ${discout_text} + ${percent}% = ${total_ac} R$`);
}

function delete_product(ean){
    let input = $(`#inputsProducts input[data-ean="${ean}"]`);
    console.log(input);
}

$(document).ready(function () {
    $("#addDataInicio").mask("00/00/0000", {placeholder: "__/__/____"});
    $("#addDataFinal").mask("00/00/0000", {placeholder: "__/__/____"});
    $("#eanSearch").mask("0#");
    $("#eanValue").mask("#.##0,00", {reverse: true});
    $("#eanQtd").mask("0#");
});

/* Check Negociação */
$('#addCheckNegociacao').on('change', () => {
    if($('#addCheckNegociacao').is(":checked")){
        $("#addNegociacao").removeAttr("disabled");
    }else{
        $("#addNegociacao").prop("disabled", true);
        $("#addNegociacao").val("");
    }
})

$("#addDataInicio").on('keyup', () => {
    let val = $("#addDataInicio").val();
    if(!is_valid_date(val)){
        $(".invalid-feedback[data-field='data_inicio']").text("Forneça uma data válida!");
        $("#addDataInicio").addClass('is-invalid');
        $("#addDataFinal").prop("disabled", true);
        $("#addDataFinal").val("");
        $("#addDataFinal").removeClass('is-invalid is_valid');
    }else{
        // Se a data for maior que a data de hoje
        let today = new Date(Date.now()).toLocaleString("pt-br").split(" ")[0].replace(",","");
        if(!is_date_gretter(val, today)){
            $(".invalid-feedback[data-field='data_inicio']").text("Forneça uma data superior a data atual!");
            $("#addDataInicio").addClass('is-invalid');
            $("#addDataFinal").prop("disabled", true);
            $("#addDataFinal").val("");
            $("#addDataFinal").removeClass('is-invalid is_valid');
        }else{
            $("#addDataInicio").removeClass('is-invalid');
            $("#addDataInicio").addClass('is-valid');
            $("#addDataFinal").removeAttr("disabled");
        }
    }
})

$("#addDataFinal").on('keyup', () => {
    let val = $("#addDataFinal").val();
    if(!is_valid_date(val)){
        $(".invalid-feedback[data-field='data_final']").text("Forneça uma data válida!");
        $("#addDataFinal").addClass('is-invalid');
    }else{
        // Se a data for maior que a data de hoje
        let inicial = $("#addDataInicio").val();
        if(!is_date_gretter(val, inicial)){
            $(".invalid-feedback[data-field='data_final']").text("Forneça uma data superior a data inicial!");
            $("#addDataFinal").addClass('is-invalid');
        }else{
            console.log("É maior")
            $("#addDataFinal").removeClass('is-invalid');
            $("#addDataFinal").addClass('is-valid');
        }
    }
});


/** Pesquisa produtos */
function searchProduct(){
    let value = $("#eanSearch").val();
    if(value.length > 2){
        $.ajax({
            type: 'get',
            url: '/loja/pesquisa/produtos',
            data: {'ean': value},
            beforeSend: () => {
                
            },
            success: (result) => {
                if(result.results.length === 0){
                    $('#searchResultArea p').removeClass('d-none');
                    $('#searchResultArea table').addClass('d-none');
                }else{
                    $('#searchResultArea p').addClass('d-none');
                    $('#searchResultArea table tbody').html("");
                    let html = '';
                    result.results.forEach(element => {
                        let tr = `<tr><td class="el-aen">${element.ean}</td><td class="el-desc">${element.descricao_produto}</td><td><button class="btn btn-primary btn-add-produto" data-id="${element.id}" data-ean="${element.ean}" data-desc="${element.descricao_produto}"><i class="bi bi-plus"></i></button></td></tr>`;
                        html += tr;
                    });
                    $('#searchResultArea table tbody').html(html);
                    $('#searchResultArea table').removeClass('d-none');
                    document.querySelectorAll('.btn-add-produto').forEach(el => {
                        el.addEventListener('click', (e) => {
                            $("#eanQtd").removeClass("is-invalid");
                            $("#eanValue").removeClass("is-invalid");
                            let id = e.currentTarget.dataset.id;
                            let ean = e.currentTarget.dataset.ean;
                            let desc = e.currentTarget.dataset.desc;
                            let value = $("#eanValue").val();
                            let qtd = $("#eanQtd").val();
                            if(value !== "" && qtd !== ""){
                                add_product(`${id}:${ean}:${desc}:${value}:${qtd}`);
                            }else{
                                $("#eanQtd").addClass("is-invalid");
                                $("#eanValue").addClass("is-invalid");
                            }
                            reload_products_list();
                        });
                    });
                }
            },
            error: (result) => {
                console.log(result);
            },
            complete: () => {
                
            }
        });
    }else{
        $('#searchResultArea p').addClass('d-none');
        $('#searchResultArea table').addClass('d-none');
    }
}

$("#eanSearch").on('change keyup', () => {
    searchProduct();
});


// $('#formAddCampanha').on('submit', function (e) {
//     e.preventDefault();
//     $("#addDataInicio").parent().addClass('is_invalid');
//     $(".invalid-feedback[data-field='data_inicio']").text("Forneça uma data válida!");
// });

$('#formAddProduto').on('submit', function (e) {
    e.preventDefault();
    $('#formAddProduto').find('div.alert').remove();
    form_clean_validation("formAddProduto");
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize(),
        beforeSend: () => {
            loading_modal("formAddProduto", true, false);
        },
        success: (result) => {
            let ean = $('#addEanProduto').val();
            form_clean_validation('formAddProduto');
            $(this).prepend(`<div class="alert alert-success alert-dismissible show fade">
                Produto cadastrado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
            loading_modal("formAddProduto", false, true);
            $("#eanSearch").val(ean);
            searchProduct();
        },
        error: (result) => {
            loading_modal("formAddProduto", false, false);
            if (result.responseJSON.messages) {
                show_errors('formAddProduto', result.responseJSON.messages);
            } else {
                $('#formAddProduto').find('div.alert').remove();
                $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                    Erro ao cadastrar produto!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
            }
        }
    });
});

$("#formAddCampanha").on("submit", (e) => {
    e.preventDefault();
    let checked = $("#addCheckNegociacao").is(':checked');
    $('#formAddCampanha').find('div.alert').remove();
    form_clean_validation("formAddCampanha");
    $.ajax({
        type: $("#formAddCampanha").attr('method'),
        url: $("#formAddCampanha").attr('action'),
        data: $("#formAddCampanha").serialize(),
        beforeSend: () => {
            loading_modal("formAddCampanha", true, false);
        },
        success: (result) => {
            form_clean_validation('formAddCampanha');
            // $("#formAddCampanha").prepend(`<div class="alert alert-success alert-dismissible show fade">
            //      Campanha cadastrada com sucesso!
            //  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            //  </div>`);
            loading_modal("formAddCampanha", false, true);
            $("#addDataInicio").removeClass('is-valid is-invalid');
            $("#addDataFinal").removeClass('is-valid is-invalid');
            $("#addDataFinal").prop("disabled", true);
            $("#inputsProducts").html("");
            $("#eanSearch").val("");
            $("#eanQtd").val("");
            $("#eanValue").val("");
            searchProduct();
            reload_products_list();
            $('#modalInfo').modal('show');
        },
        error: (result) => {
            loading_modal("formAddCampanha", false, false);
            console.log(result);
            if (result.responseJSON.messages) {
                show_errors('formAddCampanha', result.responseJSON.messages);
                if($("#addDataInicio").val() === ""){
                    $("#addDataFinal").prop("disabled", true);
                }
                if(checked){
                    $("#addCheckNegociacao").prop("checked", true);
                }else{
                    $("#addNegociacao").prop("disabled", true);
                }
                if(result.responseJSON.messages.produtos){
                    $("#addQtdProdutos").addClass("is-invalid");
                }
            } else {
                $('#formAddProduto').find('div.alert').remove();
                $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                    Erro ao cadastrar campanha!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
            }
        }
    });
});