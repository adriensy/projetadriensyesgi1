<?php
    error_reporting(E_ALL);
    
    
    require "facebook-php-sdk-v4-4.0-dev/autoload.php";
    
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    
    const APP_ID = "1456178881340751";
    const APP_SECRET = "0a8bd1b0e40a21206aa1b0b02ec14251";
    const REDIRECT_URL = "https://projetadriensyesgi1.herokuapp.com/";
    
    session_start();
    
    FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
    
    $loginUrl = "";
    $helper = new FacebookRedirectLoginHelper(REDIRECT_URL);
    
    try {
        $session = $helper->getSessionFromRedirect();
    } catch(FacebookRequestException $ex) {
        echo "1";
        die(var_dump($ex->getMessage()));
    } catch(\Exception $ex) {
        echo "2";
        die(var_dump($ex->getMessage()));
    }
    if ($session) {
        $request = new FacebookRequest( $session, 'GET', '/me' );
        $response = $request->execute();
        // get response
        $graphObject = $response->getGraphObject();
    } else {
        $loginUrl = $helper->getLoginUrl();
    }
?>

<!doctype html>
<html>
    <head>
      <meta charset="UTF-8">
      <title>Titre de la page</title>
      <meta name="description" content="description de ma page">
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo APP_ID ?>',
            xfbml      : true,
            version    : 'v2.3'
          });
        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "//connect.facebook.net/fr_FR/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
      </script>
    </head>
    <body>
        <?php
            if (isset($graphObject)) {
                die(var_dump($graphObject));
                echo "Vous êtes connecté en tant que ".$graphObject->backingData['name'];
            } else {
                echo '<a href="'.$loginUrl.'">S\'authentifier avec Facebook</a>';
            }
        ?>
        
        <div
            class="fb-like"
            data-share="true"
            data-width="450"
            data-show-faces="true">
        </div>
    </body>
</html>