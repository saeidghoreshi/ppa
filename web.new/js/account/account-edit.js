$(document).ready(function(){
    $('#inputSubmitForm').hide();
    $('input[type="text"]').keyup(function(){
       $('#inputSubmitForm').show();
    });
    $("select").change(function () {
       $('#inputSubmitForm').show();
    });

    $('#paymethod').change(function(){

        value = $(this).val();

        if( value != "" ) {
            $('.paymethod').hide(700);
            if( value == '10' ) {
                $('#paymethod-2').show(700);
            }
            else if( value == '9' ) {
                location.href = 'index.php/account/paypal/step2';
            }
            else {
                $('#paymethod-1').show(700);
            }
            $('#profile-info').show(700);
        } else {

            $('.paymethod').hide(700);
            $('#profile-info').hide(700);
        }

    });

    $('#use_profile').click(function(){

	var obj = {};
	/* get data in json format via ajax (key:value - where 'key' eq. element id) */
	$.post( "index.php/user/", 
	{ 
	    'json': 1
	},
	function(data){
	    //console.log(data);
	    obj['profile-1'] = data.firstname
	    obj['profile-2'] = data.lastname;
	    obj['profile-3'] = 2;
	    obj['profile-4'] = data.street;
	    obj['profile-5'] = data.city;
	    obj['profile-6'] = data.state;
	    obj['profile-7'] = data.zip;
	    obj['profile-8'] = data.country;
	    for ( k in obj ) {
                if( k != 'profile-3' ) { // for 'prefix' select element
                    $('#' + k).val( obj[k] );
		} else {
		    numopt = parseInt( obj[k] )-1;
		    $('#' + k + ' option:eq(' + numopt + ')').attr('selected', 'selected');
		}
	    }
	    $('#inputSubmitForm').show();

	    return false;
	}, "json"); 

        return false;
    });

});
