import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);



let routes=[
	{ path: '/', component: require('../../../vue-views/produk/index.vue').default },
	{ path: '/index', component: require('../../../vue-views/index.vue').default },
	{ path: '/login', component: require('../../../vue-views/login.vue').default },
	{ path: '/*', component: require('../../../vue-views/404.vue').default },
]

const route = new VueRouter({
	mode: 'history',
	routes 
});



export default route; 