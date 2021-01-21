<template>
    <div>
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-shopping"></i>
                </span> Transaksi
            </h3>
        </div>
        <hr>
        <div class="row ">
            <div class="col-md stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal">Total Transaksi
                            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2>{{varTransaksi.total}} </h2>
                    </div>
                </div>
            </div>
            <div class="col-md stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal">Transaksi Pending
                            <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2>{{toPending}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal">Transaksi Selesai
                            <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2>{{toUsai}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-3">
            <div class="row">
                <div class="col-sm">
                    <div class="m-1">
                        <div class="input-group">
                            <select name="filter" class="form-control">
                                <option value="">Seluruh data</option>
                                <option value="pending">Pending</option>
                                <option value="1">Pengemasan</option>
                                <option value="2">Pengiriman</option>
                                <option value="3">Diterima</option>
                                <option value="5">Ditolak</option>
                            </select>
                            <span class="input-group-perepend">
                                <button class="btn btn-primary">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="m-1">
                        <form action="  " method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="pencarian" placeholder="Cari berdasarkan kode transaksi">
                                <span class="input-group-perepend">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm" v-if="$akses.admin()">
                    <div class="m-1">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#m_export">
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-2" v-if="mod_pencarian">
                Hasil Dari : {{'pencarian'}} <a href=" "> Reset </a>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-stripped">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Kode Transaksi</th>
                        <th>metode</th>
                        <th>Status</th>
                        <th>bukti</th>
                        <th>Tgl Pemesanan</th>
                        <th class="text-center" width="50"><i class="fa fa-eye"></i></th>
                    </tr>
                    <tr v-for="(transaksi,index) in varTransaksi.data">
                        <td class="text-center"> {{index+1}} </td>
                        <td> {{transaksi.kd_transaksi}} </td>
                        <td class="text-capitalize"> {{transaksi.metode}} </td>
                        <td>
                            <span v-html="$options.filters.status_pemesanan(transaksi.status)"></span>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="" >
                                <span v-html="$options.filters.bukti_pembayaran(transaksi.status)"></span>
                            </button>
                        </td>
                        <td> {{transaksi.created_at | TGL}} </td>
                        <td class="text-center">
                            <router-link :to="'transaksi/'+transaksi.kd_transaksi" class="btn btn-xs btn-outline-primary">
                                <i class="fa fa-eye"></i>
                            </router-link>
                        </td>
                    <tr>
                    <tr v-if="varTransaksi.total == 0">
                        <td colspan="8" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            toPending:'0',
            toUsai:'0',

            pencarian:'',
            mod_pencarian:false,

            filter:'',
            mod_filter:false,

            varTransaksi:{},
        }
    },
    mounted() {
        this.load_transaksi();
    },
    methods: {
        load_transaksi(){
            axios.get('/api/transaksi')
            .then(({data})=>{
                this.varTransaksi=data.varTransaksi
                this.toPending=data.toPending;
                this.toUsai=data.toUsai;
            })
        }

    },
}

</script>
