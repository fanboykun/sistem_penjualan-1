import Vue from 'vue';
import VueRouter from 'vue-router';
import public_router from './public-router';
Vue.use(VueRouter);

let routes=[
	{ path: '/index-user', component: require('../../../vue-views/onlogin/index/user/index.vue').default },
	{ path: '/index-produk', component: require('../../../vue-views/onlogin/index/produk/index.vue').default },
	{ path: '/index-kategori', component: require('../../../vue-views/onlogin/index/kategori/index.vue').default },
]


for (var i = 0; i<public_router.length ; i++) {
	routes.push(public_router[i])
}

const route = new VueRouter({
	mode: 'history',
	routes 
});



export default route; 