<template>
    <div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-shopping"></i>
                </span> Daftar Produk
            </h3>
        </div>
        <hr>
        <div class="bg-white p-3">
            <div class="row">
                <div class="col-sm">
                    <div class="m-1">
                        <button class="btn btn-primary btn-block" @click="mod_tambah">
                            <i class="fa fa-plus-circle mr-2"></i> Tambah Produk
                        </button>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="m-1">
                        <div class="input-group">
                            <select  class="form-control" @change="filter_produk">
                                <option value="" selected="" hidden="">Seluruh data</option>
                                <option v-for="kategori in varKategori.data" :value="kategori.nama">
                                    {{kategori.nama}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="m-1">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="pencarian" @keyup.enter="mode_pencarian" placeholder="Cari berdasarkan nama Produk">
                            <span class="input-group-perepend">
                                <button class="btn btn-primary" @click="mode_pencarian">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert mt-3 alert-primary" v-if="modeFilter || modePencarian" >
                Hasil 
                <span v-if="modeFilter">
                    Fitler : {{filter}}
                </span>
                <span v-if="modePencarian">
                    Fitler : {{pencarian}}
                </span>


                <span class="float-right" @click="closeMode">
                    <i class="fa fa-times"></i>
                </span>
            </div>
            <div class="table-responsive mt-3" style="height: 340px; overflow-y: auto;">
                <table class="table table-hover border">
                    <thead>
                        <tr class="text-center">
                            <th width="50"></th>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Berat</th>
                            <th width="50"><i class="fa fa-eye"></i></th>
                            <th width="50"><i class="fa fa-edit"></i></th>
                            <th width="50"><i class="fa fa-trash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(produk,index) in varProduk.data ">
                            <td class="align-middle">
                                <input type="checkbox" :id="produk.kd_produk" :value="produk.kd_produk" v-model="form_terpilih.terpilih" class="form-control">
                            </td>
                            <td class="text-center"> {{index+1}} </td>
                            <td class="text-center"> {{produk.nama}} </td>
                            <td class="text-center"> {{produk.tb_kategori.nama}} </td>
                            <td class="text-center"> {{produk.harga | IDR}}</td>
                            <td class="text-center"> {{produk.stok}}</td>
                            <td class="text-center"> {{produk.berat}} KG</td>
                            <td> <i class="fa fa-eye btn btn-sm btn-primary" @click="mod_detail(produk)"></i> </td>
                            <td> <i class="fa fa-edit btn btn-sm btn-secondary" @click="mod_edit(produk)"></i> </td>
                            <td> <i class="fa fa-trash btn btn-sm btn-danger" @click="mod_hapus(produk)"></i> </td>
                        </tr>
                        <tr v-if="varProduk.total == 0">
                            <td colspan="8" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    </tbody>
                    </tr>
                </table>
            </div>
            <transition enter-active-class="animate__animated animate__fadeIn animate__faster" 
                        leave-active-class="animate__animated animate__fadeOut animate__faster">
                <button class="btn btn-danger mb-2 mt-3  " v-if="form_terpilih.terpilih.length > 0" @click="mod_hapus_ganda()">
                    <i class="fa fa-trash mr-2"></i>
                    Hapus Data Terpilih
                </button>
            </transition>
        </div>
        <pagination :data="varProduk" @pagination-change-page="getResults"></pagination>
        <modal name="detail" :width="'75%'" :height="500"  :shiftY="0.7"  :adaptive="true">
            <div class="container py-4" style="max-height: 450px; overflow-y: auto;">
                <h3>{{detail_produk.nama}}</h3>
                <hr>
                <div class="row">
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1 ">
                            <carousel :per-page="1"  :mouse-drag="true" :autoplay='true' :touchDrag='true' :loop="true" :paginationPadding="0">
                                <slide> 
                                    <img  :src="'produk/'+ detail_produk.img_1" class="w-100">
                                </slide>
                                <slide v-if="detail_produk.img_2">
                                    <img  :src="'produk/'+ detail_produk.img_2" class="w-100">
                                </slide>
                                <slide v-if=" detail_produk.img_3">
                                    <img  :src="'produk/'+ detail_produk.img_3" class="w-100">
                                </slide>
                            </carousel>
                        </div>
                    </div>
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1">
                            <div>
                                Stok:
                                <h5 class="ml-3"> {{detail_produk.stok}}</h5>
                            </div>
                            <div>
                                Harga:
                                <h5 class="ml-3"> {{detail_produk.harga | IDR }}</h5>
                            </div>
                            <div>
                                Berat:
                                <h5 class="ml-3"> {{detail_produk.berat}} KG</h5>
                            </div>
                            <div>
                                Deskrispi: 
                                <strong class="ml-3 d-block text-justify">
                                    {{detail_produk.deskripsi}}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-2">
                <button class="btn btn-secondary btn-sm btn-block d-md-none d-sm-block" @click="$modal.hide('detail')">  Tutup </button>

                <button class="btn btn-secondary btn-sm d-md-block d-none" @click="$modal.hide('detail')">  Tutup </button>
            </div>
        </modal>
        <modal name="kelola_produk" :width="'75%'" :height="500" :shiftY="0.7"  :adaptive="true">
            <form @submit.prevent="modeEdit ? update_produk()  : tambah_produk()">
                <i class="fa fa-times btn border btn-sm float-right" 
                    @click="$modal.hide('kelola_produk')">
                        
                    </i>
                <h5 class="p-3">Kelola Data Produk</h5>
                <hr>
                <div class="container-fluid" style="max-height:350px;overflow-y: auto; ">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" class="form-control" v-model="form.nama" :class="{'is-invalid':form.errors.has('nama')}">
                                <has-error :form="form" field="nama"></has-error>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Kategori Produk</label>
                                <select v-model="form.fk_kd_kategori" :class="{'is-invalid':form.errors.has('fk_kd_kategori')}" class="form-control">
                                    <option v-for="kategori in varKategori.data" :value="kategori.kd_kategori">
                                        {{kategori.nama}}
                                    </option>
                                </select>
                                <has-error :form="form" field="fk_kd_kategori"></has-error>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Berat Produk</label>
                                <div class="input-group">
                                    <input type="number" v-model="form.berat" :class="{'is-invalid':form.errors.has('berat')}" class="form-control" value="1">
                                    <span class="input-group-prepend btn btn-primary">
                                        KG
                                    </span>
                                </div>
                                <has-error :form="form" field="berat"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="m-1">
                                <div class="form-group">
                                    <label for="">Harga Produk</label>
                                    <money class="form-control" v-model="form.harga" :class="{'is-invalid':form.errors.has('harga')}"></money>
                                </div>
                                <has-error :form="form" field="harga"></has-error>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="m-1">
                                <div class="form-group">
                                    <label for="">Stok</label>
                                    <input type="number" class="form-control" v-model="form.stok" :class="{'is-invalid':form.errors.has('stok')}">
                                    <has-error :form="form" field="stok"></has-error>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label> <br>
                        <small> <i>Boleh Kosong</i> </small>
                        <textarea v-model="form.deskripsi" :class="{'is-invalid':form.errors.has('deskripsi')}" class="form-control" rows="10"></textarea>
                        <has-error :form="form" field="deskripsi"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Produk 1</label>
                        
                        <input type="file" @change="gambar_1"  :class="{'is-invalid':form.errors.has('img_1')}" accept="image/jpeg" class="form-control">
                        <i class="text-danger small d-block"> {{skalaGambar}} </i>
                        <has-error :form="form" field="img_1"></has-error>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Lainya (Boleh dikosongkan)</label>
                        <div class="row">
                            <div class="col-sm">
                                <div class="m-1">
                                    <div class="form-group">
                                        
                                        <input type="file" @change="gambar_2" accept="image/jpeg" class="form-control">
                                        <i class="text-danger small d-block"> {{skalaGambar}} </i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="m-1">
                                    <div class="form-group">

                                        <input type="file" @change="gambar_3" accept="image/jpeg" class="form-control">
                                        <i class="text-danger small d-block"> {{skalaGambar}} </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-plus-circle mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
    components: {
        Carousel,
        Slide
    },
    data() {
        return {
            kd_produk:'',
            skalaGambar:'Pastikan Skala Gambar 960 x 720',
            uploadGambar:0,
            detail_produk:[],
            varKategori: [],
            varProduk: {},
            modeEdit: false,
            modePencarian: false,
            modeFilter: false,
            pencarian: '',
            filter:'',
            form: new Form({
                fk_kd_kategori: '',
                nama: '',
                deskripsi: '',
                img_1: '',
                img_2: '',
                img_3: '',
                stok: '',
                harga: '',
                berat: '',
            }),
            form_terpilih: new Form({
                terpilih: [],
            }),

        }
    },
    created() {
        this.load();
        document.getElementById('title-page').textContent='Index Produk'
    },
    methods: {
        load() {
            this.$Progress.start();
            axios.get('/api/index-produk')
                .then(({ data }) => {
                    this.$Progress.finish();
                    this.varKategori = data.varKategori;
                    this.varProduk = data.varProduk;
                })
                .catch((e) => {
                    this.$Progress.fail();
                    this.$error.catch(e);
                })
        },
        mod_tambah() {
            this.modeEdit = false;
            this.$modal.show('kelola_produk');
        },
        mod_edit(produk) {
            this.form.fill(produk);
            this.kd_produk=produk.kd_produk;
            this.modeEdit = true;
            this.$modal.show('kelola_produk');
        },
        mod_detail(produk){
            this.detail_produk=produk;
            this.$modal.show('detail')
        },
        closeMode(){
            this.modeFilter=false
            this.modePencarian=false
            this.filter=''
            this.pencarian=''
            this.load();
        },

        mode_pencarian() {
            axios.get('/api/index-produk', {
                    params:{
                        'pencarian': this.pencarian
                    }
                })
                .then(({ data }) => {
                    this.modePencarian = true;
                    this.varProduk = data.varProduk;
                })
                .catch((e) => {
                    this.$error.catch(e);
                })
        },
        tambah_produk() {
            this.$toast.df102();
            this.form.post('/api/index-produk')
                .then(() => {
                    this.$toast.df200();
                    this.form.reset();
                    this.$modal.hide('kelola_produk');
                    this.load();
                })
                .catch((e) => {
                    this.$error.catch(e);
                })
        },
        update_produk(){
            this.$toast.df102();
            this.form.put('/api/index-produk/'+this.kd_produk)
                .then(() => {
                    this.$toast.df200();
                    this.form.reset();
                    this.$modal.hide('kelola_produk');
                    this.load();
                })
                .catch((e) => {
                    this.$error.catch(e);
                })
        },
        hapus_produk(produk){
            this.$toast.df102();
            let axs;
            axs=axios.delete('/api/index-produk/'+produk);
            if (produk == 'multi') {
                axs=this.form_terpilih.delete('/api/index-produk/'+produk);
            }
            axs.then(()=>{
                this.$toast.df200();
                this.load();
            })
            .catch((e)=>{
                this.$error.catch(e);
            })
        },

        // paginateion : laravel-vue-pagination
        getResults(page = 1) {
            let kategori;
            if (this.modeFilter) {
                 kategori=this.filter;
            }else{
                kategori=''
            }
            // let kategori=this.$router.currentRoute.fullPath.split('/')[1].split('?')[1] || '';
            axios.get('/api/index-produk?page='+page+'&kategori='+kategori)
                .then(response => {
                    this.varProduk = response.data.varProduk;
                });
        },

        filter_produk(event){
            this.$Progress.start();
            let kategori = event.target.value;
            axios.get('/api/index-produk',{
                params:{
                    'kategori':kategori
                }
            }).then(({data})=>{
                this.modeFilter=true;
                this.filter=kategori;
                this.$Progress.finish();
                this.varProduk=data.varProduk;
            }).catch((e)=>{
                this.$error.catch(e)
            })

        },
        mod_hapus(produk){
            konfirmasiHapus.fire().then((result)=>{
                if (result.isConfirmed) {
                    this.hapus_produk(produk.kd_produk);
                }
            })
        },
        mod_hapus_ganda(){
           konfirmasiHapus.fire().then((result)=>{
                if (result.isConfirmed) {
                    this.hapus_produk('multi');
                }
            }) 
        },

        // Gambar
        gambar_1(gambarUp){
            let gambar = gambarUp.target.files[0];
            let reader = new FileReader();
              if (gambar['size'] / 1024 < 2048) {
                reader.onloadend = (file) => {
                    this.form.img_1 = reader.result
                }
                reader.readAsDataURL(gambar);

            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Tidak dapat mengupload pdf lebih dari 2MB !',
                    icon: 'error',
                    confirmButtonText: 'Mengerti'
                })

            }

        },
        gambar_2(gambarUp){
            let gambar = gambarUp.target.files[0];
            let reader = new FileReader();
              if (gambar['size'] / 1024 < 2048) {
                reader.onloadend = (file) => {
                    this.form.img_2 = reader.result
                }
                reader.readAsDataURL(gambar);

            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Tidak dapat mengupload pdf lebih dari 2MB !',
                    icon: 'error',
                    confirmButtonText: 'Mengerti'
                })

            }

        },
        gambar_3(gambarUp){
            let gambar = gambarUp.target.files[0];
            let reader = new FileReader();
              if (gambar['size'] / 1024 < 2048) {
                reader.onloadend = (file) => {
                    this.form.img_3 = reader.result
                }
                reader.readAsDataURL(gambar);

            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Tidak dapat mengupload pdf lebih dari 2MB !',
                    icon: 'error',
                    confirmButtonText: 'Mengerti'
                })

            }

        },

    },
}

</script>

<style>
.page-item.active .page-link {
        border-color: #b66dff;
        background-color:#b66dff !important;
    }
    .page-link{
        color: #b66dff;
    }
</style>