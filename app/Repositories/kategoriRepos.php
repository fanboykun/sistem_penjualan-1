<?php 

namespace App\Repositories;

use App\Model\Kategori;


class kategoriRepos
{	
	public function indexKategori($request=null)
	{
		$varKategori=Kategori::orderBy('created_at','DESC')->paginate(25);
		if (@$request->pencarian) {
			$varKategori=Kategori::where('nama','ILIKE','%'.$request->pencarian.'%')->paginate(25);
		}
		return $varKategori;
	}
	public function tambahKategori($request)
	{		
		$data=$request->all();
		$data['kd_kategori']='111_'.time();
		return Kategori::create($data);
	}

	public function updateKategori($request,$kd_kategori)
	{
		$data=$request->all();
		Kategori::find($kd_kategori)->update($data);
	}

	public function hapusKategori($kd_kategori)
	{
		Kategori::find($kd_kategori)->delete();
	}

	public function hapusTerpilih($request)
	{
		foreach ($request->terpilih as $data) {
			Kategori::find($data)->delete();
		}
	}
}