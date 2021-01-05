<template>
    <div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-shopping"></i>
                </span> Pilih Kurir
            </h3>
        </div>
        <template v-if="!varTransaksi">
            <profile :bioFalse="true"></profile>
        </template>
        <template v-else>
            <div class="bg-white p-3">
                <div class="form-group">
                    <label>Pilih Kurir Tersedia</label>
                    <select v-model="form.kurir" class="form-control" @change="get_kurir_cost" placeholder="Pilih Kurir">
                        <option value="jne">JNE</option>
                        <option value="tiki">TIKI</option>
                        <option value="pos">POS INDONESIA</option>
                    </select>
                </div>
                <label>Pilih Paket Pengiriman</label>
                <div class="form-group">
                    <div value="" v-if="!modKurir" hidden="" selected="">
                        pilih kurir terlebih dahulu
                    </div>
                    <div class="row">
                        <div class="col-sm" v-for="paket in varPaket">
                            <div class="border  p-2 m-2 rounded">
                                <h4>{{paket.description}}</h4>
                                <div class="m-2">
                                    <div class="mt-1 mb-1 font-weight-bold">
                                        Estimasi Pengiriman :
                                    </div>
                                    {{paket.cost[0].etd}} (Hari)
                                    <div class="mt-1 mb-1 font-weight-bold">
                                        Biaya Pengirman :
                                    </div>
                                    {{paket.cost[0].value | IDR}}
                                </div>
                                <button class="btn bg-gradient-primary btn-sm btn-block text-white" @click="mod_struk_pembayaran(paket)">
                                    Pilih Paket Pengiriman
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <modal name="mod_struk_pembayaran" height="auto" :width="302">
                <div class="modal-header">
                     <i class="fa fa-shopping-basket mr-2"></i> Struk Total Pembayaran
                </div>
                <div class="modal-body">
                    <h5>Item Pembelian</h5>
                    <div class="mb-3" v-for="item  in varTransaksi.get_table_item_dibeli">
                        {{item.nama}} ({{item.berat}}  KG) x  {{item.jumlah}} 
                        <span class="float-right">
                            {{item.total | IDR}}
                        </span>
                    </div>
                    <h5>Paket Pengirman</h5>
                    <div v-if="paket_terpilih">
                        <h4>{{paket_terpilih.description}}</h4>
                        <div class="m-2">
                            <div class="mt-1 mb-1 font-weight-bold">
                                Estimasi Pengiriman :
                            </div>
                            {{paket_terpilih.cost[0].etd}} (Hari)
                            <div class="mt-1 mb-1">
                                Biaya Pengirman :
                                <span class="float-right">{{paket_terpilih.cost[0].value | IDR}}</span>
                            </div>
                        </div>
                        <div class="text-small">Total Pembayaran</div>
                        <h4 class="text-right">{{varTotalHarga+paket_terpilih.cost[0].value | IDR}}</h4>
                        <button class="btn btn-primary btn-block" @click="mod_pembayaran">
                            Lakukan Pembayaran
                        </button>
                    </div>
                </div>
            </modal>
        </template>
    </div>
</template>
<script>
import profile from '../../profile/index'
export default {
    components: {
        profile
    },
    props: ['varTransaksi', 'kd_transaksi'],
    data() {
        return {
            page_transaksi: '/api/transaksi',
            varPaket: [],
            paket_terpilih:false,
            varTotalHarga:'',
            varTotalBerat:'',
            modKurir: false,
            form: new Form({
                kurir: '',
            })
        }
    },
    mounted() {},
    methods: {
        get_kurir_cost() {
            this.$Progress.start()
            axios.get('/api/rajaonkir', {
                    params: {
                        'get': 'pilih_paket',
                        'kurir': this.form.kurir,
                        'kd_transaksi': this.kd_transaksi,
                    }
                })
                .then(({ data }) => {
                    this.$Progress.finish()
                    this.varPaket = data.ongkir.rajaongkir.results[0].costs
                    this.varTotalHarga = data.total_harga
                    this.varTotalBerat = data.total_berat
                    this.modKurir = true;
                })
                .catch((e) => {
                    this.$Progress.fail()
                    this.$error.catch(e);
                })
        },
        mod_struk_pembayaran(paket){
            this.$modal.show('mod_struk_pembayaran')
            this.paket_terpilih = paket
        },
        mod_pembayaran(){
            this.$toast.df200()
            axios.put('/api/transaksi/'+this.kd_transaksi,{
                'paket_pengiriman':this.paket_terpilih,
                'kurir':this.form.kurir,
                'total_berat':this.varTotalBerat,
            })
            .then(()=>{
                this.$toast.df200()
                nv.$emit('updated_transaksi',
                        this.paket_terpilih,
                        this.form.kurir)
            })
            .catch((e)=>{this.$error.catch(e)})
        }
    },
}

</script>
