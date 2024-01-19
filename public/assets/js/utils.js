/* Clean Validations */
function form_clean_validation(id) {
    let invalid = $(`#${id} .is-invalid`);
    if (invalid.length) {
        invalid.each(element => {
            invalid[element].classList.remove('is-invalid');
        });
    }
    let feedback = $(`#${id} .invalid-feedback`);
    if (feedback.length) {
        feedback.each(element => {
            feedback[element].classList.remove('d-block');
        });
    }
}
/* Clean Inputs */
function clean_inputs(modal_id){
    let modal = document.getElementById(modal_id);
    let inputs = modal.querySelectorAll('form input:not([type="hidden"]), form textarea, form select');
    if (inputs.length > 0) {
        for (let i = 0; i < inputs.length; i++) {
            $(inputs[i]).val('');
        }
    }
}
// Loading modal
function loading_modal(id, loading = true, clean = false) {
    let modal = document.getElementById(id);
    let inputs = modal.querySelectorAll('form input:not([type="hidden"]), form textarea, form select');
    if (inputs.length > 0) {
        for (let i = 0; i < inputs.length; i++) {
            if (loading) {
                $(inputs[i]).attr('disabled', true);
            } else {
                $(inputs[i]).removeAttr('disabled');
            }
            if (clean) {
                $(inputs[i]).val('');
            }
        }
    }
    let buttons = modal.querySelectorAll('.modal-footer button');
    if (buttons.length > 0) {
        last = (buttons.length - 1)
        for (let i = 0; i < buttons.length; i++) {
            let text = $(buttons[i]).text();
            if (loading) {
                $(buttons[i]).attr('disabled', 'true');
                if (i == last) {
                    $(buttons[i]).prepend('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
                }
            } else {
                $(buttons[i]).removeAttr('disabled');
                $(buttons[i]).html(text);
            }
        }
    }
}

/* Show and Hide Password */
function show_hide_password() {
    $("#button-password").click(function () {
        let input = $("input[name='senha']");
        let icon = $('#button-password i');
        console.log(icon);
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
        }
    });
}

