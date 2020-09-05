<?php


class PersonnageManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getPersonnage($idPersonnage)
    {
        $idPersonnage = (int)$idPersonnage;
        $personnageQuery = $this->_db->query('SELECT *
                                                    FROM personnage
                                                    WHERE idPersonnage = ' . $idPersonnage);

        $personnageFetched = $personnageQuery->fetch(PDO::FETCH_ASSOC);

        return new Personnage($personnageFetched);
    }

    public function getPersonnageAvecStatistiques($idPersonnage)
    {
        $idPersonnage = (int)$idPersonnage;
        $personnage = $this->getPersonnage($idPersonnage);
        $personnageQuery = $this->_db->query('SELECT s.libelle, m.valeur
                                                        FROM personnage as p, monte as m, statistique as s
                                                        WHERE m.idPersonnage = '. $idPersonnage .'
                                                        AND m.idStatistique = s.idStatistique');

        while($personnageFetched = $personnageQuery->fetch(PDO::FETCH_ASSOC)) {
            $attribute = '_'.strtolower($personnageFetched['libelle']);
            $personnage->$attribute += $personnageFetched['valeur'];
        }

        return $personnage;
    }

    public function getAllPersonnage()
    {
        $personnageQuery = $this->_db->query('SELECT *
                                                    FROM personnage');

        $allPersonnage = [];
        while($personnageFetched = $personnageQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allPersonnage, new Personnage($personnageFetched));
        };

        return $allPersonnage;
    }

    public function getAllPersonnageAvecStatistiques()
    {
        $personnageQuery = $this->_db->query('SELECT idPersonnage
                                                    FROM personnage');

        $allPersonnage = [];
        while($personnageFetched = $personnageQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allPersonnage, $this->getPersonnageAvecStatistiques($personnageFetched['idPersonnage']));
        };

        return $allPersonnage;
    }

    public function addPersonnage($personnageData)
    {
        $personnage = json_decode($personnageData);
        $sql = "INSERT INTO `personnage` (`nom`,`niveau`) 
                                        VALUES (:nom, :niveau)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':nom',$personnage->nom, PDO::PARAM_STR);
        $commit->bindParam(':niveau',$personnage->niveau, PDO::PARAM_INT);
        $commit->execute();
        $result = $this->_db->query('SELECT *
					from personnage 
                    where idPersonnage=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Personnage($fetchedResult);
    }

    public function updatePersonnage($personnageData)
    {
        $personnage = json_decode($personnageData);
        $sql = "UPDATE personnage 
                SET nom = '" . $personnage->nom . "', 
                niveau = '" . $personnage->niveau . "', 
                WHERE idPersonnage = " . $personnage->idPersonnage;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from personnage
                    where idPersonnage='.$personnage->idPersonnage);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Personnage($fetchedResult);
    }

    public function deletePersonnage($idPersonnage)
    {
        $this->_db->exec('DELETE FROM personnage WHERE idPersonnage = ' . $idPersonnage);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}