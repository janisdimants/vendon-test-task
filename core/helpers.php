<?php

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
function view($name, $data = [])
{
    extract($data);

    return require "app/views/{$name}.view.php";
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path)
{
    header("Location: /{$path}");
}

function dd($variable)
{
    var_dump($variable);
    exit();
}

function getErrorMessage($input_name) 
{
    if (isset($GLOBALS['errors'])) {
        $error = array_filter($GLOBALS['errors'], function ($error) use ($input_name) {
            return $error->input_name == $input_name;
        });
        if (count($error) > 0) {
            return $error[0]->message;
        }
    }
}

function hasError($input_name)
{
    if (isset($GLOBALS['errors'])) {
        $error = array_filter($GLOBALS['errors'], function ($error) use ($input_name) {
            return $error->input_name == $input_name;
        });
        if (count($error) > 0) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
