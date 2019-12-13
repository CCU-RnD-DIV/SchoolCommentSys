<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** @var Router $router */

use Illuminate\Routing\Router;

$router -> get('/', 'IndexController@Index');
$router -> get('/getPermission', 'LoginController@Index');

$router->get('generalLogin', 'LoginController@generalLogin');

$router->get('generalReg', 'RegisterController@generalReg');
$router->post('generalReg', 'RegisterController@generalRegPost');

$router->get('getPermission', ['as' => 'getPermission', 'uses' => 'LoginController@getPermission']);

$router->get('consoleLogin', 'LoginController@consoleLogin');

$router->post('generalLogin', 'LoginController@CheckGeneralLogin');
$router->post('consoleLogin', 'LoginController@CheckConsoleLogin');

$router -> group(['prefix' => 'console', 'middleware' => 'authConsole'], function (Router $router){

    $router -> get('/', 'AdminController@Console');

    $router -> get('/viewNewProcess', 'AdminController@viewNewProcess');
    $router -> get('/viewFinishedProcess', 'AdminController@viewFinishedProcess');
    $router -> get('/viewAdminProcess', 'AdminController@viewAdminProcess');
    $router -> get('/viewDenyProcess', 'AdminController@viewDenyProcess');
    $router -> get('/viewAllProcess', 'AdminController@viewAllProcess');

    $router -> get('/viewCertainProcess/{id}', ['uses' => 'AdminController@viewCertainProcess', 'as' => 'id']);

    $router -> post('/commentAssign', 'AdminController@commentAssign');
    $router -> post('/modifyStatus', 'AdminController@modifyStatus');
    $router -> post('/commentReply', 'AdminController@commentReply');



});

$router -> group(['prefix' => 'general', 'middleware' => 'authGeneral'], function (Router $router){

    $router -> get('/', 'AdminController@General');

    $router -> get('/addComment', 'AdminController@AddComment');
    $router -> post('/addComment', 'AdminController@AddCommentStore');
    $router -> post('/cancelComment', 'AdminController@AddCommentCancel');

    $router -> get('/dataUsageANC', 'AdminController@dataUsageANC');

    $router -> get('/viewProcess', 'AdminController@viewProcess');
    $router -> post('/viewProcess', 'AdminController@viewProcessModify');

    $router -> get('/viewCertainProcess/{id}', ['uses' => 'AdminController@viewCertainProcess', 'as' => 'id']);

});

