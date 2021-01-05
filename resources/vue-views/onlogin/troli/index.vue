<template>
    <div>
        <div v-if="!modeDetail">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-shopping"></i>
                    </span> Troli Belanjaan
                </h3>
            </div>
            <hr>
            <div class="bg-white p-3">
                <div class="row">
                    <div class="col-sm">
                        <div class="m-1">
                            <button class="btn btn-light btn-sm" type="button">
                                <i class="mdi mdi-cart"></i> Total Barang :
                                {{varTroli.total}} </button>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="m-1">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="m-1">
                            <button class="btn-block btn btn-gradient-danger btn-sm" type="button" @click="$modal.show('mod_checkout')">
                                <i class="mdi mdi-shopping mr-2"></i>
                                Checkout barang</button>
                        </div>
                    </div>
                </div>

                <modal name="mod_checkout" height="auto" :width="312">
                    <template v-if="form.checkOut.length > 0">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Metode Pembayaran</h5>
                            <i class="fa fa-times" @click="$modal.hide('mod_checkout')"></i>
                        </div>
                        <form @submit.prevent="checkout_produk">
                            <div class="modal-body">
                                <select name="metode" class="form-control"  v-model="form.metode" 
                                :class="{'is-invalid':form.errors.has('metode')}">
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="COD">COD(Cash On Delivery)</option>
                                </select>
                                <has-error :form="form" field="metode"></has-error>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-check-circle mr-2"></i> Check Out
                                </button>
                            </div>
                        </form>
                    </template>
                    <template v-else class="text-center">
                        <div class="p-3">
                            Anda harus memilih barang terlebih dahulu untuk di checkout
                        </div>
                    </template>
                    
                </modal>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-stripped">
                        <tr>
                            <th></th>
                            <th class="text-center">#</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Berat</th>
                            <th>jumlah</th>
                            <th>Total Harga Barang</th>
                            <th>Biaya Berat</th>
                            <th>Pembayaran</th>
                            <th class="text-center" width="50"><i class="fa fa-eye"></i></th>
                            <th class="text-center" width="50"><i class="fa fa-edit"></i></th>
                            <th class="text-center" width="50"><i class="fa fa-trash"></i></th>
                        </tr>
                        <tr v-for="(troli,index) in varTroli.data">
                            <td >
                                <template v-if='troli.jumlah > troli.get_table_produk.stok '>
                                    <i class="fa fa-times text-danger"></i>
                                </template>
                                <template v-else>
                                    <input type="checkbox" :id="troli.kd_cart" :value="troli.kd_cart"
                                     v-model="form.checkOut">
                                 </template>
                            </td>
                            <td class="text-center"> {{index+1}} </td>
                            <td> {{troli.get_table_produk.nama}} </td>
                            <td> {{troli.get_table_produk.harga | IDR}} </td>
                            <td> {{troli.get_table_produk.berat}} KG </td>
                            <td> {{troli.jumlah}} </td>
                            <td> {{troli | total_harga_dari_jumlah | IDR}} </td>
                            <td> {{troli | total_harga_dari_berat | IDR}} </td>
                            <td> {{troli | total_keseluruhan_harga | IDR}}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" @click="detail_produk(troli.get_table_produk)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm" type="button"
                                @click="mod_edit(troli)">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <form @submit.prevent="mod_hapus(troli.kd_cart)">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        <tr>
                        <tr v-if="varTroli.total == 0">
                            <td colspan="12" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <transition enter-active-class="animate__animated animate__fadeIn animate__faster">
            <compDetail v-if="modeDetail" :produk="props_produk"></compDetail>
        </transition>
        <modal name="mod_edit" :width="312" :height="'auto'" :shiftY="0.7">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Jumlah</h5>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form @submit.prevent="updateTroli(form_edit.kd_cart)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Jumlah Produk</label>
                        <input type="number" v-model="form_edit.jumlah" required="" class="form-control" :class="{'is-invalide':form_edit.errors.has('jumlah')}">
                    </div>
                    <has-error :form="form_edit" field="jumlah"></has-error>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-gradient-primary btn-sm btn-block">
                        <i class="fa fa-plus-circle mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </modal>
        <div class="text-center">
            <button @click="load_more" v-if="!hide_loadMore" class="btn text-dark">
                Tampilkan selanjutnya <i class="fa fa-chevron-down"></i>
            </button>
        </div>
    </div>
