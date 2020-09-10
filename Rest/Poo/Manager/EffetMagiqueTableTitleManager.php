<?php


class EffetMagiqueTableTitleManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueTableTitle($idEffetMagiqueTableTitle)
    {
        $idEffetMagiqueTableTitle = (int)$idEffetMagiqueTableTitle;
        $EffetMagiqueTableTitleQuery = $this->_db->query('SELECT *
                                                    FROM EffetMagiqueTableTitle
                                                    WHERE idEffetMagiqueTableTitle = ' . $idEffetMagiqueTableTitle);

        $EffetMagiqueTableTitleFetched = $EffetMagiqueTableTitleQuery->fetch(PDO::FETCH_ASSOC);

        $TableTitle = new EffetMagiqueTableTitle($EffetMagiqueTableTitleFetched);
        return $TableTitle;
    }

    public function getAllEffetMagiqueTableTitle(int $idEffetMagiqueTable)
    {
        $effetMagiqueTableTitleQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueTableTitle
                                                    WHERE idEffetMagiqueTable =' . $idEffetMagiqueTable);

        $allEffetMagiqueTableTitle = [];
        while($effetMagiqueTableTitleFetched = $effetMagiqueTableTitleQuery->fetch(PDO::FETCH_ASSOC)) {
            $TableTitle = new EffetMagiqueTableTitle($effetMagiqueTableTitleFetched);
            $TableTitle->updateTitleContent($this->_db);
            array_push($allEffetMagiqueTableTitle, $TableTitle);
        };

        return $allEffetMagiqueTableTitle;
    }

    public function addEffetMagiqueTableTitle($effetMagiqueTableTitleData, $idEffetMagiqueTable)
    {
        $effetMagiqueTableTitle = json_decode($effetMagiqueTableTitleData)->TableTitle;
        $sql = "INSERT INTO `effetMagiqueTableTitle` (`idEffetMagiqueTable`) 
                    VALUES (:idEffetMagiqueTable)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTitle',$idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->execute();
        $tableTitleIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTitle 
                    where idEffetMagiqueTableTitle=' . $tableTitleIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $TableTitle = new EffetMagiqueTableTitle($fetchedResult);
        return $TableTitle;
    }

    public function updateEffetMagiqueTableTitle($effetMagiqueTableTitleData)
    {
        $effetMagiqueTableTitle = json_decode($effetMagiqueTableTitleData);
        $sql = "UPDATE effetMagiqueTableTitle 
                SET idEffetMagiqueTable = '" . $effetMagiqueTableTitle->idEffetMagiqueTable . "' 
                WHERE idEffetMagiqueTableTitle = " . $effetMagiqueTableTitle->idEffetMagiqueTableTitle;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTitle
                    where idEffetMagiqueTableTitle='.$effetMagiqueTableTitle->idEffetMagiqueTableTitle);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTableTitle($fetchedResult);
    }

    public function deleteEffetMagiqueTableTitle($idEffetMagiqueTableTitle)
    {
        $this->_db->exec('DELETE FROM effetMagiqueTableTitle WHERE idEffetMagiqueTableTitle = ' . $idEffetMagiqueTableTitle);
    }

    public function getAllEffetMagiqueTableTitleAsNotJSon($idEffetMagiqueTableTitle) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTitle($idEffetMagiqueTableTitle)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}