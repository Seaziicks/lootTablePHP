<?php


class MateriauxManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getMateriaux($idMateriaux)
    {
        $idMateriaux = (int)$idMateriaux;
        $materiauxQuery = $this->_db->query('SELECT *
                                                    FROM materiaux
                                                    WHERE idMateriaux = ' . $idMateriaux);

        $materiauxFetched = $materiauxQuery->fetch(PDO::FETCH_ASSOC);

        return new Materiaux($materiauxFetched);
    }

    public function getAllMateriaux()
    {
        $materiauxQuery = $this->_db->query('SELECT *
                                                    FROM materiaux');

        $allMateriaux = [];
        while($materiauxFetched = $materiauxQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allMateriaux, new Materiaux($materiauxFetched));
        };

        return $allMateriaux;
    }

    public function addMateriaux($materiauxData)
    {
        $materiaux = json_decode($materiauxData);
        $sql = "INSERT INTO `materiaux` (`nom`,`effet`) 
                                        VALUES (:nom, :description)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':nom',$materiaux->nom, PDO::PARAM_STR);
        $commit->bindParam(':effet',$materiaux->effet, PDO::PARAM_STR);
        $commit->execute();
        $result = $this->_db->query('SELECT *
					from materiaux 
                    where idMateriaux=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Materiaux($fetchedResult);
    }

    public function updateMateriaux($materiauxData)
    {
        $materiaux = json_decode($materiauxData);
        $sql = "UPDATE materiaux 
                SET nom = '" . $materiaux->nom . "', 
                effet = '" . $materiaux->effet . "', 
                WHERE idMateriaux = " . $materiaux->idMateriaux;


        $this->_db->exec($sql);
        $result = $this->_db->query('SELECT *
					from materiaux
                    where idMateriaux='.$materiaux->idMateriaux);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Materiaux($fetchedResult);
    }

    public function deleteMateriaux($idMateriaux)
    {
        $this->_db->exec('DELETE FROM materiaux WHERE idMateriaux = ' . $idMateriaux);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}