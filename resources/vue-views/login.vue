<template>
    <div>
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md">
                <transition
                    enter-active-class="animate__animated animate__fadeInRight animate__faster ">
                    <registrasiComp v-if="registrasi == true" ></registrasiComp>
                </transition>
                <transition
                    enter-active-class="animate__animated animate__fadeInLeft animate__faster  "
                    >

                    <div class="bg-white p-2 rounded bs-1" 
                    v-if="registrasi == false"
                    :class="{'absolute': registrasi}"
                    >
                        <div class="p-5 text-center font-weight-bold h3">
                            Selamat Datang <br>
                            <i class="fa fa-shopping-bag mt-2"></i>
                        </div>
                        <div class="alert alert-success  alert-dismissible fade show" 
                            v-if="telah_registrasi">
                            Akun Berhasil di daftarkan <br> silahkan login !
                             <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                              </button>
                        </div>
                        <div class="form-group p-2">
                            <form @submit.prevent="login">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control form-control-sm" v-model="form.username">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-sm" v-model="form.password">
                                        <span class="input-group-prepend">
                                            <button class="btn btn-sm als round-right">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class=" btn btn-primary btn-block">
                                        Login
                                    </button>
                                </div>
                                <div class="form-group  text-center">
                                    Tidak Memiliki Akun ?
                                    <div @click="registrasi = !registrasi" class="cp text-primary">
                                        Daftar
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </transition>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
</template>
<script>
import registrasiComp from './registrasi';
export default {
    components: {
        registrasiComp
    },
    data() {
        return {
            registrasi: false,
            telah_registrasi: false,
            form: new Form({
                username: '',
                password: '',
            })
        }
    },
    mounted() {
        nv.$on('registrasi_false', ()=> {
            this.registrasi = false;
        })
        nv.$on('telah_registrasi', ()=> {
            this.registrasi = false;
            this.telah_registrasi = true;
        })

    },
    methods: {
        login() {

        }
    },
}

</script>
