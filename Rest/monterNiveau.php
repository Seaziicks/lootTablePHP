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
    if (is_file('Poo/' . $classname . '.php'))
        require 'Poo/' . $classname . '.php';
    elseif (is_file('Poo/Manager/' . $classname . '.php'))
        require 'Poo/Manager/' . $classname . '.php';
    elseif (is_file('Poo/Classes/' . $classname . '.php'))
        require 'Poo/Classes/' . $classname . '.php';
}

/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];

$PersonnageManager = new PersonnageManager($bdd);
$NiveauManager = new NiveauManager($bdd);

switch ($http_method) {
    /// Cas de la méthode POST
    case "GET":
        if (!(empty($_GET['idPersonnage'])) && !empty($_GET['Niveau'])) {
            try {

                $personnage = $PersonnageManager->getPersonnage($_GET['idPersonnage']);

                if ($personnage->_niveauEnAttente > 0) {

                    $niveau = new Niveau(json_decode($_GET['Niveau'])->Niveau);

                    if ($niveau->niveau = $personnage->_niveau + 1) {

                        $prochainNiveau = $personnage->_niveau + 1;

                        $sqlProgresssionPersonnage = 'SELECT *
                                                    FROM progressionpersonnage
                                                    WHERE niveau = :niveau';

                        $progressionPersonnageNiveauQuery = $bdd->prepare($sqlProgresssionPersonnage);
                        $progressionPersonnageNiveauQuery->bindParam(':niveau', $prochainNiveau, PDO::PARAM_INT);
                        $progressionPersonnageNiveauQuery->execute();

                        $progressionPersonnageNiveauFetched = $progressionPersonnageNiveauQuery->fetch(PDO::FETCH_ASSOC);
                        $progressionPersonnageNiveauFetched['idProgressionPersonnage'] = $progressionPersonnageNiveauFetched['idProgressionPersonnage'] ? intval($progressionPersonnageNiveauFetched['idProgressionPersonnage']) : null;
                        $progressionPersonnageNiveauFetched['niveau'] = intval($progressionPersonnageNiveauFetched['niveau']);
                        $progressionPersonnageNiveauFetched['statistiques'] = boolval($progressionPersonnageNiveauFetched['statistiques']);
                        $progressionPersonnageNiveauFetched['nombreStatistiques'] = intval($progressionPersonnageNiveauFetched['nombreStatistiques']);
                        $progressionPersonnageNiveauFetched['pointCompetence'] = boolval($progressionPersonnageNiveauFetched['pointCompetence']);
                        $progressionPersonnageNiveauFetched['nombrePointsCompetences'] = intval($progressionPersonnageNiveauFetched['nombrePointsCompetences']);

                        if ($progressionPersonnageNiveauFetched['statistiques']
                            && $niveau->getNbStatistique() === $progressionPersonnageNiveauFetched['nombreStatistiques']
                            && $personnage->_deVitaliteNaturelle >= $niveau->_deVitalite && $personnage->_deManaNaturel >= $niveau->_deMana) {

                            $vitaliteNaturelle = ((($personnage->_constitution + $niveau->_constitution) - 10) / 2);

                            $idPersonnage = $personnage->_idPersonnage;
                            $niveauNiveau = $niveau->_niveau;
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'intelligence', $niveauNiveau, $niveau->_intelligence);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'force', $niveauNiveau, $niveau->_force);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'agilite', $niveauNiveau, $niveau->_agilite);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'sagesse', $niveauNiveau, $niveau->_sagesse);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'constitution', $niveauNiveau, $niveau->_constitution);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'vitalite', $niveauNiveau, $niveau->_vitalite);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'vitaliteNaturelle', $niveauNiveau, $vitaliteNaturelle);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'deVitalite', $niveauNiveau, $niveau->_deVitalite);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'mana', $niveauNiveau, $niveau->_mana);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'manaNaturel', $niveauNiveau, $niveau->_manaNaturel);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'deMana', $niveauNiveau, $niveau->_deMana);

                            $result = $bdd->query('SELECT *
                                                        FROM niveau 
                                                        WHERE idNiveau=' . $bdd->lastInsertId() . '
                                                        ');
                            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                            $result->closeCursor();
                            $bdd = null;

                            http_response_code(201);
                            deliver_responseRest(201, $personnage->_nom . " gagne niveau.", $fetchedResult);
                        } elseif ((!$progressionPersonnageNiveauFetched['statistiques'] && $niveau->getNbStatistique() > 0)
                            || $niveau->_deVitalite > $personnage->_deVitaliteNaturelle || $niveau->_deMana > $personnage->_deManaNaturel) {
                            http_response_code(406);
                            deliver_responseRest(406, "Vous essayez de tricher mon bon monsieur. Mais je suis meilleur que vous !", '');
                        } else {

                            $vitaliteNaturelle = (($personnage->_constitution - 10) / 2);

                            $idPersonnage = $personnage->_idPersonnage;
                            $niveauNiveau = $niveau->_niveau;
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'intelligence', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'force', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'agilite', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'sagesse', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'constitution', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'vitalite', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'vitaliteNaturelle', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'deVitalite', $niveauNiveau, $niveau->_deVitalite);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'mana', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'manaNaturel', $niveauNiveau, 0);
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'deMana', $niveauNiveau, $niveau->_deMana);
                        }
                    } else {
                        http_response_code(400);
                        deliver_responseRest(400, "Il peut progresser, mais pas de cette manière. Reformulez !", '');
                    }
                } else {
                    http_response_code(403);
                    deliver_responseRest(403, "Ce personnage n'a pas atteint ce palier. Vous n'avez pas le droit de vous tenir ici avec cette requête.", '');
                }
            } catch (PDOException $e) {
                http_response_code(400);
                deliver_responseRest(400, "niveau add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else {
            deliver_responseRest(400, "niveau add error, missing idPersonnage or Niveau", '');
        }
        break;
}
/// Envoi de la réponse au Client
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
