<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Model\Produk;
use App\rootConfig;
Use Image;
class produkRepos  extends  rootConfig
{
    public function indexProduk($request)
    {
    	$kategori=['fk_kd_kategori',$request->kategori];
    	$varProduk=$this->query();

		if ($request->pencarian) {
			$varProduk=$this->query()->where('nama','ILIKE','%'.$request->pencarian.'%');
		}

		if ($request->kategori) {
			$varProduk->whereIn('fk_kd_kategori',$this->filterByKategori($request));
		}

		return $varProduk->paginate(10);
    }

    public function tambahProduk($request)
	{		
		$data=$request->all();
		$data['kd_produk']='1618_'.time();
		$data['fk_kd_admin']=$this->adminLogin()->kd_admin;

		$data['img_1']=$this->pengelolaGambar($request->img_1);

		if ($request->img_2) {
			$data['img_2']=$this->pengelolaGambar($request->img_2);
		}

		if ($request->img_3) {
			$data['img_3']=$this->pengelolaGambar($request->img_3);
		}

		return Produk::create($data);
	}
	public function updateProduk($request,$kd_produk)
	{
		$data=$request->all();
		$produk=Produk::find($kd_produk);
		$folder=$this->membuatFolder('/produk/');

		if (strlen($request->img_1) > 20) {
			$data['img_1']=$this->pengelolaGambar($request->img_1);
			$image=$folder.$produk->img_1;
			@unlink($image);
		}
		
		if (strlen($request->img_2) > 20) {
			$data['img_2']=$this->pengelolaGambar($request->img_2);
			$image=$folder.$produk->img_2;
			@unlink($image);
		}

		if (strlen($request->img_3) > 20) {
			$data['img_3']=$this->pengelolaGambar($request->img_3);
			$image=$folder.$produk->img_3;
			@unlink($image);
		}
		$produk->update($data);
	}

	public function hapusProduk($kd_produk)
	{
		$produk=Produk::find($kd_produk);
		$folder=$this->membuatFolder('/produk/');
		for ($i=1; $i <= 3 ; $i++) {
			@unlink($folder.$produk['img_'.$i]);
		}
		$produk->delete();
		
	}

	public function hapusGandaProduk($request)
	{
		foreach ($request->terpilih as $data) {
			$produk=Produk::find($data);
			$folder=$this->membuatFolder('/produk/');
			for ($i=1; $i <= 3 ; $i++) {
				@unlink($folder.$produk['img_'.$i]);
			}
			$produk->delete();
		}
	}

	public function query()
	{
		return Produk::orderBy('created_at','DESC')->with('tb_kategori');
	}

	public function membuatFolder($namaFolder)
	{
		$path=public_path().$namaFolder;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
	}

	public function pengelolaGambar($foto)
	{
		$namaFoto= rand(0,999)+time().'.'.explode('/', explode(';',$foto)[0])[1];
        $path=$this->membuatFolder('/produk/');

        $img=Image::make($foto);
        $this->validasiDimensi($img);
        $img->resize(null, 300, function ($constraint) {
		    $constraint->aspectRatio();
		});
		$img->save($path.$namaFoto);
        return $namaFoto;
	}

	public function validasiDimensi($img)
	{
		if ($img->width() != 960 || $img->height() != 720) {
        	abort(400, 'Dimensi gambar ini '.$img->width().'x'. $img->height().' Pastikan dimensi gambar sesuai ketentuan' );
        }
	} 

	public function filterByKategori($request)
	{
		return DB::table('m_kategori')->where('nama',$request->kategori)->select('kd_kategori');
	}
}
