<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\transaksiRepos;
use App\Model\Transaksi;

class transaksiController extends Controller
{

    private $transaksi;

    public function __construct(transaksiRepos $transaksi)
    {
        $this->transaksi=$transaksi;
    }

    public function index(Request $request)
    {
        $varTransaksi=$this->transaksi->indexTransaksi($request);
        $toPending=$this->transaksi->indexTransaksi($request)->where('status',0)->count();
        $toUsai=$this->transaksi->indexTransaksi($request)->where('status',3)->count();
        return compact('varTransaksi','toPending','toUsai');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validasi($request);
        return $this->transaksi->checkOutTransaksi($request);
    }

    public function show($kd_transaksi)
    {
        $transaksi=$this->transaksi->detailTransaksi($kd_transaksi);
        $getCity='';
        if ($transaksi) {
            $varTransaksi=$transaksi;
        }else{
            $varTransaksi=false;
        }
        return compact('varTransaksi');
    }

    public function update(Request $request, $id)
    {
        $this->validasi($request);
        return $this->transaksi->updateTransaksi($request,$id);
    }

    public function destroy($id)
    {
        //
    }

    public function validasi($request)
    {
        $validasi=[];
        
        if ($request->img_bukti) {
            $validasi=['img_bukti'=>'required'];
        }

        if ($request->metode) {
            $validasi=['metode'=>'required'];
        }

        return $this->validate($request,$validasi);
    }

    public function getCity()
    {
        return json_decode(
                \Http::get('https://api.rajaongkir.com/starter/city',[
               "content-type"=>"application/x-www-form-urlencoded",
               "key" =>'ce416f2d7e90b0f167037149f5bc1680',
            ]));   
    }

    public function getProvince()
    {
        return json_decode(
                \Http::get('https://api.rajaongkir.com/starter/province',[
               "content-type"=>"application/x-www-form-urlencoded",
               "key" =>'ce416f2d7e90b0f167037149f5bc1680',
            ]));   
    }
}
