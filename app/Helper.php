<?php

function set_active($path, $active = 'show') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}