<?php


class EffetMagiqueUlContentManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagiqueUlContent($idEffetMagiqueUlContent)
    {
        $idEffetMagiqueUlContent = (int)$idEffetMagiqueUlContent;
        $EffetMagiqueUlContentQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiqueulcontent
                                                    WHERE idEffetMagiqueUlContent = ' . $idEffetMagiqueUlContent);

        $EffetMagiqueUlContentFetched = $EffetMagiqueUlContentQuery->fetch(PDO::FETCH_ASSOC);

        $UlContent = new EffetMagiqueUlContent($EffetMagiqueUlContentFetched);
        return $UlContent;
    }

    public function getAllEffetMagiqueUlContent(int $idEffetMagiqueUl)
    {
        $effetMagiqueUlContentQuery = $this->_db->query('SELECT *
                                                    FROM effetmagiqueulcontent
                                                    WHERE idEffetMagiqueUl =' . $idEffetMagiqueUl);

        $allEffetMagiqueUlContent = [];
        while($effetMagiqueUlContentFetched = $effetMagiqueUlContentQuery->fetch(PDO::FETCH_ASSOC)) {
            $UlContent = new EffetMagiqueUlContent($effetMagiqueUlContentFetched);
            array_push($allEffetMagiqueUlContent, $UlContent);
        };

        return $allEffetMagiqueUlContent;
    }

    public function addEffetMagiqueUlContent($effetMagiqueUlContentData, $idEffetMagiqueUl)
    {
        $effetMagiqueUlContent = json_decode($effetMagiqueUlContentData);
        $sql = "INSERT INTO `effetmagiqueulcontent` (`idEffetMagiqueUl`,`contenu`) 
                    VALUES (:idEffetMagiqueUl, :contenu)";
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueUl',$idEffetMagiqueUl, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueUlContent->contenu, PDO::PARAM_STR);
        $commit->execute();
        $UlContentIndex = $this->_db->lastInsertId();

        $result = $this->_db->query('SELECT *
					FROM effetmagiqueulcontent 
                    where idEffetMagiqueUlContent=' . $UlContentIndex . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        $UlContent = new EffetMagiqueUlContent($fetchedResult);
        return $UlContent;
    }

    public function updateEffetMagiqueUlContent($effetMagiqueUlContentData)
    {
        $effetMagiqueUlContent = json_decode($effetMagiqueUlContentData);
        $sql = "UPDATE effetmagiqueulcontent 
                SET idEffetMagiqueUl = :idEffetMagiqueUl, 
                contenu = :contenu
                WHERE idEffetMagiqueUlContent = :idEffetMagiqueUlContent";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idEffetMagiqueUlContent',$effetMagiqueUlContent->idEffetMagiqueUlContent, PDO::PARAM_INT);
        $commit->bindParam(':idEffetMagiqueUl',$effetMagiqueUlContent->idEffetMagiqueUl, PDO::PARAM_INT);
        $commit->bindParam(':contenu',$effetMagiqueUlContent->contenu, PDO::PARAM_STR);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM effetmagiqueulcontent
                    where idEffetMagiqueUlContent='.$effetMagiqueUlContent->idEffetMagiqueUlContent);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagiqueUlContent($fetchedResult);
    }

    public function deleteEffetMagiqueUlContent($idEffetMagiqueUlContent)
    {
        $commit = $this->_db->prepare('DELETE FROM effetmagiqueulcontent WHERE idEffetMagiqueUlContent = :idEffetMagiqueUlContent');
        $commit->bindParam(':idEffetMagiqueUlContent',$idEffetMagiqueUlContent, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getAllEffetMagiqueUlContentAsNotJSon($idEffetMagiqueUl) {
        return json_decode(json_encode($this->getAllEffetMagiqueUlContent($idEffetMagiqueUl)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}