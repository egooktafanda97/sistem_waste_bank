<?php
function api_url()
{
    return "https://bidangsampahdlhpelalawan.com/rest/";
}

function auth()
{
    $CI = &get_instance();
    $CI->load->library('session');
    $sesion = $CI->session->userdata("login");
    return $sesion;
}

function dump($args)
{
    echo json_encode($args);
}
