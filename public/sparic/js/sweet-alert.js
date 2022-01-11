
$(function(e){
  'use strict'

	// Message
	$(document).on('click','#but1', function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		if(message == ""){
			message  = "Your message";
		}
		swal(message);
	});

	// With message and title
	$(document).on('click','#but2', function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "Your message";
		}
		if(title == ""){
			title = "Your message";
		}
		swal(title,message);
	});

	// Show image
	$("#but3").on("click", function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "New Notification from Sparic";
		}
		if(title == ""){
			title = "Notification Styles";
		}
		swal({
			title: title,
			text: message,
			imageUrl: '../../assets/images/brand/favicon.png'
		});
	});


	// Timer
	$("#but4").on("click", function(e){
		$('body').addClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "New Notification from Sparic";
		}
		if(title == ""){
			title = "Notification Styles";
		}
		message += "(close after 30 seconds)";
		swal({
			title: title,
			text: message,
			timer: 1000,
			showConfirmButton: false,
			showCancelButton: false,
			closeOnConfirm: false,
		});
	});
	
	//
	$(document).on('click','#click', function(e){
		$('body').removeClass('timer-alert');
		var type = $("#type").val();
		swal({
			title: "Title",
			text: "Your message",
			type: type
		});
	});
	
	// Prompt
	$(document).on('click','#prompt', function(e){
		$('body').removeClass('timer-alert');

		swal({
			title: "Add",
			text: "Enter your message",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Your message"
		},function(inputValue){


			if (inputValue != "") {
				swal("Input","You have entered : " + inputValue);

			}
		});
	});

	// Confirm
	$(document).on('click','#confirm', function(e){
		$('body').removeClass('timer-alert');
		swal({
			title: "Alert",
			text: "Are you really want to exit",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});

	
	$(document).on('click','#click', function(e){
		$('body').removeClass('timer-alert');
		swal('Congratulations!', 'Your message has been succesfully sent', 'success');
	});
	$(document).on('click','#click1',function(e){
		$('body').removeClass('timer-alert');
		swal({
			title: "Alert",
			text: "Waring alert",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});
	$(document).on('click','#click2', function(e){
		$('body').removeClass('timer-alert');
		swal({
			title: "Alert",
			text: "Danger alert",
			type: "error",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});
	
});