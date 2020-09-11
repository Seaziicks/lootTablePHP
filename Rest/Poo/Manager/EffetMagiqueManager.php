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

    public function getAllEffetMagiqueForObjet($idObjet)
    {
        $effetMagiqueQuery = $this->_db->query('SELECT *
                                                    FROM effetMagique
                                                    WHERE idObjet=' . $idObjet);

        $allEffetMagique = [];
        while($effetMagiqueFetched = $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allEffetMagique, new EffetMagique($effetMagiqueFetched));
        };

        return $allEffetMagique;
    }

    public function addEffetMagique($effetMagiqueData)
    {
        $effetMagique = json_decode($effetMagiqueData);
        $sql = "INSERT INTO `effetMagique` (`idObjet`,`title`) 
                                        VALUES (:idObjet, :title)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idObjet',$effetMagique->idObjet, PDO::PARAM_INT);
        $commit->bindParam(':title',$effetMagique->title, PDO::PARAM_STR);
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
                title = '" . $effetMagique->title . "', 
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

    public function getCompleteEffetMagiqueAsNotJson($idEffetMagique) {
        $EffetMagique = $this->getEffetMagique($idEffetMagique);
        $Effet = json_decode(json_encode($EffetMagique));

        $TableManager = new EffetMagiqueTableManager($this->_db);
        $UlManager = new EffetMagiqueUlManager($this->_db);
        $Effet->description = $this->getDescription($idEffetMagique);
        $infos=new stdClass();
        $infos->data = $this->getInfos($idEffetMagique);
        $Effet->infos = $infos;
        $Effet->ul = $UlManager->getAllEffetMagiqueUlAsNotJSon($idEffetMagique);
        $Effet->table = $TableManager->getAllEffetMagiqueTableAsNotJSon($idEffetMagique);
        return $Effet;
    }

    public function getCompleteEffetMagiqueAsNotJsonBis($idEffetMagique) {
        $EffetMagique = $this->getEffetMagique($idEffetMagique);
        $Effet = json_decode(json_encode($EffetMagique));

        $TableManager = new EffetMagiqueTableManager($this->_db);
        $UlManager = new EffetMagiqueUlManager($this->_db);
        $DescriptionManager = new EffetMagiqueDescriptionManager($this->_db);
        $InfosManager = new EffetMagiqueInfosManager($this->_db);

        $Effet->effetMagiqueDescription = $DescriptionManager->getAllEffetMagiqueDescription($idEffetMagique);
        $infos=new stdClass();
        $infos->data = $this->getInfos($idEffetMagique);
        $Effet->effetMagiqueDBInfos = $InfosManager->getAllEffetMagiqueInfos($idEffetMagique);
        $Effet->effetMagiqueUl = $UlManager->getAllEffetMagiqueUlAsNotJSonBis($idEffetMagique);
        $Effet->effetMagiqueTable = $TableManager->getAllEffetMagiqueTableAsNotJSonBis($idEffetMagique);
        return $Effet;
    }

    public function getAllEffetMagiqueTableAsNotJSon($idObjet) {
        $EffetsMagiques = [];
        $effetMagiqueQuery = $this->_db->query('SELECT *
                                                    FROM effetMagique
                                                    WHERE idObjet = ' . $idObjet);

        while($effetMagiqueFetched = $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($EffetsMagiques, $this->getCompleteEffetMagiqueAsNotJson($effetMagiqueFetched['idEffetMagique']));
        }
        return $EffetsMagiques;
    }

    public function getAllEffetMagiqueTableAsNotJSonBis($idObjet) {
        $EffetsMagiques = [];
        $effetMagiqueQuery = $this->_db->query('SELECT *
                                                    FROM effetMagique
                                                    WHERE idObjet = ' . $idObjet);

        while($effetMagiqueFetched = $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($EffetsMagiques, $this->getCompleteEffetMagiqueAsNotJsonBis($effetMagiqueFetched['idEffetMagique']));
        }
        return $EffetsMagiques;
    }

    private function getInfos($idEffetMagique) {
        $effetMagiqueInfosQuery = $this->_db->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagique=' . $idEffetMagique);

        $infos = [];
        while($effetMagiqueInfos =  $effetMagiqueInfosQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($infos, $effetMagiqueInfos['contenu']);
        }
        return $infos;
    }

    private function getDescription($idEffetMagique) {
        $effetMagiqueDescriptionsQuery = $this->_db->query('SELECT *
					from effetMagiquedescription
                    where idEffetMagique=' . $idEffetMagique);

        $descriptions = [];
        while($effetMagiqueDescriptions =  $effetMagiqueDescriptionsQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($descriptions, $effetMagiqueDescriptions['contenu']);
        }
        return $descriptions;
    }

    public function addCompleteEffetMagique($effetMagiqueData, $idObjet) {
        $effet = clone $effetMagiqueData;
        $effet->idObjet = $idObjet;
        unset($effet->table);
        unset($effet->ul);
        unset($effet->description);
        unset($effet->infos);
        $createdEffet = $this->addEffetMagique(json_encode($effet));

        // Gestion des Table
        if($effetMagiqueData->table) {
            $this->addTable($effetMagiqueData->table, $createdEffet->_idEffetMagique);
        }

        // Gestion des Ul
        if($effetMagiqueData->ul) {
            $this->addUl($effetMagiqueData->ul, $createdEffet->_idEffetMagique);
        }
        $this->addDescription($effetMagiqueData->description, $createdEffet->_idEffetMagique);
        $this->addInfos($effetMagiqueData->infos->data, $createdEffet->_idEffetMagique);
    }

    public function addDescription($descriptions, $idEffetMagique) {
        $idDescriptions = '';
        foreach ($descriptions as $description) {
            $sql = "INSERT INTO `effetMagiqueDescription` (`idEffetMagique`,`contenu`) 
                                        VALUES (:idEffetMagique, :contenu)";

            $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagique', $idEffetMagique, PDO::PARAM_INT);
            $commit->bindParam(':contenu', $description, PDO::PARAM_STR);
            $commit->execute();
            $idDescriptions .= $this->_db->lastInsertId();
            if ($description != $descriptions[count($descriptions) - 1]) {
                $idDescriptions .= ", ";
            }
        }
        $result = $this->_db->query('SELECT *
					from effetMagiqueDescription 
                    where idEffetMagiqueDescription in (' . $idDescriptions . ')
                    ');
        $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return $fetchedResult;
    }

    public function addInfos($infos, $idEffetMagique) {
        $idInfos = '';
        foreach ($infos as $info) {
            $sql = "INSERT INTO `effetMagiqueInfos` (`idEffetMagique`,`contenu`) 
                                        VALUES (:idEffetMagique, :contenu)";

            $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagique', $idEffetMagique, PDO::PARAM_INT);
            $commit->bindParam(':contenu', $info, PDO::PARAM_STR);
            $commit->execute();
            $idInfos .= $this->_db->lastInsertId();
            if ($info != $infos[count($infos) - 1]) {
                $idInfos .= ", ";
            }
        }

        $result = $this->_db->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagiqueInfos in (' . $idInfos . ')
                    ');
        $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return $fetchedResult;
    }

    public function addTable($tables, $idEffetMagique) {
        $EffetMagiqueTableManager = new EffetMagiqueTableManager($this->_db);
        foreach ($tables as $tableToAdd) {
            $table = new stdClass();
            $table->Table = $tableToAdd;
            $EffetMagiqueTableManager->addEffetMagiqueTable(json_encode($table), $idEffetMagique);
        }
    }

    public function addUl($uls, $idEffetMagique) {
        $EffetMagiqueUlManager = new EffetMagiqueUlManager($this->_db);
        foreach ($uls as $ulToAdd) {
            $ul = new stdClass();
            $ul->Ul = $ulToAdd;
            $EffetMagiqueUlManager->addCompleteEffetMagiqueUl(json_encode($ul), $idEffetMagique);
        }
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}