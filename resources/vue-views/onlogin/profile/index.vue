<template>
    <div>
        <div class="page-header" v-if="!bioFalse">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-shopping"></i>
                </span> Biodata
            </h3>
        </div>
        <div class="bg-white p-3">
            <div class="alert alert-primary">
                Harap Mengisi Biodata Sebelum Melakukan Pemesanan
            </div>
            <form @submit.prevent="tambahBiodata">
                    <label for="">Masukan Alamat Sesuai KTP</label> <br>
                    <div class="form-group">
                        <label for="">Provinsi</label>
                        <div class="p-2" v-if="!provinsi_load">
                            Loading Data Provinsi
                            <i class="fa fa-spin fa-spinner"></i>
                        </div>
                        <multiselect
                                v-model="form.provinsi"
                                @input="get_province"
                                :options="varProvince"
                                :custom-label="selectVal"
                                label="name"
                                track-by="province"
                                placeholder="Pilih Provinsi"
                                ></multiselect>
                    </div>
                    <div class="form-group">
                        <label for="">Kota</label>
                        <div class="p-2" v-if="!kota_load">
                            Loading Data Kota
                            <i class="fa fa-spin fa-spinner"></i>
                        </div>
                        <multiselect
                                v-model="form.kota"
                                :options="varCity"
                                :custom-label="selectKota"
                                label="name"
                                track-by="province"
                                placeholder="Pilih Kota"
                                ></multiselect>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" v-model="form.alamat" required="" value="  ">
                    </div>
                    <div class="form-group">
                        <label for="">RT / RW</label>
                        <input type="text" class="form-control" v-model="form.rtrw" required="" value=" ">
                    </div>
                    <div class="form-group">
                        <label for="">Kelurahan</label>
                        <input type="text" class="form-control" v-model="form.kelurahan" required="" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Kecamatan</label>
                        <input type="text" class="form-control" v-model="form.kecamatan" required="" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" v-model="form.email" class="form-control" value="">
                        <small>Boleh kosong</small>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm">
                                <div class="m-1">
                                    <label for="">No Handphone 1</label>
                                    <input type="text" v-model="form.no_hp1" class="form-control" required="" value="">      
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="m-1">
                                    <label for="">No Handphone 2</label>
                                    <input type="text" v-model="form.no_hp2" class="form-control" value="">
                                    <small>Boleh kosong</small>
                                </div>
                            </div>
                        </div>
                    </div>
                     <button class="btn btn-gradient-primary btn-block">
                        Simpan Biodata
                     </button>
                </form>
        </div>

    </div>
</template>

<script>
    export default {
        props:['bioFalse'],
        data(){
            return{
                varProvince:[],
                varCity:[],
                provinsi_load:false,
                kota_load:true,
                form:new Form({
                    alamat:'',
                    rtrw:'',
                    email:'',
                    no_hp1:'',
                    no_hp2:'',
                    kelamin:'',
                    kelurahan:'',
                    kecamatan:'',
                    lainya:'',
                    kota:'',
                    city_id:'',
                    province_id:'',
                    provinsi:'',
                })

            }
        },
        mounted() {
            this.load_province();
        },
        methods:{
            load_province(){
                axios.get('/api/bio/create')
                .then(({data})=>{
                    this.provinsi_load=true;
                    this.varProvince=data.rajaongkir.results
                })
            },
            get_province(){
                this.kota_load=false;
                axios.get('/api/bio/create',{params:{'getKota':this.form.provinsi.province_id}})
                .then(({data})=>{
                    this.varCity=data.rajaongkir.results
                    this.kota_load=true;
                })
            },
            tambahBiodata(){
                this.$toast.df102();
                this.form.post('/api/bio')
                .then(()=>{
                    this.$toast.df200();
                    nv.$emit('biodata_true')
                })
                .catch((e)=>{
                    this.$error.catch(e)
                })
            },
            selectVal({ province }) {
                return `${province}`
            },
            selectKota({city_name}){
                return `${city_name}`
            },

        },
    }
</script>
