<?php

/* Funções para criar o Header do Mazer e facilitar a criação de views */
function render_header(string $title = '', string $subtitle = ''){
    $render  = "<div class='col-12 col-md-6 order-md-1 order-last'>";
    $render .= "<h3>$title</h3>";
    $render .= "<p class='text-subtitle text-muted'>$subtitle</p></div>";
    return $render;
}

function render_breadcumb(array $list){
    /* $list = ['Dashboard' => 'link', 'Usuarios' => ''] */
    $render  = "<div class='col-12 col-md-6 order-md-2 order-first'>";
    $render .= "<nav aria-label='breadcrumb' class='breadcrumb-header float-start float-lg-end'>";
    $render .= "<ol class='breadcrumb'>";
    foreach($list as $key => $value){
        if($value === ''){
            $render .= "<li class='breadcrumb-item active' aria-current='page'>$key</li>"; 
        }else{
            $render .= "<li class='breadcrumb-item active'><a href='$value'>$key</a></li>";
        }
    }
    $render .= "</ol></nav></div>";
    return $render;
}
/* Funções de validação de campos usando bootstrap */
function valid_field_bs(&$errorVar, string $field, bool $isClass = true): string
{
    if(isset($errorVar) && array_key_exists($field, $errorVar)){
        if($isClass){
            return 'is-invalid';
        }else{
            return "<div class='text-sm text-danger p-1'>".$errorVar[$field]."</div>";
        }
    }
    return '';
}

/* Funções para criação de componentes do Bootstrap */
function show_alert(string $message, string $type = "danger", bool $dimissible = false){
    $class = $dimissible ? "alert-dismissible fade show" : "";
    $role = $dimissible ? "role='alert'" : "";
    $button = $dimissible ? "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" : "";
    return "<div class='alert alert-$type $class' $role>".$message." $button</div>";
}

function show_alert_if_error(&$errorVar, string $key, bool $dimissible = false): string
{
    if (isset($errorVar) && array_key_exists($key, $errorVar)){
        $class = $dimissible ? "alert-dismissible fade show" : "";
        $role = $dimissible ? "role='alert'" : "";
        $button = $dimissible ? "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" : "";
        return "<div class='alert alert-danger $class' $role>".$errorVar[$key]."$button</div>";
    }
    return '';
}
