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
                                                    FROM effetmagiquedescription
                                                    WHERE idEffetMagiqueDescription = ' . $idEffetMagiqueDescription);

        $effetMagiqueDescriptionFetched = $effetMagiqueDescriptionQuery->fetch(PDO::FETCH_ASSOC);

        $Description = new EffetMagiqueDescription($effetMagiqueDescriptionFetched);
        return $Description;
    }

    public function getAllEffetMagiqueDescription(int $idEffetMagique)
    {
        $effetMagiqueDescriptionQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquedescription
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
        $effetMagiqueDescription = json_decode($effetMagiqueDescriptionData);
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
                SET idEffetMagique = :idEffetMagique, 
                contenu = :contenu
                WHERE idEffetMagiqueDescription = :idEffetMagiqueDescription";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueDescription',$effetMagiqueDescription->idEffetMagiqueDescription, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagique',$effetMagiqueDescription->idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueDescription->contenu, PDO::PARAM_STR);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					from effetMagiqueDescription
                    where idEffetMagiqueDescription='.$effetMagiqueDescription->idEffetMagiqueDescription);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueDescription($fetchedResult);
    }

    public function deleteEffetMagiqueDescription($effetMagiqueDescription)
    {
        $commit = $this->_db->prepare('DELETE FROM effetmagiquedescription WHERE idEffetMagiqueDescription = :idEffetMagiqueDescription');
        $commit->bindParam(':idEffetMagiqueDescription',$effetMagiqueDescription->idEffetMagiqueDescription, PDO::PARAM_INT);

        $this->modifierTableEtUlPosition($effetMagiqueDescription);

        $commit->execute();
        return $commit->rowCount();
    }

    public function modifierTableEtUlPosition($effetMagiqueDescription) {

        print_r($effetMagiqueDescription);

        $effetMagiqueDescriptionQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquedescription
                                                    WHERE idEffetMagique =' . $effetMagiqueDescription->idEffetMagique);

        $descriptions = $effetMagiqueDescriptionQuery->fetchAll(PDO::FETCH_ASSOC);

        $position = array_search($effetMagiqueDescription->idEffetMagiqueDescription, array_column($descriptions, 'idEffetMagiqueDescription'));

        print_r($position);

        $sql = "UPDATE EffetMagiqueTable
                SET position = position - 1
                WHERE idEffetMagique = " . $effetMagiqueDescription->idEffetMagique ."
                AND position > ". $position ."";
        $this->_db->exec($sql);

        $sql = "UPDATE EffetMagiqueUl
                SET position = position - 1
                WHERE idEffetMagique = " . $effetMagiqueDescription->idEffetMagique ."
                AND position > ". $position ."";
        $this->_db->exec($sql);
    }

    public function getAllEffetMagiqueDescriptionAsNotJSon($idEffetMagique) {
        return json_decode(json_encode($this->getAllEffetMagiqueDescription($idEffetMagique)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}