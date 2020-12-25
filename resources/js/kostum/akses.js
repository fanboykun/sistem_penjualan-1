export default class Akses{
	constructor(user) {
		 this.user=user;
	}
	admin(){
		return this.user.akses === '5';
	}
	user(){
		return this.user.akses === '1';
	}

}