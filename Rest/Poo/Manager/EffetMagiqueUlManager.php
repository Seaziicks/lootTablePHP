<?php


class EffetMagiqueUlManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueUl($idEffetMagiqueUl)
    {
        $idEffetMagiqueUl = (int)$idEffetMagiqueUl;
        $effetMagiqueUlQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiqueul
                                                    WHERE idEffetMagiqueUl = ' . $idEffetMagiqueUl);

        $effetMagiqueUlFetched = $effetMagiqueUlQuery->fetch(PDO::FETCH_ASSOC);

        $Ul = new EffetMagiqueUl($effetMagiqueUlFetched);
        $Ul->updateLis($this->_db);
        return $Ul;
    }

    public function getAllEffetMagiqueUl(int $idEffetMagique)
    {
        $effetMagiqueUlQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiqueul
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueUl = [];
        while($effetMagiqueUlFetched = $effetMagiqueUlQuery->fetch(PDO::FETCH_ASSOC)) {
            $Ul = new EffetMagiqueUl($effetMagiqueUlFetched);
            $Ul->updateLis($this->_db);
            array_push($allEffetMagiqueUl, $Ul);
        };

        return $allEffetMagiqueUl;
    }

    public function addEffetMagiqueUl($effetMagiqueUlData, $idEffetMagique)
    {
        $effetMagiqueUl = json_decode($effetMagiqueUlData);
        $sql = "INSERT INTO `effetmagiqueul` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueUl->position, PDO::PARAM_INT);
        $commit->execute();
        $ulIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					from effetMagiqueUl 
                    where idEffetMagiqueUl=' . $ulIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Ul = new EffetMagiqueUl($fetchedResult);
        $Ul->updateLis($this->_db);
        return $Ul;
    }

    public function addCompleteEffetMagiqueUl($effetMagiqueUlData, $idEffetMagique)
    {

        $effetMagiqueUl = json_decode($effetMagiqueUlData)->Ul;
        $sql = "INSERT INTO `effetmagiqueul` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueUl->position, PDO::PARAM_INT);
        $commit->execute();
        $ulIndex = $this->_db->lastInsertId();

        foreach($effetMagiqueUl->li as $li) {
            $sql = "INSERT INTO `effetMagiqueUlContent` (`idEffetMagiqueUl`,`contenu`) 
                                        VALUES (:idEffetMagiqueUl, :contenu)";

            $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagiqueUl',$ulIndex, PDO::PARAM_INT);
            $commit->bindParam(':contenu',$li, PDO::PARAM_STR);
            $commit->execute();
        }

        $result = $this->_db->query('SELECT *
					from effetMagiqueUl 
                    where idEffetMagiqueUl=' . $ulIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Ul = new EffetMagiqueUl($fetchedResult);
        $Ul->updateLis($this->_db);
        return $Ul;
    }

    public function updateEffetMagiqueUl($effetMagiqueUlData)
    {
        $effetMagiqueUl = json_decode($effetMagiqueUlData);
        $sql = "UPDATE effetMagiqueUl 
                SET idEffetMagique = :idEffetMagique, 
                position = :position
                WHERE idEffetMagiqueUl = :idEffetMagiqueUl";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueUl',$effetMagiqueUl->idEffetMagiqueUl, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagique',$effetMagiqueUl->idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueUl->position, PDO::PARAM_INT);
        $commit->execute();


        $result = $this->_db->query('SELECT *
					from effetMagiqueUl
                    where idEffetMagiqueUl='.$effetMagiqueUl->idEffetMagiqueUl);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueUl($fetchedResult);
    }

    public function deleteEffetMagiqueUl($idEffetMagiqueUl)
    {
        $commit = $this->_db->prepare('DELETE FROM effetmagiqueul WHERE idEffetMagiqueUl = :idEffetMagiqueUl');
        $commit->bindParam(':idEffetMagiqueUl',$idEffetMagiqueUl, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueUlAsNotJSon(int $idEffetMagique)
    {
        return json_decode(json_encode($this->getAllEffetMagiqueUl($idEffetMagique)));
    }

    public function getAllEffetMagiqueUlAsNotJSonBis(int $idEffetMagique)
    {
        return json_decode(json_encode($this->getAllEffetMagiqueUlBis($idEffetMagique)));
    }

    public function getAllEffetMagiqueUlBis(int $idEffetMagique)
    {
        $effetMagiqueUlQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiqueul
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueUl = [];
        while($effetMagiqueUlFetched = $effetMagiqueUlQuery->fetch(PDO::FETCH_ASSOC)) {
            $Ul = new EffetMagiqueUl($effetMagiqueUlFetched);
            $Ul->updateLisBis($this->_db);
            array_push($allEffetMagiqueUl, $Ul);
        };

        return $allEffetMagiqueUl;
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}