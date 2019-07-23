# Single use download script


## Brief

This is an edit of the project from https://github.com/joshpangell to incorporate only a single download link that may be used for any one of multiple files

## Description

This script allows you to generate a unique link to download a file. This file will only be allowed to download one time. 

You can also mask the name of the file being downloaded, for further protection. 

## Update

Modified the Links from the original project in order to have only 1 download of any of the specified files.

## Usage

All files must be uploaded to a directory on your server. 
This directory's permissions MUST be `chmod 755` 
(Also known as) 
`User: read/write/execute`
`Group: read/execute`
`World: read/execute`

This directory must also be owned by the apache user which is what php-fpm runs as

The directory called `secret` must also have the same permissions set as the parent directory. 

You will need to modify the `variables.php` file and set your file specific info.

	// Arrays of content type, suggested names and protected names
	$PROTECTED_DOWNLOADS = array(
		array(
			'content_type' => 'application/zip', 
			'suggested_name' => 'computing.zip', 
			'protected_path' => 'secret/file1.zip'
		),
		array(
			'content_type' => 'application/zip', 
			'suggested_name' => 'star.zip', 
			'protected_path' => 'secret/file2.zip'
		)
	);

	// The path to the download.php file (probably same dir as this file)
 	define('DOWNLOAD_PATH','/download.php');
	
	// The admin password to generate a new download link
	define('ADMIN_PASSWORD','1234');
	
	// The expiration date of the link (examples: +1 year, +5 days, +13 hours)
	define('EXPIRATION_DATE', '+1 month');

Once this is in place, you are ready to generate a new download key. To do this, you will need to use the password you set in the variables file. In the example above, that is `1234`

Navigate to `example.com/singleuse/generate.php?1234` (Notice the `?1234` a the end — that is your password)

Copy the link that is generated and send it off. Voila! Done.

## Centos 7 install steps

```
sudo rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
sudo yum --enablerepo=remi-php72 install php php-fpm
sudo yum install nginx git

sudo rm -rf /usr/share/nginx/html/*
sudo chmod 755 /usr/share/nginx/html/

git clone https://github.com/Darkbat91/SingleDownload.git
```

modify the server listener as below

```
server {
        listen   80;

        root /usr/share/nginx/html/;
        index index.php index.html index.htm;

        location / {
                try_files $uri $uri/ /index.html;
        }

        error_page 404 /404.html;
        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
              root /usr/share/nginx/www;
        }

        location ~ .php$ {
                try_files $uri =404;
                fastcgi_pass 127.0.0.1:9000;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
}
```

start the nginx server and php-fpm

```
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
```