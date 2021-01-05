<?php

namespace App\Repositories;

use App\rootConfig;
use App\Model\Troli;

class troliRepos extends rootConfig
{
	public function query()
	{
		return Troli::where('fk_kd_user',$this->userLogin());
	}

    public function indexTroli($request)
    {
    	$pencarian=$request->pencarian;


    	$varTroli=$this->query();
    	if ($pencarian) {
    		$varTroli=$this->query()->where('nama',$pencarian);
    	}

    	return $varTroli->with('get_table_produk')->paginate(25);    	
    }

    public function tambahTroli($request)
    {
    	$data=$request->all();
    	$data['kd_cart']='3118_'.time();
    	$data['fk_kd_user']=$this->userLogin();
    	Troli::create($data);
    }


    public function updateTroli($request,$id)
    {
        Troli::find($id)->update($request->all());
    }


    public function hapusTroli($id)
    {
    	Troli::find($id)->delete();
    }

    public function hapusGandaTroli($request)
    {
    	foreach ($request->terpilih as $data) {
    		$this->hapusTroli($data);
    	}
    	
    }
}