/* Show Validation Errors */
function show_errors(modal_id, messages) {
    for (let key in messages) {
        let name = `*[name='${key}']`;
        if ($(name).length) {
            let info;
            if (typeof messages[key] === "object") {
                info = messages[key].join('<br/>');
            } else if (typeof messages[key] === "string") {
                info = messages[key];
            }
            $(name).addClass('is-invalid');
            let feedback = $("#" + modal_id).find(`[data-field='${key}']`);
            if (feedback.length) {
                feedback.addClass('d-block');
                feedback.html(info);
            }
        }
    }
}
/* Select2 in PT-BR */
function getSelect2LangBR() {
    return {
        errorLoading: function () {
            return "Os resultados não puderam ser carregados."
        },
        inputTooLong: function (e) {
            var n = e.input.length - e.maximum, r = "Apague " + n + " caracter";
            return 1 != n && (r += "es")
        },
        inputTooShort: function (e) {
            return "Digite " + (e.minimum - e.input.length) + " ou mais caracteres"
        },
        loadingMore: function () {
            return "Carregando mais resultados..."
        },
        maximumSelected: function (e) {
            var n = "Você só pode selecionar " + e.maximum + " ite"; return 1 == e.maximum ? n += "m" : n += "ns", n
        },
        noResults: function () {
            return "Nenhum resultado encontrado"
        },
        searching: function () {
            return "Buscando..."
        },
        removeAllItems: function () {
            return "Remover todos os itens"
        }
    }
}
/* Initialize Popovers */
function initializePopovers() {
    // Enable Popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
}
/* Clear Form on close */
function clear_on_close(form_id, modal_id, callback = () => {}){
    $('#' + modal_id).on('hide.bs.modal', () => {
        form_clean_validation(form_id);
        clean_inputs(modal_id);
        let select2 = document.querySelectorAll('#' + modal_id + ' .select2');
        select2.forEach((el) => {
            $(el).val(null).trigger('change');
        });
        $('#' + form_id).find('div.alert').remove();
        callback();
    });
}
/* form submit add */
function submit_add(form_id, modal_id, datatables, success_message, error_message, callback_success, callback_error){
    $('#'+ form_id).on('submit', function (e) {
        e.preventDefault();
        form_clean_validation(form_id);
        $('#'+ form_id).find('div.alert').remove();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend: () => {
                loading_modal(modal_id, true, false);
            },
            success: (result) => {
                form_clean_validation(form_id);
                callback_success();
                $(this).prepend(`<div class="alert alert-success alert-dismissible show fade">
                    ${success_message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
                loading_modal(modal_id, false, true);
                datatables.ajax.reload();
            },
            error: (result) => {
                loading_modal(modal_id, false, false);
                callback_error(result);
                if (result.responseJSON.messages) {
                    show_errors(modal_id, result.responseJSON.messages);
                } else {
                    $('#'+ modal_id).find('div.alert').remove();
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${error_message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                }
            }
        });
    });
}

/* Form submit Remove */
function submit_remove(form_id, modal_id, datatables, success_message, error_message, callback_success, callback_error){
    $('#' + form_id).on('submit', function (e) {
        e.preventDefault();
        form_clean_validation(form_id);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend: () => {
                loading_modal(modal_id, true, false);
            },
            success: (result) => {
                form_clean_validation(form_id);
                callback_success();
                $(this).prepend(`<div class="alert alert-success alert-dismissible show fade">
                    ${success_message}
                </div>`);
                $('.modal-message-delete').addClass('d-none');
                $('#' + modal_id).find('button[form="'+form_id+'"').addClass('d-none');
                $('#' + modal_id).find('button[data-bs-dismiss="modal"]').html('Fechar');
                loading_modal(modal_id, false, true);
                datatables.ajax.reload();
            },
            error: (result) => {
                loading_modal(modal_id, false, false);
                callback_error(result);
                if (result.responseJSON.messages) {
                    let messages = result.responseJSON.messages;
                    let info = "";
                    for (let key in messages) {
                        info += messages[$key] + "<br/>";
                    }
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${info}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                } else {
                    $('#' + modal_id).find('div.alert').remove();
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${error_message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                }
            }
        });
    });
}

function submit_block(form_id, modal_id, datatables, success_messages, error_messages, callback_success, callback_error){
    $('#' + form_id).on('submit', function (e) {
        e.preventDefault();
        form_clean_validation(form_id);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend: () => {
                loading_modal(modal_id, true, false);
            },
            success: (result) => {
                form_clean_validation(form_id);
                callback_success();
                let acao = $('#' + form_id + ' input[name="acao"]').val();
                $(this).prepend(`<div class="alert alert-success alert-dismissible show fade">
                    ${success_messages[acao]}
                </div>`);
                $('.modal-message-block').addClass('d-none');
                $('#' + modal_id).find('button[form="'+ form_id +'"').addClass('d-none');
                $('#' + modal_id).find('button[data-bs-dismiss="modal"]').html('Fechar');
                loading_modal(modal_id, false, true);
                datatables.ajax.reload();
            },
            error: (result) => {
                loading_modal(modal_id, false, false);
                callback_error();
                if (result.responseJSON.messages) {
                    let messages = result.responseJSON.messages;
                    let info = "";
                    for (let key in messages) {
                        info += messages[$key] + "<br/>";
                    }
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${info}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                } else {
                    $('#' + modal_id).find('div.alert').remove();
                    let acao = $('#' + form_id + ' input[name="acao"]').val();
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${error_messages[acao]}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                }
            }
        });
    });
}

function submit_edit(form_id, modal_id, datatables, success_message, error_message, callback_success, callback_error, before_send = () => {}){
    $('#'+ form_id).on('submit', function (e) {
        e.preventDefault();
        form_clean_validation(form_id);
        $('#' + form_id).find('div.alert').remove();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend: () => {
                loading_modal(modal_id, true, false);
                before_send();
            },
            success: (result) => {
                form_clean_validation(form_id);
                callback_success();
                $(this).prepend(`<div class="alert alert-success alert-dismissible show fade">
                    ${success_message}
                </div>`);
                $('#' + modal_id).find('.form-floating').addClass('d-none');
                $('#' + modal_id).find('.input-group').addClass('d-none');
                $('#' + modal_id).find('button[form="'+ form_id +'"]').addClass('d-none');
                loading_modal(modal_id, false, true);
                datatables.ajax.reload();
            },
            error: (result) => {
                loading_modal(modal_id, false, false);
                callback_error(result);
                if (result.responseJSON.messages) {
                    show_errors(modal_id, result.responseJSON.messages);
                } else {
                    $('#' + modal_id).find('div.alert').remove();
                    $(this).prepend(`<div class="alert alert-danger alert-dismissible show fade">           
                        ${error_message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                }
            }
        });
    });
}

function convert_data_to_br(date){
    let split = date.split(" ")[0];
    let format = split.split("-");
    return `${format[2]}/${format[1]}/${format[0]}`;
}