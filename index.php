<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Single Download</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/google-code-prettify/prettify.js"></script>
	<script type="text/javascript">
			$(document).ready(function() {
				$("*").DomInspector({
					callback : function(results) {
						// Returns an Array of each element
						$(".results").html(results.join(", "));
					}
				
				});
			
				// make code pretty
			    window.prettyPrint && prettyPrint();
			});
			
	</script>
		
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/docs.css" rel="stylesheet">
    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
    <style type="text/css">
    	body {
    		padding-top: 25px;
    	}
    </style>
  </head>

  <body>

    <div class="container">
		<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Single Use download</h1>
        <br>
        <h2>Brief</h2><br>
		<p>Explination of the site you want to provide.</p>
		<br>
		<h2>Description</h2><br>
		<p>Creates a single link to download any of a specific number of files.</p>
		<br>
		<p>Based off of the project by https://github.com/joshpangell.</p>
	
     <footer class="footer">
      <div class="container">
		<p>
      Edit by Darkbat91
    </p>
      </div>
    </footer>

    </div> <!-- /container -->


  </body>
</html>
