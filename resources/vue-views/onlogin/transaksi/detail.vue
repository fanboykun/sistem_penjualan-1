<template>
    <div>
        <template v-if="!varTransaksi.kurir ">
            <pilihKurir :varTransaksi="varTransaksi" :kd_transaksi="parameter" v-if="$akses.isUser()"></pilihKurir>
        </template>
        <template v-else>
            <router-link to="/transaksi" class="text-primary">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </router-link>
            <h3 class="mt-3"> <i class="mdi mdi-cart text-primary mr-2"></i> Detail Transaksi</h3>
            <hr>
            <div class="mb-3 bg-white p-3" >
                <div class="row">
                    <div class="col-sm">
                        <div class="m-1">
                            <i class="fa fa-map mr-2 text-primary"></i> Alamat Pengiriman
                            <div class="p-2  mt-1 rounded">
                                {{varTransaksi.get_tb_bio.alamat}}, {{varTransaksi.get_tb_bio.rtrw}}
                                {{varTransaksi.get_tb_bio.kelurahan}}, {{varTransaksi.get_tb_bio.kecamatan}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="m-1">
                            <i class="fa fa-phone mr-2 text-primary"></i> Nomor Dapat Dihubungi <br>
                            <div class="p-2 ml-3">
                                {{varTransaksi.get_tb_bio.no_hp1}} <br>
                                {{varTransaksi.get_tb_bio.no_hp2}} <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm text-center">
                        <div class="m-1">
                            <label for="">Bukti Pembayaran</label> <br>
                            <button v-if="varTransaksi.img_bukti" class="btn btn-success btn-sm btn-block" @click="mod_cek_upload">
                                <i class="fa fa-check "></i>
                                Bukti
                            </button>
                            <button v-else class="btn btn-danger btn-sm" @click="mod_upload">
                                <i class="fa fa-upload mr-2"></i>
                                Belum Upload Bukti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 mb-3">
                <div class="row">
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1 text-center">
                            <label for=""> Pembayaran </label>
                            <div class="font-weight-bold text-capitalize ">
                                {{varTransaksi.metode}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1 text-center">
                            <label for=""> Transaksi </label>
                            <div class="font-weight-bold">
                                <span v-if="varTransaksi.img_bukti && varTransaksi.status == 0">
                                Menunggu Konfirmasi Bukti Pembayaran
                                </span>
                                <span v-else v-html="$options.filters.bukti_pembayaran(varTransaksi.status)"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1 text-center">
                            <label for=""> Pengiriman </label>

                            <div v-if="varTransaksi.img_bukti && varTransaksi.status == 0">
                                -
                            </div>
                            <div v-else v-html="$options.filters.status_pemesanan(varTransaksi.status)"></div>
                            
                            <span v-if="$akses.admin()" class="badge badge-primary cp mt-2"  @click="op_moda_status">
                               <i class="fa fa-square mr-2"></i> Ubah Status
                            </span>
                            
                        </div>
                    </div>
                    <div class="col-sm" style="align-self: center">
                        <div class="m-1">
                            <div class="text-left">
                                Rekening : <br>
                                12345678 (BCA) <br>
                                Atas Nama : <br>
                                <strong>Fahmi</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3">
                <h5>Daftar Barang</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-stripped">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama</th>
                            <th>Berat</th>
                            <th>Biaya Berat / KG</th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th>Total</th>
                        </tr>
                        <tr v-for="(barang,index) in varTransaksi.get_table_item_dibeli">
                          
                            <td class="text-center"> {{index+1}} </td>
                            <td> {{barang.nama}} </td>
                            <td> {{barang.berat}} KG </td>
                            <td> {{barang.berat*5000 | IDR}} </td>
                            <td> {{barang.harga | IDR}}</td>
                            <td class="text-center"> {{barang.jumlah}}</td>
                            <td>
                                {{(barang.harga*barang.jumlah)+(barang.berat*5000) | IDR}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <modOpenPembayaran :kd_transaksi="parameter"
                                :img="varTransaksi.img_bukti"></modOpenPembayaran>
            <modUpdateStatus :kd_transaksi="parameter"></modUpdateStatus>
        </template>
    </div>
</template>
<script>
import pilihKurir from './komponen/pilih_kurir'
import modOpenPembayaran from './komponen/mod_upload_pembayaran'
import modUpdateStatus from './komponen/open_moda_status'
export default {
    components: {
        modOpenPembayaran,
        modUpdateStatus,
        pilihKurir
    },
    data() {
        return {
            parameter: this.$route.path.split('/')[2],
            page_transaksi: '/api/transaksi',
            varTransaksi: [],

        }
    },
    mounted() {
        this.load_transaksi();
        nv.$on('biodata_true', () => {
            this.load_transaksi()
        })
        nv.$on('updated_transaksi', (paket, kurir) => {
            this.load_updated_transaksi(paket, kurir)
        })
    },
    methods: {
        load_transaksi() {
            this.$Progress.start();
            axios.get(this.page_transaksi + '/' + this.parameter)
                .then(({ data }) => {
                    this.$Progress.finish();
                    this.varTransaksi = data.varTransaksi;
                })
                .catch((e) => {
                    this.$Progress.fail();
                    this.$error.catch(e);
                })
        },

        load_updated_transaksi(paket, kurir) {
            this.varTransaksi.kurir = kurir;
            this.varTransaksi.nama_paket = paket.description;
            this.varTransaksi.estimasi = paket.cost[0].etd;
            this.varTransaksi.biaya_kirim = paket.cost[0].value;
        },
        mod_upload(){
            if (this.$akses.isUser()) {
                nv.$emit('open_mod_pembayaran')
            }
        },
        mod_cek_upload(){
            if (this.$akses.admin()) {
                nv.$emit('open_mod_cek_upload')
            }
        },
        op_moda_status(){
            nv.$emit('open_moda_status')
        }

    },
}

</script>
