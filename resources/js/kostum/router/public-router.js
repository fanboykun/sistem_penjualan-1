let data=[
	{ path: '/', component: require('../../../vue-views/produk/index.vue').default },
]


if (window.user) {
	data.push(
		{ path: '/pengaturan', component: require('../../../vue-views/onlogin/pengaturan.vue').default },
		{ path: '/profil', component: require('../../../vue-views/onlogin/profile.vue').default },
		{ path: '/transaksi/', component: require('../../../vue-views/onlogin/transaksi/index.vue').default },
		{ path: '/transaksi/:kd_transaksi', component: require('../../../vue-views/onlogin/transaksi/detail.vue').default },
	)
}


let notFound={ path: '/*', component: require('../../../vue-views/404.vue').default };
data.push(notFound)

export default data;