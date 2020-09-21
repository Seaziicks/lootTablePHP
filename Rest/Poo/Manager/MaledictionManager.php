<?php


class MaledictionManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getMalediction($idMalediction)
    {
        $idMalediction = (int)$idMalediction;
        $maledictionQuery = $this->_db->query('SELECT *
                                                    FROM malediction
                                                    WHERE idMalediction = ' . $idMalediction);

        $maledictionFetched = $maledictionQuery->fetch(PDO::FETCH_ASSOC);

        return new Malediction($maledictionFetched);
    }

    public function getAllMalediction()
    {
        $maledictionQuery = $this->_db->query('SELECT *
                                                    FROM malediction');

        $allMalediction = [];
        while($maledictionFetched = $maledictionQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allMalediction, new Malediction($maledictionFetched));
        };

        return $allMalediction;
    }

    public function addMalediction($maledictionData)
    {
        $malediction = json_decode($maledictionData);
        $sql = "INSERT INTO `malediction` (`nom`,`description`) 
                                        VALUES (:nom, :description)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':nom',$malediction->nom, PDO::PARAM_STR);
        $commit->bindParam(':description',$malediction->description, PDO::PARAM_STR);
        $commit->execute();
        $result = $this->_db->query('SELECT *
					FROM malediction 
                    where idMalediction=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Malediction($fetchedResult);
    }

    public function updateMalediction($maledictionData)
    {
        $malediction = json_decode($maledictionData);
        $sql = "UPDATE malediction 
                SET nom = :nom, 
                description = :description
                WHERE idMalediction = :idMalediction";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idMalediction',$malediction->idMalediction, PDO::PARAM_INT);
        $commit->bindParam(':nom',$malediction->nom, PDO::PARAM_STR);
        $commit->bindParam(':description',$malediction->description, PDO::PARAM_STR);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM malediction
                    where idMalediction='.$malediction->idMalediction);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Malediction($fetchedResult);
    }

    public function deleteMalediction($idMalediction)
    {
        $commit = $this->_db->prepare('DELETE FROM malediction WHERE idMalediction = :idMalediction');
        $commit->bindParam(':idMalediction',$idMalediction, PDO::PARAM_INT);
        $commit->execute();
        return $commit->rowCount();
    }

    public function getMaledictionAsNonJSon($idMateriaux) {
        return json_decode(json_encode($this->getMalediction($idMateriaux)));
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}