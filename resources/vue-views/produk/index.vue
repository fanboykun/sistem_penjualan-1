<template>
    <div>
        <transition enter-active-class="animate__animated animate__fadeIn animate__faster">
            <compDetail v-if="modeDetail" :produk="props_produk"></compDetail>
        </transition>
        <transition enter-active-class="animate__animated animate__fadeIn animate__faster">
            <div v-if="!modeDetail">
                <div class="row">
                    <div class="col-sm" style="align-self: center">
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                    <i class="mdi mdi-shopping"></i>
                                </span> Barang
                            </h3>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group">
                            <select name="filter" class="form-control" @change="mode_filter">
                                <option value="">Seluruh data</option>
                                <option v-for="kategori in varKategori.data" :value="kategori.nama">
                                    {{kategori.nama}}
                                </option>
                            </select>
                            <span class="input-group-perepend">
                                <button class="btn btn-primary">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="m-1">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="input_pencarian" @keyup.enter="mode_pencarian" placeholder="Cari berdasarkan nama barang">
                                <span class="input-group-perepend">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div v-if="modePencarian || modeFilter" class="alert alert-primary">
                    Hasil Dari : <span v-if="modePencarian"> {{input_pencarian}} </span>
                    <span v-if="modeFilter"> {{input_kategori}} </span>
                    <i class="fa fa-times float-right" @click="reset"></i>
                </div>
                <div class="row">
                    <div class="col-md-4" v-for="produk in varProduk.data">
                        <div class="card m-2">
                            <div class="m-1 ">
                                <img :src="'/produk/'+ produk.img_1" class="w-100">
                            </div>
                            <div class="p-3">
                                <h4> {{produk.nama}} </h4>
                                <small class="font-weight-bold"> {{produk.tb_kategori.nama}} </small>
                                <div class="font-weight-bold">
                                    <h4> {{produk.harga | IDR}} </h4>
                                </div>
                                <div class="badge badge-danger bg-gradient-danger ">
                                    {{produk.berat}} KG
                                </div>
                                <span v-html="$options.filters.STOK(produk.stok)"></span>
                                <button class="btn btn-block btn-primary btn-sm mb-2" @click="mod_in_troli(produk)">
                                    <i class="mdi mdi-cart mr-2"></i>
                                    Tambahkan
                                </button>
                                <button class="btn btn-block btn-outline-primary btn-sm" @click="mode_detail(produk)">
                                    <i class="fa fa-eye mr-2"></i>
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button @click="load_more" v-if="!hide_loadMore" class="btn text-dark">
                        Tampilkan selanjutnya <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
            </div>
        </transition>

        <modInTroli></modInTroli>
    </div>
</template>
<script>
import compDetail from './detail';
import modInTroli from '../komponen/mod_in_troli';

export default {
    components: {
        modInTroli ,
        compDetail,
    },
    data() {
        return {
            produk_route:'/api/produk',
            varProduk: {},
            varKategori: {},
            props_produk: [],

            input_kategori:'',
            input_pencarian:'',
            modePencarian: false,
            modeDetail: false,
            modeFilter: false,
            load_page: 1,
            hide_loadMore: true,
        }
    },
    created() {
        this.load();
        nv.$on('kembali', () => {
            document.getElementById('title-page').textContent = 'Produk'
            this.modeDetail = false
        })
        document.getElementById('title-page').textContent = 'Produk'
    },
    methods: {
        load() {
            this.$Progress.start();
            axios.get('/api/produk')
                .then(({ data }) => {
                    this.$Progress.finish()
                    this.varProduk = data.varProduk
                    this.varKategori = data.varKategori
                    this.hide_loadMore = false
                    this.cek_hide(this.varProduk,data)
                })
                .catch((e) => {
                    this.$Progress.fail();
                    this.$error.catch(e);
                })
        },
        mode_detail(produk) {
            this.modeDetail = true;
            this.props_produk = produk;

        },
        load_more() {
            this.hide_loadMore=true;
            let kategori
            let pencarian
            let load
            this.load_page += 1
            this.$Progress.start();
            if (this.modeFilter) {
                kategori="&kategori="+this.input_kategori
                load=axios.get('/api/produk?page=' + this.load_page+kategori)
            }else if (this.modePencarian) {
                pencarian="&pencarian="+this.input_pencarian
                load=axios.get('/api/produk?page=' + this.load_page+pencarian)
            }else{
                load=axios.get('/api/produk?page=' + this.load_page)
            }

            load.then(({ data }) => {
                    this.$Progress.finish();
                    for (var i = 0; i < data.varProduk.data.length; i++) {
                        this.varProduk.data.push(data.varProduk.data[i])
                    }
                    if (this.varProduk.data.length == this.varProduk.total) {
                        this.hide_loadMore = true
                    }else{
                        this.hide_loadMore = false
                    }
                })
                .catch((e) => {
                    this.$Progress.fail();
                    this.$error.catch(e);
                })
        },
        mod_in_troli(produk_terpilih){
            nv.$emit('open_troli',produk_terpilih);
        },
        mode_filter(event){
            this.modePencarian=false,
            this.$toast.df102();
            let kategori=event.target.value;
            axios.get(this.produk_route,{
                params:{
                    'kategori':kategori
                }
            })
            .then(({data})=>{
                this.load_page = 1;
                this.input_kategori=kategori;
                this.$toast.df200();
                this.modeFilter=true;
                this.varProduk=data.varProduk
                if (this.varProduk.data.length == data.varProduk.total) {
                    this.hide_loadMore = true
                }else{
                    this.hide_loadMore = false;
                }
            })
        },
        mode_pencarian(){
            this.modeFilter=false,
            this.$toast.df102();
            axios.get(this.produk_route,{
                params:{
                    'pencarian' : this.input_pencarian
                }
            })
             .then(({data})=>{
                this.$toast.df200();
                this.load_page = 1;
                this.modePencarian=true;
                this.varProduk=data.varProduk
                this.cek_hide(this.varProduk,data)
                
            })
            .catch((e)=>{
                this.$error.catch(e);
            })
        },

        reset(){
            this.load_page = 0;
            this.hide_loadMore = false;
            this.input_pencarian='';
            this.input_kategori='';
            this.modePencarian=false;
            this.modeFilter=false;
            this.load();
        },

        cek_hide(varProduk,data){
            if (varProduk.data.length == data.varProduk.total) {
                this.hide_loadMore = true
            }else{
                this.hide_loadMore = false;
            }            
        }


    },
}

</script>
