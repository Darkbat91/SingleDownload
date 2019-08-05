<?php
/**
 *      This file creates the single use download link
 *      The query string should be the password (which is set in variables.php)
 *      If the password fails, then 404 is rendered
 *
 *      Expects: generate.php?p=1234
 *      Expects: generate.php?p=1234&api=y
 * 
 */
        include("variables.php");

        // Grab the query string as a password
        $password = trim($_GET['p']);
	$api = trim($_GET['api']);
        // $password = trim($_SERVER['QUERY_STRING']);

        // Get a human readable file size from bytes
        function human_filesize($bytes, $decimals = 2) {
                $sz = 'BKMGTP';
                $factor = floor((strlen($bytes) - 1) / 3);
                return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
        }


        /*
         *      Verify the admin password (in variables.php)
         */
        if($password == ADMIN_PASSWORD) {
                // Create a list of files to download from
                $download_list = array();

                // Create single key to download any one of the files in the array
                $new = uniqid('key',TRUE);
                // Pull the top file from the work directory - TODO: Add error handling if the directory is empty
                $activearray = scandir(WORK_DIR);

                
            if(count($activearray) > 2) {
                // The file we want is actually the 3rd file in the array due to . and .. 
                $activefile = $activearray[2];                
        
                
                rename(WORK_DIR . $activefile, 'secret/' . $activefile);

                // get download link and file size
                $download_link = "http://" . $_SERVER['HTTP_HOST'] . DOWNLOAD_PATH . "?key=" . $new . "&i=" . $activefile;
                $filesize = (isset($activefile['file_size'])) ? $activefile['file_size'] : human_filesize(filesize('secret/' . $activefile), 2);

                // Add to the download list
                $download_list[] = array(
                        'download_link' => $download_link,
                        'filesize' => $filesize
                );

                /*
                        *      Create a protected directory to store keys in
                        */
                if(!is_dir('keys')) {
                        mkdir('keys');
                        $file = fopen('keys/.htaccess','w');
                        fwrite($file,"Order allow,deny\nDeny from all");
                        fclose($file);
                }

                        /*
                         *      Write the key to the keys list - Only one time
                         */
                        $file = fopen('keys/keys','a');
                        fwrite($file,"{$new}\n");
                        fclose($file);
            if($api != 'y') {
        
?>


<html>
        <head>
                <title>Download created</title>
                <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
            <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
            <link href="bootstrap/css/docs.css" rel="stylesheet">
            <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
                <style>
                        body {
                        padding-top: 25px;
                }
                </style>
        </head>
        <body>
                 <div class="container">
                        <h1>Download key created</h1>
                        <h6>Your new single-use download links:<h6><br>
                        <?php foreach ($download_list as $download) { ?>
                        <h4>
                                <a href="<?php echo $download['download_link'] ?>"><?php echo $download['download_link'] ?></a><br>
                                Size: <?php echo $download['filesize'] ?>
                        </h4>
                        <?php } ?>

                        <br><br>
                        <a href="/">Back to the demo</a>
                </div>
        </body>
</html>

<?php

        } // end of api if statement
    else {
        // return just the download link in the body
        foreach ($download_list as $download) {
?>
<html>
<body>
<?php echo $download['download_link']; ?>
</body>
</html> 
<?php
        } // end foreach satement
    }
    } // end of more files if
    else {
        header("HTTP/1.0 503 Service Unavailable");
        }
    } // end of password if 
    else {
                /*
                 *      Someone stumbled upon this link with the wrong password
                 *      Fake a 404 so it does not look like this is a correct path
                 */
                header("HTTP/1.0 404 Not Found");
        }
?>

