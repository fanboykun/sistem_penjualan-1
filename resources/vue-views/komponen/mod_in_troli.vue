<template>
    <modal name="kelola_troli"  :width="312" :height="'auto'"  :shiftY="0.7"  :adaptive="true">
        <div class="card m-2">
            <span class="">
                <i class="fa fa-times float-right btn btn-sm " @click="$modal.hide('kelola_troli')"></i>
            </span>
            <div class="m-1 ">
                <img  :src="'produk/'+ produk.img_1" class="w-100">
            </div>
            <div class="p-3">
                <h4> {{produk.nama}} </h4>
                <div class="font-weight-bold">
                    <h4> Rp {{produk.harga | IDR}}  </h4>
                </div>
                <div class="badge badge-danger bg-gradient-danger ">
                    {{produk.berat}} KG
                </div>
                <span v-html="$options.filters.STOK(produk.stok)"></span>

                <form @submit.prevent="tambahTroli">
                    <template v-if="produk.stok > 0">
                        <div class="form-group">
                            <label for="">Masukan Jumlah</label>
                            <input type="number" v-model="form.jumlah" 
                                min="1" class="form-control" placeholder="Masukan Jumlah"
                                :class="{'is-invalid':form.errors.has('jumlah')}">
                                <has-error :form="form" field="jumlah"></has-error>
                        </div>
                        <button class="btn btn-block btn-primary btn-sm mb-2" data-toggle="modal">
                            <i class="mdi mdi-cart mr-2"></i>
                            Tambahkan
                        </button>
                    </template>
                    <template v-else class="text-center">
                        <i> Stok Habis</i>
                    </template>
                </form>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        data(){
            return{
                page:'/api/troli',
                produk:[{
                    nama:'',
                    harga:'',
                    stok:'',
                    berat:'',
                }],
                form:new Form({
                    jumlah:'',
                    fk_kd_produk:'',
                }),
            }
        },
        mounted() {
            nv.$on('open_troli',(produk)=>{
                let maaf='Untuk dapat menambahkan barang ke troli harus login terlebih dahulu';
                if (!window.user) {
                  return  Swal.fire({
                        title:'Maaf ..',
                        text: maaf,
                        icon:'info',
                        showCancelButton: true,
                        confirmButtonColor: '#b66dff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Tutup'
                    }).then((result)=>{
                        if (result.isConfirmed) {
                            this.$router.push('login')
                        }
                    })
                }else{
                    this.$modal.show('kelola_troli');
                    this.produk = produk
                    this.form.fk_kd_produk=produk.kd_produk
                }

            })
        },
        methods:{
            tambahTroli(){                
                this.$toast.df102();
                this.form.post(this.page)
                .then(()=>{
                    this.$toast.df200();
                    this.$modal.hide('kelola_troli')
                })
                .catch((e)=>{
                    this.$error.catch(e);
                })
            }
        },
    }
</script>
