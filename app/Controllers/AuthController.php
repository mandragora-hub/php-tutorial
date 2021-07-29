<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};



class AuthController extends Controller
{
    public function index(Request $request, Response $response, $args)
    {
        return $this->c->get('view')->render($response, 'auth/signup.twig');
    }

    public function signup(Request $request, Response $response, $args) {

    }
}
