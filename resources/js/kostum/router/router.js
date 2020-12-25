import public_router from './public-router.js'
import admin_router from './admin-router.js'

let route;
let role_user
if (window.user) {
	role_user=window.user.akses;
}else{
	role_user=0;
}

if (role_user == 5) {
	route=admin_router;
}

if (role_user == 0) {
	route=public_router;
}
export default route;