<?php


class NiveauManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function niveauExist(int $idPersonnage, int $niveau)
    {
        $sql = 'SELECT *
                FROM monte
                WHERE idPersonnage = :idPersonnage
                AND niveau = :niveau';

        $userQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $userQuery->bindParam(':idPersonnage', $idPersonnage, PDO::PARAM_INT);
        $userQuery->bindParam(':niveau', $niveau, PDO::PARAM_INT);
        $userQuery->execute();
        $userFetched = $userQuery->fetch(PDO::FETCH_ASSOC);

        return (bool)$userFetched;
    }

    public function getNiveauFromID($idNiveau)
    {
        $idNiveau = (int)$idNiveau;
        $sql = 'SELECT *
                FROM niveau
                WHERE idNiveau = :idNiveau';

        $niveauQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $niveauQuery->bindParam(':idNiveau',$idNiveau, PDO::PARAM_INT);
        $niveauQuery->execute();

        $niveauFetched = $niveauQuery->fetch(PDO::FETCH_ASSOC);

        return new Niveau($niveauFetched);
    }

    public function getNiveauFromNiveauAndPersonnage($niveau, $idPersonnage): Niveau
    {
        $niveau = (int)$niveau;
        $idPersonnage = (int)$idPersonnage;
        $sql = 'SELECT m.idPersonnage, s.idStatistique, s.libelle, m.niveau, m.valeur
                FROM monte as m, statistique as s
                WHERE niveau = :niveau
                AND idPersonnage = :isPersonnage
                AND m.idStatistique = s.idStatistique';

        $niveauQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $niveauQuery->bindParam(':niveau',$niveau, PDO::PARAM_INT);
        $niveauQuery->bindParam(':idPersonnage',$idPersonnage, PDO::PARAM_INT);
        $niveauQuery->execute();

        // $niveauFetched = $niveauQuery->fetchAll(PDO::FETCH_ASSOC);

        $niveauFinal = ['niveau' => $niveau, 'idPersonnage' => $idPersonnage];
        while ($statistique = $niveauQuery->fetch(PDO::FETCH_ASSOC)) {
            $niveauFinal[$statistique['libelle']] = $statistique['valeur'];
        }

        return new Niveau($niveauFinal);
    }

    public function getAllNiveau($idPersonnage)
    {
        /* Une autre méthode serait de faire une première requête pour récupérer les niveaux disponibles.
         *
         * */

        $sql = 'SELECT m.idPersonnage, s.idStatistique, s.libelle, m.niveau, m.valeur
                FROM monte as m, statistique as s
                WHERE idPersonnage = :isPersonnage
                AND m.idStatistique = s.idStatistique
                ORDER BY niveau, s.idStatistique';
        $niveauQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $niveauQuery->bindParam(':idPersonnage',$idPersonnage, PDO::PARAM_INT);
        $niveauQuery->execute();

        $allNiveau = [];
        $niveauCourant = 1;
        $statistiquesNiveauCourant = ['niveau' => $niveauCourant, 'idPersonnage' => $idPersonnage];

        while($statistiqueFetched = $niveauQuery->fetch(PDO::FETCH_ASSOC)) {
            if ($statistiqueFetched['niveau'] != $niveauCourant) {
                array_push($allNiveau, new Niveau($statistiquesNiveauCourant));
                $niveauCourant = $statistiqueFetched['niveau'];
                $statistiquesNiveauCourant = [['niveau' => $niveauCourant, 'idPersonnage' => $idPersonnage]];
            }
            $statistiquesNiveauCourant[$statistiqueFetched['libelle']] = $statistiqueFetched['valeur'];
        };

        return $allNiveau;
    }

    public function addNiveau($niveauData)
    {
        $niveau = json_decode($niveauData);
        $sql = "INSERT INTO `niveau` (`idPersonnage`, `niveau`, `intelligence`, `forces`, `agilite`, `sagesse`, `constitution`,
                                        `vitalite`, `vitaliteNaturelle`, `mana`, `manaNaturel`) 
                                        VALUES (:idPersonnage, :niveau, :intelligence, :forces, :agilite, :sagesse, :constitution,
                                                :vitalite, :vitaliteNaturelle, :mana, :manaNaturel)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idPersonnage',$niveau->idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':niveau',$niveau->niveau, PDO::PARAM_INT);
        $commit->bindParam(':intelligence',$niveau->intelligence, PDO::PARAM_INT);
        $commit->bindParam(':forces',$niveau->forces, PDO::PARAM_INT);
        $commit->bindParam(':agilite',$niveau->agilite, PDO::PARAM_INT);
        $commit->bindParam(':sagesse',$niveau->sagesse, PDO::PARAM_INT);
        $commit->bindParam(':constitution',$niveau->constitution, PDO::PARAM_INT);
        $commit->bindParam(':vitalite',$niveau->vitalite, PDO::PARAM_INT);
        $commit->bindParam(':vitaliteNaturelle',$niveau->vitaliteNaturelle, PDO::PARAM_INT);
        $commit->bindParam(':mana',$niveau->mana, PDO::PARAM_INT);
        $commit->bindParam(':manaNaturel',$niveau->manaNaturel, PDO::PARAM_INT);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM niveau 
                    where idNiveau=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Niveau($fetchedResult);
    }

    public function updateNiveau($niveauData)
    {
        $niveau = json_decode($niveauData);
        $sql = "UPDATE niveau 
                SET idPersonnage = :idPersonnage, 
                niveau = :niveau, 
                intelligence = :intelligence, 
                forces = :forces, 
                agilite = :agilite, 
                sagesse = :sagesse, 
                constitution = :constitution, 
                vitalite = :vitalite, 
                vitaliteNaturelle = :vitaliteNaturelle, 
                mana = :mana, 
                manaNaturel = :manaNaturel 
                WHERE idNiveau = :idNiveau";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idPersonnage',$niveau->idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':niveau',$niveau->niveau, PDO::PARAM_INT);
        $commit->bindParam(':intelligence',$niveau->intelligence, PDO::PARAM_INT);
        $commit->bindParam(':forces',$niveau->forces, PDO::PARAM_INT);
        $commit->bindParam(':agilite',$niveau->agilite, PDO::PARAM_INT);
        $commit->bindParam(':sagesse',$niveau->sagesse, PDO::PARAM_INT);
        $commit->bindParam(':constitution',$niveau->constitution, PDO::PARAM_INT);
        $commit->bindParam(':vitalite',$niveau->vitalite, PDO::PARAM_INT);
        $commit->bindParam(':vitaliteNaturelle',$niveau->vitaliteNaturelle, PDO::PARAM_INT);
        $commit->bindParam(':mana',$niveau->mana, PDO::PARAM_INT);
        $commit->bindParam(':manaNaturel',$niveau->manaNaturel, PDO::PARAM_INT);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					FROM niveau
                    where idNiveau='.$niveau->idNiveau);
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Niveau($fetchedResult);
    }

    public function deleteNiveau(int $idPersonnage, int $niveau)
    {
        $sql = 'DELETE FROM monte WHERE idPersonnage = :idPersonnage AND niveau = :niveau';
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':niveau', $niveau, PDO::PARAM_INT);
        $commit->bindParam(':idPersonnage', $idPersonnage, PDO::PARAM_INT);
        $commit->execute();

        return $commit->rowCount();
    }

    public function insertInto(int $idPersonnage, string $libelle, int $niveau, int $valeur) {
        $sql = 'SELECT idStatistique
                FROM statistique
                WHERE libelle = :libelle';

        $idStatistiqueQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $idStatistiqueQuery->bindParam(':libelle', $libelle, PDO::PARAM_STR);
        $idStatistiqueQuery->execute();

        // $idStatistiqueQuery->debugDumpParams();

        $idStatistiqueFetched = $idStatistiqueQuery->fetch(PDO::FETCH_ASSOC);

        $sqlInsert = 'INSERT INTO `monte` (idPersonnage, idStatistique, niveau, valeur) 
                        VALUES (:idPersonnage, :idStatistique, :niveau, :valeur)';
        $commit = $this->_db->prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idPersonnage', $idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':idStatistique', $idStatistiqueFetched['idStatistique'], PDO::PARAM_INT);
        $commit->bindParam(':niveau', $niveau, PDO::PARAM_INT);
        $commit->bindParam(':valeur', $valeur, PDO::PARAM_INT);
        $commit->execute();

        // $commit->debugDumpParams();

        return $commit->fetch(PDO::FETCH_ASSOC);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}