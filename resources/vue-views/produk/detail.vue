<template>
	<div>
		<button @click="kembali" class="btn btn-outline-dark mb-2 btn-sm ">
			<i class="fa fa-chevron-left mr-2"></i> Kembali
		</button>
		<div class="page-header">
			<h3 class="page-title">
				<span class="page-title-icon bg-gradient-primary text-white mr-2">
					<i class="mdi mdi-shopping"></i> 
				</span> Detail Produk
			</h3>
		</div>
		<hr>
		<div class="row mb-5">
			<div class="col-sm" >
				<carousel :per-page="1"  :mouse-drag="true" :autoplay='true' :touchDrag='true' >
				    <slide v-if=" produk.img_1">
				        <img  :src="'/produk/'+ produk.img_1" class="w-100">
				    </slide>
				    <slide v-if="produk.img_2"> 
				        <img  :src="'/produk/'+ produk.img_2" class="w-100">
				    </slide>
				    <slide v-if="produk.img_3">
				        <img  :src="'/produk/'+ produk.img_3" class="w-100">
				    </slide>
				</carousel>
			</div>
			<div class="col-sm" >
				<div class="p-2 bg-white rounded">
					<span v-html="$options.filters.STOK(produk.stok)"></span>
					<span  class="badge badge-danger text-white">
						{{produk.berat}} <i class="">KG</i>
					</span>
					<h1>{{produk.nama}}</h1>
					<button type="button" class="btn m-1 btn-social-icon-text btn-sm btn-linkedin">
						<i class="mdi mdi-cards"></i>
						{{produk.harga | IDR}}
					</button>
					<button type="button" class="btn m-1 btn-social-icon-text d-none d-md-inline-block btn-gradient-primary"  @click="mod_in_troli(produk)" v-if="btn_tambahkan">
						<i class="mdi mdi-cart"></i>
						Tambahkan 
					</button>
					<div class="btn btn-secondary" v-else>
						Sudah Terdapat di Troli
					</div>
					<hr>
					<div style="height: 187px; overflow-y:auto; ">
						{{produk.deskripsi}}
					</div>
					
				</div>
				<div class="fixed-bottom d-md-none d-sm-block bg-white p-3" style="z-index: 1">
					<button class="btn btn-gradient-primary  btn-rounded btn-sm btn-block"  @click="mod_in_troli(produk)">
						<i class="mdi mdi-cart mr-2"></i>
						Tambahkan
					</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
    components: {
        Carousel,
        Slide
    },
	props:['produk'],
	data() {
		return {
			btn_tambahkan:true
		}
	},
	mounted() {
		this.cekPath();
		document.getElementById('title-page').textContent='Produk | '+ this.produk.nama;
	},
	methods: {
		kembali(){
			nv.$emit('kembali')
		},
		mod_in_troli(produk_terpilih){
			nv.$emit('open_troli',produk_terpilih);
		},
		cekPath(){
			if (this.$route.path == '/troli') {
				this.btn_tambahkan=false;
			}
		}
	},
}

</script>
