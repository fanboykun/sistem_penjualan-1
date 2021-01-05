<template>
    <div>
        <modal name="upload_pembayaran" :width="320" height="auto">
            <form @submit.prevent="upload_pembayaran">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                        <button type="button" class="btn btn-secondary btn-sm" @click="$modal.hide('upload_pembayaran')">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="bukti" class="form-control" required="" accept="image/jpeg" @change="base64" :class="{'is-invalid':form.errors.has('img_bukti')}">
                        <has-error :form="form" field="img_bukti"></has-error>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-success btn-block btn-sm" id="btn_up_bukti" >
                            <i class="fa fa-upload mr-2"></i> Upload
                        </button>
                    </div>
                </div>
            </form>
        </modal>
        <modal name="cek_upload" :width="316" :height="'auto'">
            <form @submit.prevent="add_respon_bukti">
                <div class="modal-content">
                    <div class="modal-body">
                        <img :src="'/bukti/'+img" class="w-100">
                    </div>
                    <div class="container">
                        <div class="row p-3">
                            <div class="col-sm">
                                <button type="submit"  @click="add_respon_bukti('1')" class="btn btn-gradient-success btn-block btn-sm btn_res_cek" >
                                    <i class="fa fa-check mr-2"></i> Terima
                                </button>
                            </div>
                            <div class="col-sm">
                                <button type="submit"  @click="add_respon_bukti('5')" class="btn btn-gradient-danger btn-block btn-sm btn_res_cek" >
                                    <i class="fa fa-times mr-2"></i> Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
export default {
    props:['kd_transaksi','img'],
    data() {
        return {
            res:'',
            form:new Form({
                img_bukti:'',
            })

        }
    },
    mounted() {
        nv.$on('open_mod_pembayaran',()=>{
            this.$modal.show('upload_pembayaran')
        })
        nv.$on('open_mod_cek_upload',()=>{
            this.$modal.show('cek_upload')
        })
        
    },
    methods: {
        upload_pembayaran(){
            $('#btn_up_bukti').attr('disabled',true)
            this.$toast.df102();
            this.form.put('/api/transaksi/'+this.kd_transaksi)
            .then(()=>{
                this.$toast.df200();
                nv.$emit('biodata_true');
                this.$modal.hide('upload_pembayaran')
                $('#btn_up_bukti').attr('disabled',false)
            })
            .catch((e)=>{
                $('#btn_up_bukti').attr('disabled',false)
                this.$error.catch(e)
            })
        },

        add_respon_bukti(ress){
            $('.btn_res_cek').attr('disabled',true)
            this.$toast.df102();
            axios.put('/api/transaksi/'+this.kd_transaksi,{
                'ress':ress
            })
            .then(()=>{
                this.$toast.df200();
                nv.$emit('biodata_true');
                this.$modal.hide('cek_upload')
                $('.btn_res_cek').attr('disabled',false)
            })
            .catch((e)=>{
                $('.btn_res_cek').attr('disabled',false)
                this.$error.catch(e)
            })
        },
        base64(fileTerpilih){
            let file=fileTerpilih.target.files[0];
            let pembacaFile=new FileReader();
            if (file['size'] / 1024 < 2048) {
                pembacaFile.onloadend = (file)=>{
                    this.form.img_bukti = pembacaFile.result
                }
                pembacaFile.readAsDataURL(file)
            }else{
                gambarRule.fire()
            }
        }

    },
}

</script>
