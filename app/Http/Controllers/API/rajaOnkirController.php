<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\rootConfig;
use App\Model\Transaksi;
use App\Model\Bio;
class rajaOnkirController extends Controller
{

	private $root;
	public function __construct(rootConfig $root)
	{
		$this->root=$root;
	}

    public function index(Request $request)
    {
    	$get=$request->get;
 		$transaksi=Transaksi::with('get_table_itemDibeli')->find($request->kd_transaksi);
 		foreach ($transaksi->get_table_itemDibeli as $item) {
 			$data[]=$item->get_table_produk->berat;
 			$total_harga[]=$item->total;
 		}
 		$total_berat=array_sum($data);
 		$total_harga=array_sum($total_harga);
 		$kota_user=Bio::find($this->root->userLogin());

		$ongkir= json_decode(
						\Http::post($this->root->RJO_BASE.'/cost',[
						"content-type"=>"application/x-www-form-urlencoded",
						"key" =>$this->root->RJO,
						'origin'=>$this->lokasiUsaha,
						'destination'=>$kota_user->city_id,
						'weight'=>$total_berat,
						'courier'=>$request->kurir,
					])
				);	
		return compact('transaksi','ongkir','total_harga','total_berat');
    }
}
