<?php
//Allow access from outside (see CORS)
//header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: 'https://gf.dev'");
header("Access-Control-Allow-Credentials 'true'");


//Allow GET, POST, PUT, DELETE, OPTIONS http methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

//Allow some types of headers
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

//Set response content type and character set
header("Content-Type: application/json; charset=UTF-8");

//Basic Authentication controle
if ( $_SERVER['PHP_AUTH_USER'] !== "user123" OR $_SERVER['PHP_AUTH_PW'] !== "some_very_long_password_abcde_98765_dsf8765ezr4sdf8f7" )
{
    //als er geen juiste credentials doorgegeven worden, afbreken met code 401 Unauthorized
    header('WWW-Authenticate: Basic realm="Provide your username and password for the Voorbeeld API"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$parts = explode("/", $request_uri);

//zoek "rest" in de uri
for ( $i=0; $i<count($parts) ;$i++)
{
    if ( $parts[$i] == "rest" )
    {
        break;
    }
}

$request_part = $parts[$i+2];
if ( count($parts) > $i + 3 ) $id = $parts[$i + 3];

//GET spelers: alle spelers geven
if ( $method == "GET" AND $request_part == "spelers" )
{
    $sql = "select * from spelers";
    // ... execute $sql
    print json_encode( [ "msg" => $sql ] ) ; //normaal zou je hier alle spelers teruggeven
}

//GET speler: één speler geven
if ( $method == "GET" AND $request_part == "speler" )
{
    $sql = "select * from spelers where spe_id=$id";
    // ... execute $sql
    print json_encode( [ "msg" => $sql ] ) ; //normaal zou je hier één speler teruggeven
}

//POST spelers: een speler toevoegen
if ( $method == "POST" AND $request_part == "spelers"  )
{
    $naam = $_POST["naam"];
    $sql = "INSERT INTO spelers SET spe_naam='$naam' ";
    // ... execute $sql
    http_response_code(201);
    print json_encode( [ "msg" => $sql ] ) ; //normaal zou je hier een OK teruggeven
}

//PUT speler: een speler updaten
if ( $method == "PUT" AND $request_part == "speler" )
{
    $contents = json_decode( file_get_contents("php://input") );
    $newdata = $contents->naam;

    $sql = "UPDATE spelers SET spe_naam='$newdata' WHERE spe_id=$id";
    // ... execute $sql
    print json_encode( [ "msg" => $sql ] ) ; //normaal zou je hier een OK teruggeven
}

//DELETE speler: een speler verwijderen
if ( $method == "DELETE" AND $request_part == "speler" )
{
    $sql = "DELETE FROM spelers WHERE spe_id=$id";
    // ... execute $sql
    print json_encode( [ "msg" => $sql ] ) ; //normaal zou je hier een OK teruggeven
}

?>

