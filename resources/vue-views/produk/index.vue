<template>
    <div>
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
                <form action="  " method="GET" class="m-1">
                    <div class="input-group">
                        <select name="filter" class="form-control">
                            <option value="">Seluruh data</option>
                            <option value=""></option>
                        </select>
                        <span class="input-group-perepend">
                            <button class="btn btn-primary">
                                <i class="fa fa-filter"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-sm">
                <div class="m-1">
                    <form action=" " method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="pencarian" placeholder="Cari berdasarkan nama barang">
                            <span class="input-group-perepend">
                                <button class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="p-2" v-if="pencarian">
            Hasil Dari : <a href=""> Reset </a>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card m-2">
                    <img src="" class="w-100">
                    <div class="p-3">
                        <h4></h4>
                        <div class="font-weight-bold">
                            <h4> Rp </h4>
                        </div>
                        <div class="badge badge-danger bg-gradient-danger ">
                           KG
                        </div>
                        <span class="badge badge-success small mb-2">
                            Tersedia
                        </span>
                        <span class="badge badge-secondary small mb-2">
                            Habis
                        </span>
                        <button class="btn btn-block btn-primary btn-sm mb-2" data-toggle="modal">
                            <i class="mdi mdi-cart mr-2"></i>
                            Tambahkan
                        </button>
                        <a href=" " class="btn btn-block btn-outline-primary btn-sm">
                            <i class="fa fa-eye mr-2"></i>
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            pencarian:null,
        }
    },
    mounted() {
        this.testLogin();
        console.log('Component mounted.')
    },
    methods: {
        testLogin() {
            axios.get('/api/index')
        },
        login() {
            axios.post('/login', {
                username: this.username,
                password: this.password
            }).then((e) => {
                this.testLogin();
            }).catch(() => {
                alert('salah')
            })
        }
    },
}

</script>
