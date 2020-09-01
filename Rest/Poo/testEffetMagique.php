<?php
declare(strict_types=1);
spl_autoload_register('chargerClasse');
session_start();
header("Content-Type:application/json");

/**
 * @param $classname
 */
function chargerClasse($classname)
{
    if (is_file('' . $classname . '.php'))
        require '' . $classname . '.php';
    elseif (is_file('Manager/' . $classname . '.php'))
        require 'Manager/' . $classname . '.php';
    elseif (is_file('Classes/' . $classname . '.php'))
        require 'Classes/' . $classname . '.php';
}

include('../../db.php');
$EffetMagiqueManager = new EffetMagiqueManager($bdd);

$data = $EffetMagiqueManager->getCompleteEffetMagiqueAsNotJson(2);

http_response_code(200);
deliver_responseRest(200, "Je vous fais de l'effet ? Vous trouvez ça magique ?", $data);

function deliver_responseRest($status, $status_message, $data)
{
    /// Paramétrage de l'entête HTTP, suite
    // header("HTTP/1.1 $status $status_message");
/// Paramétrage de la réponse retournée
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
/// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    echo $json_response;
}