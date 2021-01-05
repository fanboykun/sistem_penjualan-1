<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Troli;
use App\Repositories\troliRepos;

class troliController extends Controller
{
	private $troli;

    public function __construct(troliRepos $troli)
    {
    	$this->troli=$troli;
    }

    public function index(Request $request)
    {
    	$varTroli=$this->troli->indexTroli($request);
        return compact('varTroli');
    }

    public function store(Request $request)
    {
        $this->validasi($request);
    	$this->troli->tambahTroli($request);
    }

    public function update(Request $request,$kd_cart)
    {
        $this->validasi($request);
        $this->troli->updateTroli($request,$kd_cart);
    }

    public function destroy(Request $request,$id)
    {
    	if ($request->multi) 
    	{
    		return $this->troli->hapusGandaTroli($request);
    	}else{
    		return $this->troli->hapusTroli($id);
    	}
    }
    public function validasi($request)
    {
        $this->validate($request,[
            'jumlah'=>'required|numeric'
        ]);
    }
}

