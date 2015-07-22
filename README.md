# PHP Router
I wrote this as part of a router function to replace code that wasn't working in old php environments. Later I added the Views Markup.

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

## Folder structure

* index.php
*  /components
*  /controllers
*  /views
*  /framework

## Router
router.php
Used as a URL router and class loader
/controller/action/param1/param2/ ... ?get1=1,get2=2 ...

## Framework
The framework folder contains all the code to manage views and controllers.

##Components
Any php files here are loaded at runtime

## Controllers
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
## Views
Views are located in the view folder and withe default path of controllor/action.php
Views are automatically rendered, but that can be turned off in the controllor using the following
```php
	$this->autoRender = false;
```
You can manually call views
```php
	$this->render('index');
```

View variables are set using the set command, similar to cakephp
```php
	$this->set('view_var_name', "Variable Value");
```

## View Template
The is wrapping HTML structure behind the view files is located in views/template.php
