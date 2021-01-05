<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Produk;

use App\Repositories\produkRepos;
use App\Repositories\kategoriRepos;

class produkController extends Controller
{
    private $produk;
    private $kategori;

    public function __construct(produkRepos $produk,kategoriRepos $kategori)
    {
        $this->produk=$produk;
        $this->kategori=$kategori;
    }

    public function index(Request $request)
    {
        $varProduk=$this->produk->indexProduk($request);
        $varKategori=$this->kategori->indexKategori();
        return compact('varProduk','varKategori');
    }

    public function store(Request $request)
    {
        $this->validasi($request);
        return $this->produk->tambahProduk($request);
    }

    public function update(Request $request, $kd_produk)
    {
        $this->validasiupdate($request);
        $this->produk->updateProduk($request,$kd_produk);
    }


    public function destroy(Request $request,$kd_produk)
    {
        if ($kd_produk == 'multi') {
            return $this->produk->hapusGandaProduk($request,$kd_produk);
        }   
        return $this->produk->hapusProduk($kd_produk);
    }


    public function validasi($request)
    {
        $this->validate($request,[
        'fk_kd_kategori'=>'required',
        'nama'=>'required|max:100',
        // 'deskripsi'=>'max:255',
        'img_1'=>'required',
        'stok'=>'required|numeric|digits_between:1,3',
        'harga'=>'required',
        'berat'=>'required|numeric|digits_between:1,3',
        ]);
    }

    public function validasiupdate($request)
    {
        $this->validate($request,[
        'fk_kd_kategori'=>'required',
        'nama'=>'required|max:100',
        'deskripsi'=>'max:255',
        'stok'=>'required|numeric|digits_between:1,3',
        'harga'=>'required',
        'berat'=>'required|numeric|digits_between:1,3',
        ]);
    }
}
