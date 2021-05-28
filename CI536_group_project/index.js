window.addEventListener('load', function() {
	
	document.querySelector('#contact form').addEventListener('submit', send_message);
	document.querySelector('#reset_success').addEventListener('click', reset);
	document.querySelector('#reset_error').addEventListener('click', reset);
	
	function send_message (evt){
		evt.preventDefault();
	
		var email = document.querySelector('#email').value.trim();
		
		var subject = document.querySelector('#subject').value.trim();
		
		var message = document.querySelector('#message').value.trim();
		
		var hint_email = document.querySelector('#hint_email');
		var hint_subject = document.querySelector('#hint_subject');
		var hint_message = document.querySelector('#hint_message');
		
		var loading = document.querySelector('#loading');
		var success = document.querySelector('#success');
		var error = document.querySelector('#error');

		var flag_error = false;
		
		if(email.length < 5 ||email.indexOf('@') < 0 ){
			hint_email.style.display = 'inline';
			flag_error = true;
		}
		else{
			hint_email.style.display = 'none';
		}

		if(subject.length < 1){
			hint_subject.style.display = 'inline';
			flag_error = true;
		}
		else{
			hint_subject.style.display = 'none';
		}

		if(message.length < 1){
			hint_message.style.display = 'inline';
			flag_error = true;
		}
		else{
			hint_message.style.display = 'none';
		}
		
		if(!flag_error){

			document.querySelector('#contact').style.display = 'none';
			document.querySelector('#loading').style.display = 'block';

			setTimeout(function(){
				
				document.querySelector('#loading').style.display = 'none';
				var success  = true; //(math.random() > 0.2)

				if(success){
					document.querySelector('#success').style.display = 'block';

				}
				else {
					document.querySelector('#error').style.display = 'block';

				}
			}, 2000);
        
		}
	}
	
	function reset(){
		
		document.querySelector('#success').style.display = 'none';
		document.querySelector('#error').style.display = 'none';
		document.querySelector('#loading').style.display = 'none';
		document.querySelector('#contact').style.display = 'block';
		document.querySelector('#email').value = "";
		document.querySelector('#subject').value ="";
		document.querySelector('#message').value = "";
	}

});	
