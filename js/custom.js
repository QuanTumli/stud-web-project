$(document).ready(function(){

	
    
    /* speichere vitalwerte */
    $("form#vitalForm").validate({
        rules: {
            value: {
                required: true,
                number: true
            }
        },
        messages: {
            value: {
                required: "Bitte einen Wert eingeben!",
                number: "Bitte eine Zahl eingeben!"
            }
        },
        submitHandler: function(form) {
        	$( '#alertMessage' ).removeClass().addClass('hide');
		    formSubmitAddVital($(form).serialize());
		}   
    });
    
    function formSubmitAddVital(form){
        $.ajax({
			type : 'POST',
			url : '/studium/WebApps/project/_mosimann/_modals/newVital.php',
			data: {
				form: form
			},
			success: function(data){
				if(data == 'OK'){
					$( '#alertMessage' ).children('p').html("<strong>OK</strong>, der Wert wurde erfolgreich hinzugefügt!<br>Bitte Seite aktualisieren um den Wert in der Tabelle zu sehen.");
					$( '#alertMessage' ).addClass('alert alert-success').removeClass('hide');
					$( '#value' ).val("");
				}else{
					$( '#alertMessage' ).children('p').html(data);
					$( '#alertMessage' ).addClass('alert alert-danger').removeClass('hide');
				}
			}
		});
    }
    
    /* speichere medikament auf patient */
    $("form#mediForm").validate({
        rules: {
            value: {
                required: true,
                number: true
            }
        },
        messages: {
            value: {
                required: "Bitte einen Wert eingeben!",
                number: "Bitte eine Zahl eingeben!"
            }
        },
        submitHandler: function(form) {
        	$( '#alertMessage' ).removeClass().addClass('hide');
		    formSubmitAddMedi($(form).serialize());
		}   
    });
    
    function formSubmitAddMedi(form){
        $.ajax({
			type : 'POST',
			url : '/studium/WebApps/project/_mosimann/_modals/newMediForPatient.php',
			data: {
				form: form
			},
			success: function(data){
				if(data == 'OK'){
					$( '#alertMessage' ).children('p').html("<strong>OK</strong>, das Medikament wurde erfolgreich hinzugefügt!<br>Bitte Seite aktualisieren um das Medikament in der Tabelle zu sehen.");
					$( '#alertMessage' ).addClass('alert alert-success').removeClass('hide');
					$( '#quantity' ).val("");
				}else{
					$( '#alertMessage' ).children('p').html(data);
					$( '#alertMessage' ).addClass('alert alert-danger').removeClass('hide');
				}
			}
		});
    }
    
    /* speichere medikament */
    $("form#newMediForm").validate({
        rules: {
            name: {
                required: true
            },
            unit: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Bitte einen Wert eingeben!"
            },
            unit: {
                required: "Bitte einen Wert eingeben!"
            }
        },
        submitHandler: function(form) {
        	$( '#alertMessage' ).removeClass().addClass('hide');
		    formSubmitAddMedikament($(form).serialize());
		}   
    });
    
    function formSubmitAddMedikament(form){
        $.ajax({
			type : 'POST',
			url : '/studium/WebApps/project/_mosimann/_modals/newMedi.php',
			data: {
				form: form
			},
			success: function(data){
				if(data == 'OK'){
					$( '#alertMessage' ).children('p').html("<strong>OK</strong>, das Medikament wurde erfolgreich hinzugefügt!<br>Bitte Seite aktualisieren um das Medikament in der Tabelle zu sehen.");
					$( '#alertMessage' ).addClass('alert alert-success').removeClass('hide');
					$( '#unit' ).val("");
					$( '#name' ).val("");
				}else{
					$( '#alertMessage' ).children('p').html(data);
					$( '#alertMessage' ).addClass('alert alert-danger').removeClass('hide');
				}
			}
		});
    }
    
    $("#date").mask("9999-99-99");
    $("#time").mask("99:99");
    
});