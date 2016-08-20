Redpill Microframework
-

This projects provides a simple and fast wrapper for PHP's 
default request and response system. 
 
Features
-
* request matching
* middleware system

Usage
-
    `
    <?php
    
    require_once('vendor/autoload.php');
    
    session_start();
    
    \Redpill\App::create($app);
    
    // Simple auth middleware
    $app->use('auth', function() use($app) {
        // sample auth verification
        if ($app->session->has('user')) {
          return true;
        }
        $app->response->body = '<h1>Access denied</h1>';
        return false;
    });
    
    // Custom 404 response
    $app->use('404', function() use($app) {
        $app->response->body = '<h1>Check the address bar,
            the page was not found.</h1>';
    });
    
    // Index handler
    $app->get('/', function() use($app) {
        $app->response->body = '<h1>Welcome</h1>';
    });
    
    // Authentication required
    $app->get('/protected', ['auth' => ''], function() use($app) {
        $app->response->body = '<h1>Protected</h1>';
    });
    
    // Login
    $app->get('/login', function() use($app) {
        $app->response->body = '<form action="" method="post">
            <input type="submit" value="Login"/>
           </form>';
    });
    
    $app->post('/login', function() use($app) {
        $app->session->set('user', 'logged');
        $app->redirect('/');
    });
    
    $app->run();
    
`
 
 