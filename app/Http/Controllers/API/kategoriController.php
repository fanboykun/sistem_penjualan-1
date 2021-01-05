<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\kategoriRepos;
use Illuminate\Http\Request;


class kategoriController extends Controller
{

	private $kategori;


	public function __construct(kategoriRepos $kategoriRepos)
	{
		$this->kategori=$kategoriRepos;
	}

	public function index(Request $request)
	{
		$this->authorize('admin');
		$varKategori=$this->kategori->indexKategori($request);
		return compact('varKategori');
	}

    public function store(Request $request)
    {
		$this->authorize('admin');
		$this->validasi($request);
		return $this->kategori->tambahKategori($request);
    }

    public function update(Request $request,$kd_kategori)
    {
    	$this->authorize('admin');
    	$this->validasi($request);
    	return $this->kategori->updateKategori($request,$kd_kategori);		
    }
    public function destroy(Request $request,$kd_kategori)
    {
    	$this->authorize('admin');
    	if ($request->terpilih) {
    		return $this->kategori->hapusTerpilih($request);		
    	}
    	return $this->kategori->hapusKategori($kd_kategori);		
    }


    public function validasi($request)
	{
		return $this->validate($request,[
			'nama'=>'required|max:35|unique:m_kategori',
		]);
	}
}
