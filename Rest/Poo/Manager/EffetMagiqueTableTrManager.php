<?php


class EffetMagiqueTableTrManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueTableTr($idEffetMagiqueTableTr)
    {
        $idEffetMagiqueTableTr = (int)$idEffetMagiqueTableTr;
        $EffetMagiqueTableTrQuery = $this->_db->query('SELECT *
                                                    FROM EffetMagiqueTableTr
                                                    WHERE idEffetMagiqueTableTr = ' . $idEffetMagiqueTableTr);

        $EffetMagiqueTableTrFetched = $EffetMagiqueTableTrQuery->fetch(PDO::FETCH_ASSOC);

        $TableTr = new EffetMagiqueTableTr($EffetMagiqueTableTrFetched);
        return $TableTr;
    }

    public function getAllEffetMagiqueTableTr(int $idEffetMagiqueTable)
    {
        $EffetMagiqueTableTrQuery = $this->_db->query('SELECT *
                                                    FROM EffetMagiqueTableTr
                                                    WHERE idEffetMagiqueTable =' . $idEffetMagiqueTable);

        $allEffetMagiqueTableTr = [];
        while($EffetMagiqueTableTrFetched = $EffetMagiqueTableTrQuery->fetch(PDO::FETCH_ASSOC)) {
            $TableTr = new EffetMagiqueTableTr($EffetMagiqueTableTrFetched);
            $TableTr->updateTrContent($this->_db);
            array_push($allEffetMagiqueTableTr, $TableTr);
        };

        return $allEffetMagiqueTableTr;
    }

    public function addEffetMagiqueTableTr($EffetMagiqueTableTrData, $idEffetMagiqueTable)
    {
        $EffetMagiqueTableTr = json_decode($EffetMagiqueTableTrData);
        $sql = "INSERT INTO `EffetMagiqueTableTr` (`idEffetMagiqueTable`) 
                    VALUES (:idEffetMagiqueTable)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTr',$idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->execute();
        $tableTrIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					from EffetMagiqueTableTr 
                    where idEffetMagiqueTableTr=' . $tableTrIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $TableTr = new EffetMagiqueTableTr($fetchedResult);
        return $TableTr;
    }

    public function updateEffetMagiqueTableTr($EffetMagiqueTableTrData)
    {
        $EffetMagiqueTableTr = json_decode($EffetMagiqueTableTrData);
        $sql = "UPDATE EffetMagiqueTableTr 
                SET idEffetMagiqueTable = '" . $EffetMagiqueTableTr->idEffetMagiqueTable . "' 
                WHERE idEffetMagiqueTableTr = " . $EffetMagiqueTableTr->idEffetMagiqueTableTr;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from EffetMagiqueTableTr
                    where idEffetMagiqueTableTr='.$EffetMagiqueTableTr->idEffetMagiqueTableTr);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTableTr($fetchedResult);
    }

    public function deleteEffetMagiqueTableTr($idEffetMagiqueTableTr)
    {
        $commit = $this->_db->prepare('DELETE FROM EffetMagiqueTableTr WHERE idEffetMagiqueTableTr = :idEffetMagiqueTableTr');
        $commit->bindParam(':idEffetMagiqueTableTr',$idEffetMagiqueTableTr, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueTableTrAsNotJSon($idEffetMagiqueTableTr) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTr($idEffetMagiqueTableTr)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}