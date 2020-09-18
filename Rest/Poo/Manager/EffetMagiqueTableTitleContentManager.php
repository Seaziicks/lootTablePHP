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
                                                    FROM effetmagiquetabletitlecontent
                                                    WHERE idEffetMagiqueTableTitleContent = ' . $idEffetMagiqueTableTitleContent);

        $EffetMagiqueTableTitleContentFetched = $EffetMagiqueTableTitleContentQuery->fetch(PDO::FETCH_ASSOC);

        $TableTitleContent = new EffetMagiqueTableTitleContent($EffetMagiqueTableTitleContentFetched);
        return $TableTitleContent;
    }

    public function getAllEffetMagiqueTableTitleContent(int $idEffetMagiqueTableTitle)
    {
        $effetMagiqueTableTitleContentQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiquetabletitlecontent
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
        $effetMagiqueTableTitleContent = json_decode($effetMagiqueTableTitleContentData);
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
                SET idEffetMagiqueTableTitle = :idEffetMagiqueTableTitle, 
                contenu = :contenu 
                WHERE idEffetMagiqueTableTitleContent = :idEffetMagiqueTableTitleContent";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueTableTitleContent',$effetMagiqueTableTitleContent->idEffetMagiqueTableTitleContent, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagiqueTableTitle',$effetMagiqueTableTitleContent->idEffetMagiqueTableTitle, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueTableTitleContent->contenu, PDO::PARAM_STR);
        $commit->execute();


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
        $commit = $this->_db->prepare('DELETE FROM effetmagiquetabletitlecontent WHERE idEffetMagiqueTableTitleContent = :idEffetMagiqueTableTitleContent');
        $commit->bindParam(':idEffetMagiqueTableTitleContent',$idEffetMagiqueTableTitleContent, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueTableTitleContentAsNotJSon($idEffetMagiqueTableTitle) {
        return json_decode(json_encode($this->getAllEffetMagiqueTableTitleContent($idEffetMagiqueTableTitle)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}