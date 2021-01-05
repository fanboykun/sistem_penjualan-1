<template>
    <div>
        <modal name="moda_status" :width="316" :height="'auto'">
            <form @submit.prevent="fm_update_status">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="float-right">
                            <i class="fa fa-times" @click="$modal.hide('moda_status')"></i>
                        </span>
                        <h5 class="modal-title">Status Pengiriman</h5>
                    </div>
                    <div class="modal-body">
                        <select v-model="status" class="form-control">
                            <option value="1">Pengemasan</option>
                            <option value="2">Pengiriman</option>
                            <option value="3">Diterima</option>
                            <option value="5">Ditolak</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block" type="submit">
                            Simpan Status Pengiriman
                        </button>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
export default {
    props:['kd_transaksi'],
    data() {
        return {
            status:'',
            form:new Form({
                img_bukti:'',
            })

        }
    },
    mounted() {
        nv.$on('open_moda_status',()=>{
            this.$modal.show('moda_status')
        })
        
    },
    methods: {
        fm_update_status(){
            this.$toast.df102();
            axios.put('/api/transaksi/'+this.kd_transaksi,{
                update_status:this.status
            })
            .then(()=>{
                this.$toast.df200();
                nv.$emit('biodata_true');
                this.$modal.hide('moda_status')
            })
            .catch((e)=>{
                this.$error.catch(e)
            })
        },
    },
}

</script>
