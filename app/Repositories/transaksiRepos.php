<?php

namespace App\Repositories;


use App\Model\Transaksi;
use App\Model\Item_dibeli;
use App\Model\Troli;
use App\Model\produk;
use App\Model\Bio;
use App\rootConfig;
use Image;
class transaksiRepos extends rootConfig
{
    public function query()
    {
      return Transaksi::orderBy('created_at','DESC');   
    }
    
    public function indexTransaksi($request)
    {
        if (!$this->adminLogin()) {
            $this->query()->where('fk_kd_user',$this->userLogin());
        }
        return $this->query()->paginate(25);
    }

    public function checkOutTransaksi($request)
    {
        #membuat data pada table transaksi
        $kd_transaksi=$this->create($request);
    	foreach ($request->checkOut as $data_produk) {
            #membuat data pada table item dibeli
            $this->create_item_dibeli($data_produk,$kd_transaksi);
            #mengurangi jumlah stok pada produk barang
            $this->update_stok_on_produk($data_produk);
            #Menghapus data pada troli yang telah masuk di item di beli
            $this->delete_item_on_troli($data_produk);  
    	}
    	return compact('kd_transaksi');
    }

    public function create($request)
    {
        $data=$request->all();
        $data['kd_transaksi']='2019_'.time();
        $data['fk_kd_user']=$this->userLogin();

        $kd_transaksi=$data['kd_transaksi'];
        $kd_user=$data['fk_kd_user'];
        Transaksi::create($data);
        return $kd_transaksi;
    }

    public function create_item_dibeli($data_produk,$kd_transaksi)
    {
        $troli=Troli::find($data_produk);
        $getKodeDibeli=substr(rand(0,999999)+time(),0,10);
        $produk['kd_dibeli']='412_'.$getKodeDibeli;
        $produk['fk_kd_user']=$this->userLogin();
        $produk['fk_kd_produk']=$troli->fk_kd_produk;
        $produk['jumlah']=$troli->jumlah;
        $produk['harga']=$troli->get_table_produk->harga;
        $produk['total']=$this->getTotalPembayaran($troli);
        $produk['fk_kd_transaksi']=$kd_transaksi;
        Item_dibeli::create($produk);
    }

    public function delete_item_on_troli($data_produk)
    {
        $troli=Troli::find($data_produk);
        $troli->delete();
    }

    public function update_stok_on_produk($data_produk)
    {
        $troli=Troli::find($data_produk);
        $produk_berkurang=Produk::find($troli->get_table_produk->kd_produk);
        $produk_berkurang->stok=$produk_berkurang->stok-$troli->jumlah;
        $produk_berkurang->save();
    }

    public function detailTransaksi($id)
    {   
        $hasil=false;
        if (Bio::find($this->userLogin()) || $this->adminLogin()) {
            $hasil=Transaksi::with('get_table_itemDibeli','get_tb_bio')->findOrFail($id);
        }
        return $hasil;
    }

    public function batalTransaksi($request)
    {
    	# code...
    }

    public function updateTransaksi($request,$id)
    {
        
        $tr=Transaksi::find($id);
        if ($request->img_bukti) {
            $tr->img_bukti=$this->pengelolaGambar($request->img_bukti);
            $tr->save();
            return [200];
        }
        if ($request->ress) {
            $tr->status=$request->ress;
            $tr->save();
            return [200];
        }


        if ($request->update_status) {
            $tr->status=$request->update_status;
            $tr->save();
            return [200];
        }

        $data=$request->paket_pengiriman;
        $tr->nama_paket=$data['description'];
        $tr->biaya_kirim=$data['cost'][0]['value'];
        $tr->estimasi=$data['cost'][0]['etd'];
        $tr->kurir=$request->kurir;
        $tr->total_berat=$request->total_berat;
        $tr->save();
    }

    public function getTotalPembayaran($troli)
    {
    	$getTotalBerat=$troli->jumlah*$troli->get_table_produk->berat;
		$getTotalhargaBerat=$getTotalBerat*5000;
		$getTotalHargaProduk=$troli->jumlah*$troli->get_table_produk->harga;
		return $getTotalHargaProduk+$getTotalhargaBerat;
    }

    public function pengelolaGambar($foto)
    {
        $namaFoto= rand(0,999)+time().'.'.explode('/', explode(';',$foto)[0])[1];
        $path=$this->membuatFolder('/bukti/');

        $img=Image::make($foto);
        $img->save($path.$namaFoto);
        return $namaFoto;
    }

    public function membuatFolder($namaFolder)
    {
        $path=public_path().$namaFolder;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }

}
