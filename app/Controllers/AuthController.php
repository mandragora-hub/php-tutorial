<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
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

    public function signup(Request $request, Response $response, $args)
    {
        User::create([
            'name' => $request->getParsedBody()->username,
            'email' => $request->getParsedBody()->email,
            'password' => password_hash($request->getParsedBody()->password, PASSWORD_DEFAULT),
        ]);

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    }
}
