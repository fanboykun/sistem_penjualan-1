import Vue from 'vue';
import VueRouter from 'vue-router';
import router_public from './public-router';
Vue.use(VueRouter);



let routes=[
	{path:'/troli',component: require('../../../vue-views/onlogin/troli/index.vue').default}	
]

for (var i = 0; i < router_public.length; i++) {
	routes.push(router_public[i])  
}

const route = new VueRouter({
	mode: 'history',
	routes 
});



export default route; 