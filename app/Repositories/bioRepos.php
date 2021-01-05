<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\rootConfig;
use App\Model\Bio;
class bioRepos extends rootConfig
{
    public function indexBio()
    {
    	# code...
    }

    public function membuatBio($request)
    {
        if ($request->getKota) {
             return $this->indexKota($request);
        }
        return $this->indexProvinsi();
    }
    public function menyimpanBio($request)
    {
        $bio=new Bio;
        $bio->alamat=$request->alamat;
        $bio->rtrw=$request->rtrw;
        $bio->email=$request->email;
        $bio->no_hp1=$request->no_hp1;
        $bio->no_hp2=$request->no_hp2;
        $bio->kelamin='system';
        $bio->kelurahan=$request->kelurahan;
        $bio->kecamatan=$request->kecamatan;
        $bio->lainya=$request->lainya;
        $bio->fk_kd_user=$this->userLogin();
        $bio->kota=$request['kota']['city_name'];
        $bio->city_id=$request['kota']['city_id'];
        $bio->province_id=$request['kota']['province_id'];
        $bio->provinsi=$request['kota']['province'];
        $bio->save();
    }

    public function indexProvinsi()
    {
		return \Http::get('https://api.rajaongkir.com/starter/province',[
               "content-type"=>"application/x-www-form-urlencoded",
               "key" =>$this->RJO,
        ]);
    }

    public function indexKota($request)
    {
        // $request->getKota
    	return \Http::get('https://api.rajaongkir.com/starter/city',[
               "content-type"=>"application/x-www-form-urlencoded",
               "key" =>$this->RJO,
               "province" =>$request->getKota,
        ]);
    }
}
