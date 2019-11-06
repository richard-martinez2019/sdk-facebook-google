<?php include ("vendor/autoload.php");
//Step 1: Enter you google account credentials
$g_client = new Google_Client();
$g_client->setClientId("185077686063-4334glf1rk0bkddtu06hhrnbf9iurt71.apps.googleusercontent.com");
$g_client->setClientSecret("lw-YiPLKW9Euz_YBXc3488V5");
$g_client->setRedirectUri("https://sdk.hostinggratis.cl/google.php");
$g_client->setScopes("email");
//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
echo '<a href="'.$auth_url.'">Iniciar sesión con Google</a>';
//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
//Step 4: Get access token
if(isset($code)) {
    try {
        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);
    }catch (Exception $e){
        echo $e->getMessage();
    }
    try {
        $pay_load = $g_client->verifyIdToken();
    }catch (Exception $e) {
        echo $e->getMessage();
    }
} else{
    $pay_load = null;
}
if(isset($pay_load)){
    echo $pay_load;
}
?>