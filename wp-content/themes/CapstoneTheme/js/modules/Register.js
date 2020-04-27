//Register.js by Thais Vacaflores
import $ from 'jquery';

class Register {
	 constructor(){
	 	this.events();
	 }

	 events(){
	 	$(".register-box").on("click",this.ourClickDispacher.bind(this));
	 }

	 //method
	 ourClickDispacher(e){
	 	var currentRegisterBox = $(e.target);
	 	
	 	console.log(currentRegisterBox.data('event'));
	 		 	console.log(currentRegisterBox.data('session'));


	 	if(currentRegisterBox.attr('type')=='mandatory'){
	 		return;
	 	}


	 	if(currentRegisterBox.attr('type')=='empty'){

	 		this.createRegister(currentRegisterBox);
	 		
	 	}else{

	 		this.deleteRegister(currentRegisterBox);
	 	}
	 }

	 createRegister(currentRegisterBox){
	 	console.log(capstoneData.root_url + '/wp-json/v1/manageRegister');
	 	$.ajax({
	 		
	 		beforeSend: (xhr) => {
	 			xhr.setRequestHeader('X-WP-Nonce', capstoneData.nonce);
	 		},
	 		url: capstoneData.root_url + '/wp-json/v1/manageRegister',
	 		type: 'POST',
	 		data: {'sessionId': currentRegisterBox.data('session'), 'eventId': currentRegisterBox.data('event')},
	 		success: (response) => {
				currentRegisterBox.attr('class', 'far fa-check-square fa-2x');
	 			currentRegisterBox.attr('type', 'registered');
	 			currentRegisterBox.attr('data-register', response);

	 		},
	 		error: (response) => {
	 			console.log(response);
	 		}
	 	});
	 }

	 deleteRegister(currentRegisterBox){
		$.ajax({

			beforeSend: (xhr) => {
	 			xhr.setRequestHeader('X-WP-Nonce', capstoneData.nonce);
	 		},
	 		url: capstoneData.root_url + '/wp-json/v1/manageRegister',
	 		type: 'DELETE',
	 		data: {'register': currentRegisterBox.attr('data-register')},
	 		success: (response) => {
	 			currentRegisterBox.attr('class', 'far fa-square fa-2x');
	 			currentRegisterBox.attr('type', 'empty');
	 			currentRegisterBox.attr('data-register', '');
	 			console.log(response);
	 		},
	 		error: (response) => {
	 			console.log("error on delete");
	 			console.log(response);
	 		}
	 	});
	 }

}

export default Register;