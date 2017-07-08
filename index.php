<?php
    require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Board2NZB</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://code.jquery.com/jquery-3.0.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
  var apikey = '<?php echo APIKEY ?>';

// Submit form on enter
$('.input').keypress(function (e) {
	  if (e.which == 13) {
	    $('form').submit();
	    return false;
	  }
	});


// Search and load results
$( document ).ready(function() {
    $('#submitButton').click(function() {
    	var q = $('#q').val();
   		$('#results').html("");
   		$('.modal').show();
    	$.ajax({
          url: 'api/',
    		  data: {
                t: 'search',
    		    q: q,
                o: 'json',
                apikey: apikey
    		  },
    		  success: function( result ) {
    		    //console.log(result);
    		    $.each(result.channel.item, function(key,item) {
                  $('#results').append('<div><a href="' + item.link + '&apikey=' + apikey + '">' + item.title + '</a></div>');
    		    });
    		    $('.modal').hide();
    		  },
    		  error: function (request, status, error) {
    			  $('.modal').hide();
    			  $('#results').append('Fehler!');
    		  }
    		});
    });
});
</script>

</head>
<body>
	<form action="#">
		<input id="q" type="text" />
		<input id="submitButton" type="submit" value=Suchen />
	</form>
	<div id="results">
	
	</div>
	<div class="modal"></div>
</body>
</html>