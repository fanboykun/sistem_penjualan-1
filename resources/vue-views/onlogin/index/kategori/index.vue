<template>
    <div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-filter"></i>
                </span> Index Kategori
            </h3>
        </div>
        <div class="bg-white p-3">
            <div class="row">
                <div class="col-sm" style="align-self: center">
                    <div class="m-1">
                        <button class="btn btn-primary btn-block" @click="mod_kategori_kelola">
                            <i class="fa fa-plus-circle mr-2"></i> Tambah Kategori
                        </button>
                    </div>
                </div>
                <div class="col-sm" style="align-self: center">
                    <div class="m-1">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="pencarian" placeholder="Cari berdasarkan nama " @keyup.enter="cariKategori">
                            <span class="input-group-perepend">
                                <button class="btn btn-primary" @click="cariKategori">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 mt-2" style="max-height: 402px; overflow-y:auto;">
                <div v-if="pencarian_status" class="alert alert-info ">
                    <i class="fa fa-times float-right cp" @click="reset_pencarian()"></i>
                    Hasil pencarian : {{pencarian}}
                </div>
                <div class="table-responsive mt-3">
                    <table class="table border  table-hover ">
                        <thead>
                            <tr>
                                <th width="50"></th>
                                <th class="text-center" width="50">#</th>
                                <th>Nama</th>
                                <th class="text-center" width="100">
                                    <i class="fa fa-edit"></i>
                                </th>
                                <th class="text-center" width="100">
                                    <i class="fa fa-trash"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(kategori, index) in varKategori.data">
                                <td class="align-middle">
                                    <input type="checkbox" :id="kategori.kd_kategori" :value="kategori.kd_kategori" v-model="form_terpilih.terpilih" class="form-control">
                                </td>
                                <td class="text-center"> {{index+1}} </td>
                                <td> {{kategori.nama}} </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-secondary" @click="edit(kategori)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger" @click="confirm_delete(kategori.kd_kategori)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="varKategori.total == 0">
                                <td colspan="9" class="text-center">
                                    Tidak Ada Data Ditemukan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <transition enter-active-class="animate__animated animate__fadeIn animate__faster" leave-active-class="animate__animated animate__fadeOut animate__faster">
                <button class="btn btn-danger mb-2 mt-3  " v-if="form_terpilih.terpilih.length > 0" @click="confirm_delete_all()">
                    <i class="fa fa-trash mr-2"></i>
                    Hapus Data Terpilih
                </button>
            </transition>
        </div>
        <!-- {{"$varKategory->links()"}} -->
        <modal name="kelola_kategori" :width="'75%'" :height="'auto'">
            <div class="container py-4">
                <div class="row">
                    <div class="col">
                        <h5>Kelola Kategori</h5>
                    </div>
                    <div class="col text-right" @click="$modal.hide('kelola_kategori')">
                        <i class="fa fa-times btn btn-sm btn-outline-secondary"></i>
                    </div>
                </div>
                <hr>
                <form @submit.prevent="modeEdit ? updateKategori() : tambahKategori() ">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" :class="{'is-invalid':form.errors.has('nama')}" v-model="form.nama">
                        <has-error :form="form" field="nama"></has-error>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </modal>
    </div>
</template>
<script>
export default {
    data() {
        return {
            pencarian_status:false,
            kd_kategori: null,
            pencarian: null,
            modeEdit: false,
            form: new Form({
                nama: null,
            }),
            form_terpilih: new Form({
                terpilih: [],
            }),
            varKategori: {},
        }
    },
    mounted() {
        this.load_kategori();
        document.getElementById('title-page').textContent='Index Kategori'
    },
    methods: {
        reset_pencarian(){
            this.pencarian_status = false;
            this.pencarian='';
            this.load_kategori();
        },
        load_kategori() {
            this.$Progress.start()
            axios.get('/api/index-kategori')
                .then(({ data }) => {
                    this.$Progress.finish();
                    this.varKategori = data.varKategori;
                }).catch((e) => {
                    this.$Progress.error();
                    this.$error.catch(e);
                })
        },
        mod_kategori_kelola() {
            this.form.reset()
            this.modeEdit = false;
            this.$modal.show('kelola_kategori');
        },
        tambahKategori() {
            this.$toast.df102();
            this.form.post('/api/index-kategori')
                .then(() => {
                    this.$toast.df200();
                    this.$modal.hide('kelola_kategori');
                    this.reset_pencarian();
                })
                .catch((e) => {
                    this.$error.catch(e);
                })
        },
        updateKategori() {
            this.$toast.df102();
            this.form.put('/api/index-kategori/' + this.kd_kategori)
                .then(() => {
                    this.$toast.df200();
                    this.$modal.hide('kelola_kategori');
                    this.reset_pencarian();
                })
                .catch((e) => {
                    this.$error.catch(e);
                })
        },
        cariKategori() {
            this.$toast.df102();
            axios.get('api/index-kategori', {
                params: {
                    'pencarian': this.pencarian,
                }
            }).then(({ data }) => {
                this.$toast.df200();
                this.pencarian_status=true;
                this.varKategori = data.varKategori;
            }).catch((e) => {
                this.$error.catch(e);
            })
        },
        edit(data) {
            this.kd_kategori = data.kd_kategori;
            this.modeEdit = true;
            this.form.fill(data)
            this.$modal.show('kelola_kategori');
        },
        confirm_delete(kd_kategori) {
            konfirmasiHapus.fire().then((result) => {
                if (result.isConfirmed) {
                    this.$toast.df102();
                    axios.delete('/api/index-kategori/' + kd_kategori)
                        .then(() => {
                            this.$toast.df200();
                            this.reset_pencarian();
                        })
                        .catch((e) => {
                            this.$error.catch(e);
                        })
                }
            })
        },
        confirm_delete_all() {
            konfirmasiHapus.fire().then((result) => {
                if (result.isConfirmed) {
                    this.$toast.df102();
                    this.form_terpilih.delete('/api/index-kategori/multi')
                        .then(() => {
                            this.form_terpilih.reset();
                            this.$toast.df200();
                            this.load_kategori();
                        })
                        .catch((e) => {
                            this.$error.catch(e);
                        })
                }
            })
        }
    },
}

</script>
