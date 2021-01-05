<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\bioRepos;
class bioController extends Controller
{
	private $bio;

	public function __construct(bioRepos $bio)
	{
		$this->bio=$bio;
	}

	public function create(Request $request)
	{
		return $this->bio->membuatBio($request);
	}

	public function store(Request $request)
	{
		return $this->bio->menyimpanBio($request);
	}

    
}
