<?php


class EffetMagiqueManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getEffetMagique($idEffetMagique)
    {
        $idEffetMagique = (int)$idEffetMagique;
        $effetMagiqueQuery = $this->_db->query('SELECT *
                                                    FROM effetMagique
                                                    WHERE idEffetMagique = ' . $idEffetMagique);

        $effetMagiqueFetched = $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC);

        return new EffetMagique($effetMagiqueFetched);
    }

    public function getAllEffetMagique()
    {
        $effetMagiqueQuery = $this->_db->query('SELECT *
                                                    FROM effetMagique');

        $allEffetMagique = [];
        while($effetMagiqueFetched = $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allEffetMagique, new EffetMagique($effetMagiqueFetched));
        };

        return $allEffetMagique;
    }

    public function addEffetMagique($effetMagiqueData)
    {
        $effetMagique = json_decode($effetMagiqueData);
        $sql = "INSERT INTO `effetMagique` (`idObjet`,`nom`) 
                                        VALUES (:nom, :description)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idObjet',$effetMagique->idObjet, PDO::PARAM_INT);
        $commit->bindParam(':nom',$effetMagique->nom, PDO::PARAM_STR);
        $commit->execute();
        $result = $this->_db->query('SELECT *
					from effetMagique 
                    where idEffetMagique=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagique($fetchedResult);
    }

    public function updateEffetMagique($effetMagiqueData)
    {
        $effetMagique = json_decode($effetMagiqueData);
        $sql = "UPDATE effetMagique 
                SET idObjet = '" . $effetMagique->idObjet . "', 
                nom = '" . $effetMagique->nom . "', 
                WHERE idEffetMagique = " . $effetMagique->idEffetMagique;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from effetMagique
                    where idEffetMagique='.$effetMagique->idEffetMagique);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new EffetMagique($fetchedResult);
    }

    public function deleteEffetMagique($idEffetMagique)
    {
        $this->_db->exec('DELETE FROM effetMagique WHERE idEffetMagique = ' . $idEffetMagique);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}