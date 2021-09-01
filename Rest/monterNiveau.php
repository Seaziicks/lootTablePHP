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
    /// Cas de la méthode GET
    case "GET":
        if (!(empty($_GET['idPersonnage'])) && filter_var($_GET['monte'], FILTER_VALIDATE_BOOLEAN)) {

            $sqlMonterNiveau = 'UPDATE personnage 
                                SET niveauEnAttente = niveauEnAttente + 1 
                                WHERE idPersonnage = :idPersonnage';

            $monterNiveauQuery = $bdd->prepare($sqlMonterNiveau, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $monterNiveauQuery->bindParam(':idPersonnage', $_GET['idPersonnage'], PDO::PARAM_INT);
            $monterNiveauQuery->execute();

            http_response_code(201);
            deliver_responseRest(201, "Et 1 niveau pour la table n°" . $_GET['idPersonnage'] . ", 1 !", '');

        } elseif (isset($_GET['idPersonnage']) && !filter_var($_GET['monte'], FILTER_VALIDATE_BOOLEAN)) {

            $personnage = $PersonnageManager->getPersonnage($_GET['idPersonnage']);

            $sqlBaisserNiveau = '';
            if ($personnage->_niveauEnAttente > 0) {
                $sqlBaisserNiveau = 'UPDATE personnage 
                                        SET niveauEnAttente = niveauEnAttente - 1 
                                        WHERE idPersonnage = :idPersonnage';

            } else {

                $sqlGetNiveau = 'SELECT niveau FROM personnage WHERE idPersonnage = :idPersonnage';
                $getNiveauQuery = $bdd->prepare($sqlGetNiveau, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $getNiveauQuery->bindParam(':idPersonnage', $_GET['idPersonnage'], PDO::PARAM_INT);
                $getNiveauQuery->execute();
                $niveauPersonnage = $getNiveauQuery->fetch(PDO::FETCH_ASSOC)['niveau'];

                if ($niveauPersonnage > 1) {

                    $sqlBaisserNiveau = 'UPDATE personnage 
                                        SET niveau = niveau - 1 
                                        WHERE idPersonnage = :idPersonnage';

                    $sqlEnleverStatistiques = 'DELETE FROM monte WHERE idPersonnage = :idPersonnage AND niveau = :niveauPersonnage';
                    $enleverStatistiques = $bdd->prepare($sqlEnleverStatistiques, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $enleverStatistiques->bindParam(':niveauPersonnage', $niveauPersonnage, PDO::PARAM_INT);
                    $enleverStatistiques->bindParam(':idPersonnage', $_GET['idPersonnage'], PDO::PARAM_INT);
                    $enleverStatistiques->execute();
                } else {
                    http_response_code(406);
                    deliver_responseRest(406, "Impossible de supprimer le niveau 1, ou inférieur.", '');
                    break;
                }
            }

            $monteeNiveauQuery = $bdd->prepare($sqlBaisserNiveau, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $monteeNiveauQuery->bindParam(':idPersonnage', $_GET['idPersonnage'], PDO::PARAM_INT);
            $monteeNiveauQuery->execute();

            http_response_code(201);
            deliver_responseRest(201, "Je crois que vous avez fait tomber quelque chose. Tant pis pour vous !", '');
        }
        break;
    /// Cas de la méthode POST
    case "POST":
        if (isset($_GET['idPersonnage']) && isset($_GET['Niveau'])) {
            try {

                $personnage = $PersonnageManager->getPersonnageAvecStatistiques($_GET['idPersonnage']);

                if ($personnage->_niveauEnAttente > 0) {

                    $niveau = new Niveau((array) json_decode($_GET['Niveau'])->Niveau);

                    if ($niveau->_niveau === $personnage->_niveau + 1) {

                        $prochainNiveau = $personnage->_niveau + 1;

                        $sqlProgresssionPersonnage = 'SELECT *
                                                    FROM progressionpersonnage
                                                    WHERE niveau = :niveau';

                        $progressionPersonnageNiveauQuery = $bdd->prepare($sqlProgresssionPersonnage, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
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
                            && $personnage->_deVitaliteNaturelle >= $niveau->_deVitalite && $personnage->_deManaNaturel >= $niveau->_deMana || $niveau->_niveau === 1) {

                            // On rajoute la vitalité naturelle, qui dépend de la constitution => (Constitution - 10) / 2
                            $vitaliteNaturelle =  intval(max(floor(((($personnage->_constitution + $niveau->_constitution) - 10) / 2)), 0));

                            $idPersonnage = $personnage->_idPersonnage;
                            $niveauNiveau = $niveau->_niveau;
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'intelligence', $niveauNiveau, $niveau->_intelligence);
                            $insertForce = $NiveauManager->insertInto($idPersonnage, 'force', $niveauNiveau, $niveau->_force);
                            $insertAgilite = $NiveauManager->insertInto($idPersonnage, 'agilite', $niveauNiveau, $niveau->_agilite);
                            $insertSagesse = $NiveauManager->insertInto($idPersonnage, 'sagesse', $niveauNiveau, $niveau->_sagesse);
                            $insertConstitution = $NiveauManager->insertInto($idPersonnage, 'constitution', $niveauNiveau, $niveau->_constitution);
                            $insertVitalite = $NiveauManager->insertInto($idPersonnage, 'vitalite', $niveauNiveau, $niveau->_vitalite);
                            $insertVitaliteNaturelle = $NiveauManager->insertInto($idPersonnage, 'vitaliteNaturelle', $niveauNiveau, $vitaliteNaturelle);
                            $insertDeVitalite = $NiveauManager->insertInto($idPersonnage, 'deVitalite', $niveauNiveau, $niveau->_deVitalite);
                            $insertMana = $NiveauManager->insertInto($idPersonnage, 'mana', $niveauNiveau, $niveau->_mana);
                            $insertManaNaturel = $NiveauManager->insertInto($idPersonnage, 'manaNaturel', $niveauNiveau, $niveau->_manaNaturel);
                            $insertDeMana = $NiveauManager->insertInto($idPersonnage, 'deMana', $niveauNiveau, $niveau->_deMana);



                            $result = $bdd->query('SELECT *
                                                        FROM niveau 
                                                        WHERE idNiveau=' . $bdd->lastInsertId() . '
                                                        ');
                            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                            $result->closeCursor();


                            $sqlModifierPersonnage = 'UPDATE personnage 
                                                        SET niveau = niveau + 1, 
                                                        niveauEnAttente = niveauEnAttente - 1 
                                                        WHERE idPersonnage = :idPersonnage';

                            $modifierPersonnage = $bdd->prepare($sqlModifierPersonnage, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                            $modifierPersonnage->bindParam(':idPersonnage', $idPersonnage, PDO::PARAM_INT);
                            $modifierPersonnage->execute();

                            $bdd = null;

                            http_response_code(201);
                            deliver_responseRest(201, $personnage->_nom . " gagne un niveau.", $fetchedResult);
                        } elseif ((!$progressionPersonnageNiveauFetched['statistiques'] && $niveau->getNbStatistique() > 0)
                            || $niveau->_deVitalite > $personnage->_deVitaliteNaturelle || $niveau->_deMana > $personnage->_deManaNaturel) {
                            http_response_code(406);
                            deliver_responseRest(406, "Vous essayez de tricher mon bon monsieur. Mais je suis meilleur que vous !", '');
                        } else {

                            // On rajoute la vitalité naturelle, qui dépend de la constitution => (Constitution - 10) / 2
                            $vitaliteNaturelle = intval(max(floor(($personnage->_constitution - 10) / 2), 0));

                            $idPersonnage = $personnage->_idPersonnage;
                            $niveauNiveau = $niveau->_niveau;
                            $insertIntelligence = $NiveauManager->insertInto($idPersonnage, 'intelligence', $niveauNiveau, 0);
                            $insertForce = $NiveauManager->insertInto($idPersonnage, 'force', $niveauNiveau, 0);
                            $insertAgilite = $NiveauManager->insertInto($idPersonnage, 'agilite', $niveauNiveau, 0);
                            $insertSagesse = $NiveauManager->insertInto($idPersonnage, 'sagesse', $niveauNiveau, 0);
                            $insertConstitution = $NiveauManager->insertInto($idPersonnage, 'constitution', $niveauNiveau, 0);
                            $insertVitalite = $NiveauManager->insertInto($idPersonnage, 'vitalite', $niveauNiveau, 0);
                            $insertVitaliteNaturelle = $NiveauManager->insertInto($idPersonnage, 'vitaliteNaturelle', $niveauNiveau, $vitaliteNaturelle);
                            $insertDeVitalite = $NiveauManager->insertInto($idPersonnage, 'deVitalite', $niveauNiveau, $niveau->_deVitalite);
                            $insertMana = $NiveauManager->insertInto($idPersonnage, 'mana', $niveauNiveau, 0);
                            $insertManaNaturel = $NiveauManager->insertInto($idPersonnage, 'manaNaturel', $niveauNiveau, 0);
                            $insertDeMana = $NiveauManager->insertInto($idPersonnage, 'deMana', $niveauNiveau, $niveau->_deMana);

                            $result = $bdd->query('SELECT *
                                                        FROM niveau 
                                                        WHERE idNiveau=' . $bdd->lastInsertId() . '
                                                        ');
                            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                            $result->closeCursor();


                            $sqlModifierPersonnage = 'UPDATE personnage 
                                                        SET niveau = niveau + 1, 
                                                        niveauEnAttente = niveauEnAttente - 1 
                                                        WHERE idPersonnage = :idPersonnage';

                            $modifierPersonnage = $bdd->prepare($sqlModifierPersonnage, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                            $modifierPersonnage->bindParam(':idPersonnage', $idPersonnage, PDO::PARAM_INT);
                            $modifierPersonnage->execute();

                            $bdd = null;

                            http_response_code(201);
                            deliver_responseRest(201, $personnage->_nom . " gagne un niveau.", $fetchedResult);
                        }
                    } else {
                        http_response_code(451);
                        deliver_responseRest(451, "Il peut progresser, mais pas de cette manière. Reformulez !", '');
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
