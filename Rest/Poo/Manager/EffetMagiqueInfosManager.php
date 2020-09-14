<?php


class EffetMagiqueInfosManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueInfos($idEffetMagiqueInfos)
    {
        $idEffetMagiqueInfos = (int)$idEffetMagiqueInfos;
        $effetMagiqueInfosQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueInfos
                                                    WHERE idEffetMagiqueInfos = ' . $idEffetMagiqueInfos);

        $effetMagiqueInfosFetched = $effetMagiqueInfosQuery->fetch(PDO::FETCH_ASSOC);

        $Infos = new EffetMagiqueInfos($effetMagiqueInfosFetched);
        return $Infos;
    }

    public function getAllEffetMagiqueInfos(int $idEffetMagique)
    {
        $effetMagiqueInfosQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueInfos
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueInfos = [];
        while($effetMagiqueInfosFetched = $effetMagiqueInfosQuery->fetch(PDO::FETCH_ASSOC)) {
            $Infos = new EffetMagiqueInfos($effetMagiqueInfosFetched);
            array_push($allEffetMagiqueInfos, $Infos);
        };

        return $allEffetMagiqueInfos;
    }

    public function addEffetMagiqueInfos($effetMagiqueInfosData, $idEffetMagique)
    {
        $effetMagiqueInfos = json_decode($effetMagiqueInfosData);
        $sql = "INSERT INTO `effetMagiqueInfos` (`idEffetMagique`,`contenu`) 
                    VALUES (:idEffetMagique, :contenu)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueInfos->contenu, PDO::PARAM_STR);
        $commit->execute();
        $infosIndex = $this->_db->lastInsertId();


        $result = $this->_db->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagiqueInfos=' . $infosIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Infos = new EffetMagiqueInfos($fetchedResult);
        return $Infos;
    }

    public function updateEffetMagiqueInfos($effetMagiqueInfosData)
    {
        $effetMagiqueInfos = json_decode($effetMagiqueInfosData);
        $sql = "UPDATE effetMagiqueInfos 
                SET idEffetMagique = '" . $effetMagiqueInfos->idEffetMagique . "', 
                contenu = '" . $effetMagiqueInfos->contenu . "'
                WHERE idEffetMagiqueInfos = " . $effetMagiqueInfos->idEffetMagiqueInfos;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagiqueInfos
                    where idEffetMagiqueInfos='.$effetMagiqueInfos->idEffetMagiqueInfos);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueInfos($fetchedResult);
    }

    public function deleteEffetMagiqueInfos($idEffetMagiqueInfos)
    {
        $commit = $this->_db->prepare('DELETE FROM effetMagiqueInfos WHERE idEffetMagiqueInfos = :idEffetMagiqueInfos');
        $commit->bindParam(':idEffetMagiqueInfos',$idEffetMagiqueInfos, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueInfosAsNotJSon($idEffetMagique) {
        return json_decode(json_encode($this->getAllEffetMagiqueInfos($idEffetMagique)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}