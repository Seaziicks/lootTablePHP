<?php


class EffetMagiqueTableManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueTable($idEffetMagiqueTable)
    {
        $idEffetMagiqueTable = (int)$idEffetMagiqueTable;
        $effetMagiqueTableQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquetable
                                                    WHERE idEffetMagiqueTable = ' . $idEffetMagiqueTable);

        $effetMagiqueTableFetched = $effetMagiqueTableQuery->fetch(PDO::FETCH_ASSOC);

        $Table = new EffetMagiqueTable($effetMagiqueTableFetched);
        $Table->updateTitles($this->_db);
        $Table->updateTrs($this->_db);
        return $Table;
    }

    public function getAllEffetMagiqueTable(int $idEffetMagique)
    {
        $effetMagiqueTableQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquetable
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueTable = [];
        while($effetMagiqueTableFetched = $effetMagiqueTableQuery->fetch(PDO::FETCH_ASSOC)) {
            $Table = new EffetMagiqueTable($effetMagiqueTableFetched);
            $Table->updateTitles($this->_db);
            $Table->updateTrs($this->_db);
            array_push($allEffetMagiqueTable, $Table);
        };

        return $allEffetMagiqueTable;
    }

    public function getAllEffetMagiqueTableBis(int $idEffetMagique)
    {
        $effetMagiqueTableQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquetable
                                                    WHERE idEffetMagique =' . $idEffetMagique);

        $allEffetMagiqueTable = [];
        while($effetMagiqueTableFetched = $effetMagiqueTableQuery->fetch(PDO::FETCH_ASSOC)) {
            $Table = new EffetMagiqueTable($effetMagiqueTableFetched);
            $Table->updateTitlesBis($this->_db);
            $Table->updateTrsBis($this->_db);
            array_push($allEffetMagiqueTable, $Table);
        };

        return $allEffetMagiqueTable;
    }

    public function addEffetMagiqueTable($effetMagiqueTableData, $idEffetMagique)
    {
        $effetMagiqueTable = json_decode($effetMagiqueTableData)->Table;
        $sql = "INSERT INTO `effetMagiqueTable` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueTable->position, PDO::PARAM_INT);
        $commit->execute();
        $tableIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					FROM effetmagiquetable 
                    where idEffetMagiqueTable=' . $tableIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Table = new EffetMagiqueTable($fetchedResult);
        $Table->updateTitles($this->_db);
        $Table->updateTrs($this->_db);
        return $Table;
    }

    public function addCompleteEffetMagiqueTable($effetMagiqueTableData, $idEffetMagique)
    {
        $effetMagiqueTable = json_decode($effetMagiqueTableData)->Table;
        $sql = "INSERT INTO `effetMagiqueTable` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagique',$idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueTable->position, PDO::PARAM_INT);
        $commit->execute();
        $tableIndex = $this->_db->lastInsertId();
        foreach($effetMagiqueTable->title as $title) {
            $sql = "INSERT INTO `effetMagiqueTableTitle` (`idEffetMagiqueTable`) 
                                        VALUES (:idEffetMagiqueTable)";
            $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagiqueTable', $tableIndex, PDO::PARAM_INT);
            $commit->execute();
            $tableTitleIndex = $this->_db->lastInsertId();
            foreach ($title as $contenu) {
                $sql = "INSERT INTO `effetMagiqueTableTitleContent` (`idEffetMagiqueTableTitle`,`contenu`) 
                                        VALUES (:idEffetMagiqueTableTitle, :contenu)";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagiqueTableTitle',$tableTitleIndex, PDO::PARAM_INT);
                $commit->bindParam(':contenu',$contenu, PDO::PARAM_STR);
                $commit->execute();
            }

        }

        foreach($effetMagiqueTable->tr as $tr) {
            $sql = "INSERT INTO `effetmagiquetabletr` (`idEffetMagiqueTable`) 
                                        VALUES (:idEffetMagiqueTable)";
            $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagiqueTable', $tableIndex, PDO::PARAM_INT);
            $commit->execute();
            $tableTrIndex = $this->_db->lastInsertId();
            foreach ($tr as $contenu) {
                $sql = "INSERT INTO `effetMagiqueTableTrContent` (`idEffetMagiqueTableTr`,`contenu`) 
                                        VALUES (:idEffetMagiqueTableTr, :contenu)";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagiqueTableTr',$tableTrIndex, PDO::PARAM_INT);
                $commit->bindParam(':contenu',$contenu, PDO::PARAM_STR);
                $commit->execute();
            }
        }

        $result = $this->_db->query('SELECT *
					FROM effetmagiquetable 
                    where idEffetMagiqueTable=' . $tableIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $Table = new EffetMagiqueTable($fetchedResult);
        $Table->updateTitles($this->_db);
        $Table->updateTrs($this->_db);
        return $Table;
    }

    public function updateEffetMagiqueTable($effetMagiqueTableData)
    {
        $effetMagiqueTable = json_decode($effetMagiqueTableData);
        $sql = "UPDATE effetmagiquetable 
                SET idEffetMagique = :idEffetMagique, 
                position = :position 
                WHERE idEffetMagiqueTable = :idEffetMagiqueTable";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTable',$effetMagiqueTable->idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagique',$effetMagiqueTable->idEffetMagique, PDO::PARAM_INT);
        $commit->bindParam(':position',$effetMagiqueTable->position, PDO::PARAM_INT);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM effetmagiquetable
                    where idEffetMagiqueTable='.$effetMagiqueTable->idEffetMagiqueTable);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTable($fetchedResult);
    }

    public function deleteEffetMagiqueTable($idEffetMagiqueTable)
    {
        $commit = $this->_db->prepare('DELETE FROM effetmagiquetable WHERE idEffetMagiqueTable = :idEffetMagiqueTable');
        $commit->bindParam(':idEffetMagiqueTable',$idEffetMagiqueTable, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueTableAsNotJSon($idEffetMagique) {
        return json_decode(json_encode($this->getAllEffetMagiqueTable($idEffetMagique)));
    }

    public function getAllEffetMagiqueTableAsNotJSonBis($idEffetMagique) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableBis($idEffetMagique)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}