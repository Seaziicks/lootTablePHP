<?php


class EffetMagiqueTableTitleContentManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueTableTitleContent($idEffetMagiqueTableTitleContent)
    {
        $idEffetMagiqueTableTitleContent = (int)$idEffetMagiqueTableTitleContent;
        $EffetMagiqueTableTitleContentQuery = $this->_db->query('SELECT *
                                                    FROM EffetMagiqueTableTitleContent
                                                    WHERE idEffetMagiqueTableTitleContent = ' . $idEffetMagiqueTableTitleContent);

        $EffetMagiqueTableTitleContentFetched = $EffetMagiqueTableTitleContentQuery->fetch(PDO::FETCH_ASSOC);

        $TableTitleContent = new EffetMagiqueTableTitleContent($EffetMagiqueTableTitleContentFetched);
        return $TableTitleContent;
    }

    public function getAllEffetMagiqueTableTitleContent(int $idEffetMagiqueTableTitle)
    {
        $effetMagiqueTableTitleContentQuery = $this->_db->query('SELECT *
                                                    FROM effetMagiqueTableTitleContent
                                                    WHERE idEffetMagiqueTableTitle =' . $idEffetMagiqueTableTitle);

        $allEffetMagiqueTableTitleContent = [];
        while($effetMagiqueTableTitleContentFetched = $effetMagiqueTableTitleContentQuery->fetch(PDO::FETCH_ASSOC)) {
            $TableTitleContent = new EffetMagiqueTableTitleContent($effetMagiqueTableTitleContentFetched);
            array_push($allEffetMagiqueTableTitleContent, $TableTitleContent);
        };

        return $allEffetMagiqueTableTitleContent;
    }

    public function addEffetMagiqueTableTitleContent($effetMagiqueTableTitleContentData, $idEffetMagiqueTableTitle)
    {
        $effetMagiqueTableTitleContent = json_decode($effetMagiqueTableTitleContentData)->TableTitleContent;
        $sql = "INSERT INTO `effetMagiqueTableTitleContent` (`idEffetMagiqueTableTitle`,`contenu`) 
                    VALUES (:idEffetMagiqueTableTitle, :contenu)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTitle',$idEffetMagiqueTableTitle, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueTableTitleContent->contenu, PDO::PARAM_STR);
        $commit->execute();
        $tableTitleContentIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTitleContent 
                    where idEffetMagiqueTableTitleContent=' . $tableTitleContentIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $TableTitleContent = new EffetMagiqueTableTitleContent($fetchedResult);
        return $TableTitleContent;
    }

    public function updateEffetMagiqueTableTitleContent($effetMagiqueTableTitleContentData)
    {
        $effetMagiqueTableTitleContent = json_decode($effetMagiqueTableTitleContentData);
        $sql = "UPDATE effetMagiqueTableTitleContent 
                SET idEffetMagiqueTableTitle = '" . $effetMagiqueTableTitleContent->idEffetMagiqueTableTitle . "', 
                contenu = '" . $effetMagiqueTableTitleContent->contenu . "'
                WHERE idEffetMagiqueTableTitleContent = " . $effetMagiqueTableTitleContent->idEffetMagiqueTableTitleContent;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagiqueTableTitleContent
                    where idEffetMagiqueTableTitleContent='.$effetMagiqueTableTitleContent->idEffetMagiqueTableTitleContent);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueTableTitleContent($fetchedResult);
    }

    public function deleteEffetMagiqueTableTitleContent($idEffetMagiqueTableTitleContent)
    {
        $this->_db->exec('DELETE FROM effetMagiqueTableTitleContent WHERE idEffetMagiqueTableTitleContent = ' . $idEffetMagiqueTableTitleContent);
    }

    public function getAllEffetMagiqueTableTitleContentAsNotJSon($idEffetMagiqueTableTitle) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTitleContent($idEffetMagiqueTableTitle)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}