</template>
<script>
import compDetail from '../../produk/detail'
export default {
    components:{
        compDetail,
    },
    data() {
        return {
            page_troli:'/api/troli',
            varTroli:{},
            modeEdit:false,
            modePencarian:false,
            modeDetail:false,
            props_produk:[],
            form:new Form({
                checkOut:[],
                metode:'',
            }),
            form_edit:new Form({
                kd_cart:'',
                jumlah:'',
            }),
            hide_loadMore:true,
            page:1,
        }
    },
    mounted() {
        let page=document.getElementById('title-page').textContent = 'Troli Belanjaan'
        nv.$on('kembali', () => {
            page
            this.modeDetail = false
        })
        page
        this.load_troli();
    },
    methods: {
        load_troli(){
            this.$Progress.start();
            axios.get(this.page_troli)
            .then(({data})=>{
                this.$Progress.finish();
                this.varTroli = data.varTroli
                this.cek_data(this.varTroli)
            })
            .catch((e) => {
                this.$Progress.fail();
                this.$error.catch(e);
            })

        },
        detail_produk(data){
            this.modeDetail=true
            this.props_produk=data;
        },
        mod_edit(troli){
            this.$modal.show('mod_edit')
            this.form_edit.fill(troli)
        },
        updateTroli(kd_cart){
            this.$toast.df102()
            this.form_edit.put(this.page_troli+'/'+kd_cart)
            .then(()=>{
                this.$modal.hide('mod_edit')
                this.$toast.df200()
                this.load_troli()
                this.hide_loadMore = false
            })
            .catch((e)=>{
                this.$error.catch(e)
            })
        },
        checkout_produk(){
            this.$toast.df102();
            this.form.post('/api/transaksi')
            .then((data)=>{
                this.$toast.df200();
                this.$router.push('/transaksi/'+data.data.kd_transaksi)
            })
            .catch((e)=>{
                this.$error.catch(e);
            })
        },

        load_more(){
            this.page += 1;
            axios.get(this.page_troli+'?page='+this.page)
            .then(({data})=>{
                for (var i = 0; i < data.varTroli.data.length; i++) {
                    this.varTroli.data.push(data.varTroli.data[i])
                }
                this.cek_data(this.varTroli)
            })
        },

        mod_hapus(kd_cart){
            this.$toast.df102();
            konfirmasiHapus.fire().then((result)=>{
                if (result.isConfirmed) {
                    axios.delete(this.page_troli+'/'+kd_cart)
                    .then(()=>{
                        this.$toast.df200();
                        this.load_troli();
                    })
                    .catch((e)=>{
                        this.$error.catch(e)
                    })
                }
            })
        },

        cek_data(varTroli){
            if (this.varTroli.data.length == this.varTroli.total) {
                this.hide_loadMore = true
            }else{
                this.hide_loadMore = false
            }
        },


    },
    filters:{
        total_harga_dari_jumlah:(troli)=>{  
            return troli.jumlah * troli.get_table_produk.harga;
        },
        total_harga_dari_berat:(troli)=>{
            return troli.jumlah * 5000;
        },
        total_keseluruhan_harga:(troli)=>{
            let hargaDariJumlah=  troli.jumlah * troli.get_table_produk.harga;;
            let hargaDariBerat= troli.jumlah * 5000;
            let total= hargaDariJumlah + hargaDariBerat;
            return total
        }
    }
}

</script>
