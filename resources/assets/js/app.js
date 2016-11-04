
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function(){
	var counter = 0;
	var checkForCsvFile = function(){
		$.ajax({
			url:baseURL+'/csv/source/posts.csv',
			type:'HEAD',
			data:{ _token: token },
			error: function(){
				$('.file-exists').attr('disabled', true);
				$('#delete-form').hide();
			},
			success: function(){
				$('.file-exists').attr('disabled', false);
				$('#delete-form').show();
			}
		});
	}
	checkForCsvFile();
	$('#upload_file_form').on('submit', function(e){

		e.preventDefault();
		var submissionURL = baseURL + '/csv_upload';

		$.ajaxSetup({
			headers: {
				'X-XSRF-TOKEN': token
			}
		});

		$.ajax({
			method: 'POST',
			url: submissionURL,
			processData: false,
			contentType: false,
			dataType: 'json',
			enctype: "multipart/form-data",
			data: new FormData( $(this)[0] ),
			success: function(result, status, xhr){
				checkForCsvFile();
				if( $('.form-wrapper').children('.alert-success').length == 0 ){
					$('.form-wrapper').children('.alert-danger').remove();
					$('.form-wrapper').prepend('<h3 class="alert alert-success text-center">A CSV Exists! to overwrite re-upload</h3>');
				} else {
					counter++;
					$('.form-wrapper').children('.alert-success').remove();
					$('.form-wrapper').children('.alert-danger').remove();
					$('.form-wrapper').prepend('<h3 class="alert alert-success text-center">You have re-uploaded the CSV X'+ counter +'</h3>');
				}
			},
			error: function(result){
				var response = $.parseJSON(result.responseText);
				var $errors = $('<ul class="alert alert-danger text-center"></ul>')
				$.each(response, function(key, value){
					$errors.append('<li>' + value[0] + '</li>');
				})
				$('.form-wrapper').children('.alert-success').remove();
				$('.form-wrapper').children('.alert-danger').remove();
				$('.form-wrapper').prepend($errors);
			}
		});
	
	});

});
