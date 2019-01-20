<?php

$router->get('', 'TestsController@index');
$router->get('test/fill', 'TestsController@fill');
$router->post('test/start', 'TestsController@start');

$router->post('answer/save', 'AnswersController@save');

$router->get('result/show', 'ResultsController@show');
$router->get('result/store', 'ResultsController@store');
