Redpill PHP Micro-framework
-

This projects provides a simple and fast wrapper for PHP's 
default request and response system. 
 
Features
-
* request matching
* middleware system

Usage
-
    <?php
    
    require_once('vendor/autoload.php');
    
    \Redpill\App::create($app);
    
    // Index handler
    $app->get('/', function() use($app) {
        $app->response->body = '<h1>Welcome</h1>';
    });
    
    $app->run();
    

 
 