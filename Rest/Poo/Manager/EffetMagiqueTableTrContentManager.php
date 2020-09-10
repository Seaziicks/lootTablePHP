<?php


class EffetMagiqueTableTrContentManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueTableTrContent($idEffetMagiqueTableTrContent)
    {
        $idEffetMagiqueTableTrContent = (int)$idEffetMagiqueTableTrContent;
        $EffetMagiqueTableTrContentQuery = $this->_db->query('SELECT *
                                                    FROM EffetMagiqueTableTrContent
                                                    WHERE idEffetMagiqueTableTrContent = ' . $idEffetMagiqueTableTrContent);

        $EffetMagiqueTableTrContentFetched = $EffetMagiqueTableTrContentQuery->fetch(PDO::FETCH_ASSOC);

        $tableTrContent = new EffetMagiqueTableTrContent($EffetMagiqueTableTrContentFetched);
        return $tableTrContent;
    }

    public function getAllEffetMagiqueTableTrContent(int $idEffetMagiqueTableTr)
    {
        $effetMagiqueTableTrContentQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueTableTrContent
                                                    WHERE idEffetMagiqueTableTr =' . $idEffetMagiqueTableTr);

        $allEffetMagiqueTableTrContent = [];
        while($effetMagiqueTableTrContentFetched = $effetMagiqueTableTrContentQuery->fetch(PDO::FETCH_ASSOC)) {
            $tableTrContent = new EffetMagiqueTableTrContent($effetMagiqueTableTrContentFetched);
            array_push($allEffetMagiqueTableTrContent, $tableTrContent);
        };

        return $allEffetMagiqueTableTrContent;
    }

    public function addEffetMagiqueTableTrContent($effetMagiqueTableTrContentData, $idEffetMagiqueTableTr)
    {
        $effetMagiqueTableTrContent = json_decode($effetMagiqueTableTrContentData)->tableTrContent;
        $sql = "INSERT INTO `effetMagiqueTableTrContent` (`idEffetMagiqueTableTr`,`contenu`) 
                    VALUES (:idEffetMagiqueTableTr, :contenu)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTr',$idEffetMagiqueTableTr, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueTableTrContent->contenu, PDO::PARAM_STR);
        $commit->execute();
        $tableTrContentIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTrContent 
                    where idEffetMagiqueTableTrContent=' . $tableTrContentIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $tableTrContent = new EffetMagiqueTableTrContent($fetchedResult);
        return $tableTrContent;
    }

    public function updateEffetMagiqueTableTrContent($effetMagiqueTableTrContentData)
    {
        $effetMagiqueTableTrContent = json_decode($effetMagiqueTableTrContentData);
        $sql = "UPDATE effetMagiqueTableTrContent 
                SET idEffetMagiqueTableTr = '" . $effetMagiqueTableTrContent->idEffetMagiqueTableTr . "', 
                contenu = '" . $effetMagiqueTableTrContent->contenu . "'
                WHERE idEffetMagiqueTableTrContent = " . $effetMagiqueTableTrContent->idEffetMagiqueTableTrContent;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTrContent
                    where idEffetMagiqueTableTrContent='.$effetMagiqueTableTrContent->idEffetMagiqueTableTrContent);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTableTrContent($fetchedResult);
    }

    public function deleteEffetMagiqueTableTrContent($idEffetMagiqueTableTrContent)
    {
        $this->_db->exec('DELETE FROM effetMagiqueTableTrContent WHERE idEffetMagiqueTableTrContent = ' . $idEffetMagiqueTableTrContent);
    }

    public function getAllEffetMagiqueTableTrContentAsNotJSon($idEffetMagiqueTableTr) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTrContent($idEffetMagiqueTableTr)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}