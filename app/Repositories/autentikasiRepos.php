<?php 

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class autentikasiRepos
{
	public function store($request)
	{
		$data=$request->all();
		$data['kd_user'] = '001_'.time();;
		$data['password']=Hash::make($data['password']);
		User::create($data);
	}
}