<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\autentikasiRepos;
use Illuminate\Http\Request;

class autentikasiController extends Controller
{
    private $autentikasiRepos;

    public function __construct(autentikasiRepos $autentikasiRepos)
    {
    	$this->autentikasiRepos=$autentikasiRepos;
    }

    public function validasiInput($request)
    {
    	$this->validate($request,[
			'nama'=>'required',
			'email'=>'required',
			'username'=>'required|unique:users',
			'password'=>'required',
    	]);
    }

    public function registrasiAutentikasi(Request $request)
    {
    	$this->validasiInput($request);
    	return $this->autentikasiRepos->store($request);
    }
}
