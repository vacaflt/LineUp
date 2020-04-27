//Like.js by Thais Vacaflores

import $ from 'jquery';

class Like {
	 constructor(){
	 	this.events();
	 }

	 events(){
	 	$(".like-box").on("click",this.ourClickDispacher.bind(this));
	 }

	 ourClickDispacher(e){
	 	var currentLikeBox = $(e.target).closest(".like-box");
	 	if(currentLikeBox.attr('data-exists')=='yes'){
	 		console.log('delete');
	 		this.deleteLike(currentLikeBox);
	 	}else{
	 		this.createLike(currentLikeBox);
	 	}
	 }

	 //methods
	 createLike(currentLikeBox){
	 	console.log(capstoneData.root_url + '/wp-json/v1/manageLike');
	 	$.ajax({
	 		
	 		beforeSend: (xhr) => {
	 			xhr.setRequestHeader('X-WP-Nonce', capstoneData.nonce);
	 		},
	 		url: capstoneData.root_url + '/wp-json/v1/manageLike',
	 		type: 'POST',
	 		data: {'sessionId': currentLikeBox.data('session')},
	 		success: (response) => {
	 			currentLikeBox.attr('data-exists', 'yes');
	 			var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
	 			likeCount ++;
	 			currentLikeBox.find(".like-count").html(likeCount);
	 			currentLikeBox.attr("data-like", response);
	 			console.log(response);
	 		},
	 		error: (response) => {
	 			console.log(response);
	 		}
	 	});
	 }

	 deleteLike(currentLikeBox){
		$.ajax({

			beforeSend: (xhr) => {
	 			xhr.setRequestHeader('X-WP-Nonce', capstoneData.nonce);
	 		},
	 		url: capstoneData.root_url + '/wp-json/v1/manageLike',
	 		type: 'DELETE',
	 		data: {'like': currentLikeBox.attr('data-like')},
	 		success: (response) => {
	 			currentLikeBox.attr('data-exists', 'no');
	 			var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
	 			likeCount --;
	 			currentLikeBox.find(".like-count").html(likeCount);
	 			currentLikeBox.attr("data-like", ' ');
	 			console.log(response);
	 		},
	 		error: (response) => {
	 			console.log("error on delete");
	 			console.log(response);
	 		}
	 	});
	 }

}

export default Like;