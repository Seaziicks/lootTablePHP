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
                                                    FROM effetmagiquetabletitle
                                                    WHERE idEffetMagiqueTableTitle = ' . $idEffetMagiqueTableTitle);

        $EffetMagiqueTableTitleFetched = $EffetMagiqueTableTitleQuery->fetch(PDO::FETCH_ASSOC);

        $TableTitle = new EffetMagiqueTableTitle($EffetMagiqueTableTitleFetched);
        return $TableTitle;
    }

    public function getAllEffetMagiqueTableTitle(int $idEffetMagiqueTable)
    {
        $effetMagiqueTableTitleQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquetabletitle
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
        $effetMagiqueTableTitle = json_decode($effetMagiqueTableTitleData);
        $sql = "INSERT INTO `effetMagiqueTableTitle` (`idEffetMagiqueTable`) 
                    VALUES (:idEffetMagiqueTable)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTitle',$idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->execute();
        $tableTitleIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					FROM effetmagiquetabletitle 
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
                SET idEffetMagiqueTable = :idEffetMagiqueTable
                WHERE idEffetMagiqueTableTitle = :idEffetMagiqueTableTitle";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTitle',$effetMagiqueTableTitle->idEffetMagiqueTableTitle, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagiqueTable',$effetMagiqueTableTitle->idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->execute();


        $result = $this->_db->query('SELECT *
					FROM effetmagiquetabletitle
                    where idEffetMagiqueTableTitle='.$effetMagiqueTableTitle->idEffetMagiqueTableTitle);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTableTitle($fetchedResult);
    }

    public function deleteEffetMagiqueTableTitle($idEffetMagiqueTableTitle)
    {
        $commit = $this->_db->prepare('DELETE FROM effetmagiquetabletitle WHERE idEffetMagiqueTableTitle = :idEffetMagiqueTableTitle');
        $commit->bindParam(':idEffetMagiqueTableTitle',$idEffetMagiqueTableTitle, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueTableTitleAsNotJSon($idEffetMagiqueTableTitle) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTitle($idEffetMagiqueTableTitle)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}