<?php

namespace App\Controllers;

use Core\BaseController;

class PostController extends BaseController
{
    public function index()
    {
        echo 'Posts';
    }

    public function findById($id, $request)
    {
        echo '<pre>';
        echo 'Post '.$id;
        echo '<br>';
        print_r($request->get->nome);
        echo '</pre>';
    }
}
