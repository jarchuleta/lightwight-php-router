#PHP Router
I wrote this as part of a router function to replace code that wasn't working in old php environments

## .htaccess
You'll need to setup htaccess with the following routering instructions
```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

##Folder structure

* index.php
*  /components
*  /controllers


##index.php
Used as a URL router and class loader
/controller/action/param1/param2/ ... ?get1=1,get2=2 ...

##Components
Any php files here are loaded at runtime

##Controllers
Add controller classes here using the template

```php
<?php
	class Template_Controller{
		public function index($param1 =null, $param2=null){
			echo "index hit";
		}
	}
?>
```


