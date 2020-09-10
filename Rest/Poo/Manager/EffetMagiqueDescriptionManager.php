<?php


class EffetMagiqueDescriptionManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueDescription($idEffetMagiqueDescription)
    {
        $idEffetMagiqueDescription = (int)$idEffetMagiqueDescription;
        $effetMagiqueDescriptionQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueDescription
                                                    WHERE idEffetMagiqueDescription = ' . $idEffetMagiqueDescription);

        $effetMagiqueDescriptionFetched = $effetMagiqueDescriptionQuery->fetch(PDO::FETCH_ASSOC);

        $Description = new EffetMagiqueDescription($effetMagiqueDescriptionFetched);
        return $Description;
    }

    public function getAllEffetMagiqueDescription(int $idEffetMagique)
    {
        $effetMagiqueDescriptionQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueDescription
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueDescription = [];
        while($effetMagiqueDescriptionFetched = $effetMagiqueDescriptionQuery->fetch(PDO::FETCH_ASSOC)) {
            $Description = new EffetMagiqueDescription($effetMagiqueDescriptionFetched);
            array_push($allEffetMagiqueDescription, $Description);
        };

        return $allEffetMagiqueDescription;
    }

    public function addEffetMagiqueDescription($effetMagiqueDescriptionData, $idEffetMagique)
    {
        $effetMagiqueDescription = json_decode($effetMagiqueDescriptionData)->Description;
        $sql = "INSERT INTO `effetMagiqueDescription` (`idEffetMagique`,`contenu`) 
                    VALUES (:idEffetMagique, :contenu)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueDescription->contenu, PDO::PARAM_STR);
        $commit->execute();
        $descriptionIndex = $this->_db->lastInsertId();
        

        $result = $this->_db->query('SELECT *
					from effetMagiqueDescription 
                    where idEffetMagiqueDescription=' . $descriptionIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Description = new EffetMagiqueDescription($fetchedResult);
        return $Description;
    }

    public function updateEffetMagiqueDescription($effetMagiqueDescriptionData)
    {
        $effetMagiqueDescription = json_decode($effetMagiqueDescriptionData);
        $sql = "UPDATE effetMagiqueDescription 
                SET idEffetMagique = '" . $effetMagiqueDescription->idEffetMagique . "', 
                contenu = '" . $effetMagiqueDescription->contenu . "'
                WHERE idEffetMagiqueDescription = " . $effetMagiqueDescription->idEffetMagiqueDescription;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagiqueDescription
                    where idEffetMagiqueDescription='.$effetMagiqueDescription->idEffetMagiqueDescription);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueDescription($fetchedResult);
    }

    public function deleteEffetMagiqueDescription($idEffetMagiqueDescription)
    {
        $this->_db->exec('DELETE FROM effetMagiqueDescription WHERE idEffetMagiqueDescription = ' . $idEffetMagiqueDescription);
    }

    public function getAllEffetMagiqueDescriptionAsNotJSon($idEffetMagique) {
        return json_decode(json_encode($this->getAllEffetMagiqueDescription($idEffetMagique)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}