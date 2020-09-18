<?php


class EffetMagiqueDecouvertManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueDecouvert(int $idObjet, int $idPersonnage)
    {
        $idPersonnage = (int)$idPersonnage;
        $idObjet = (int)$idObjet;
        $effetMagiqueDecouvertQuery = $this->_db->query('SELECT *
                                                    FROM effetdecouvert
                                                    WHERE idPersonnage = ' . $idPersonnage . '
                                                    AND idObjet = ' . $idObjet);

        $effetsDecouverts = [];
        while ($effetMagiqueDecouvertFetched = $effetMagiqueDecouvertQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($effetsDecouverts, new EffetMagiqueDecouvert($effetMagiqueDecouvertFetched));
        }

        return $effetsDecouverts;
    }

    public function getAllEffetMagiqueDecouvert(int $idObjet)
    {
        $effetMagiqueDecouvertQuery = $this->_db->query('SELECT *
                                                    FROM effetdecouvert
                                                    WHERE idObjet =' . $idObjet);

        $allEffetMagiqueDecouvert = [];
        while ($effetMagiqueDecouvertFetched = $effetMagiqueDecouvertQuery->fetch(PDO::FETCH_ASSOC)) {
            $Decouvert = new EffetMagiqueDecouvert($effetMagiqueDecouvertFetched);
            array_push($allEffetMagiqueDecouvert, $Decouvert);
        };

        return $allEffetMagiqueDecouvert;
    }

    public function addEffetMagiqueDecouvert($effetMagiqueDecouvertData)
    {
        $effetMagiqueDecouvert = json_decode($effetMagiqueDecouvertData);
        $sql = "INSERT INTO `effetdecouvert` (`idPersonnage`,`idObjet`, `effet`) 
                    VALUES (:idPersonnage, :idObjet, :effet)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idPersonnage', $effetMagiqueDecouvert->idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':idObjet', $effetMagiqueDecouvert->idObjet, PDO::PARAM_INT);
        $commit->bindParam(':effet', $effetMagiqueDecouvert->effet, PDO::PARAM_STR);
        $commit->execute();
        $decouvertIndex = $this->_db->lastInsertId();


        $result = $this->_db->query('SELECT *
					FROM effetdecouvert 
                    WHERE idEffetMagiqueDecouvert=' . $decouvertIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Decouvert = new EffetMagiqueDecouvert($fetchedResult);
        return $Decouvert;
    }

    public function updateEffetMagiqueDecouvert($effetMagiqueDecouvertData)
    {
        $effetMagiqueDecouvert = json_decode($effetMagiqueDecouvertData);
        $sql = "UPDATE effetdecouvert 
                SET effet = :effet 
                WHERE idEffetMagiqueDecouvert = :idEffetMagiqueDecouvert";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueDecouvert',$effetMagiqueDecouvert->idEffetMagiqueDecouvert, PDO::PARAM_INT);
        $commit->bindParam(':effet',$effetMagiqueDecouvert->effet, PDO::PARAM_STR);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM effetdecouvert 
                    WHERE idEffetMagiqueDecouvert=' . $effetMagiqueDecouvert->idEffetMagiqueDecouvert . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueDecouvert($fetchedResult);
    }

    public function deleteEffetMagiqueDecouvert($effetMagiqueDecouvert)
    {
        $commit = $this->_db->prepare('DELETE FROM effetdecouvert WHERE idEffetMagiqueDecouvert = :idEffetMagiqueDecouvert');
        $commit->bindParam(':idEffetMagiqueDecouvert', $effetMagiqueDecouvert->idEffetMagiqueDecouvert, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}