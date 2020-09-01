<?php


class ObjetManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getObjet($idObjet)
    {
        $idObjet = (int)$idObjet;
        $objetQuery = $this->_db->query('SELECT *
                                                    FROM objet
                                                    WHERE idObjet = ' . $idObjet);

        $objetFetched = $objetQuery->fetch(PDO::FETCH_ASSOC);

        return new Objet($objetFetched);
    }

    public function getAllObjet()
    {
        $objetQuery = $this->_db->query('SELECT *
                                                    FROM objet');

        $allObjet = [];
        while($objetFetched = $objetQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($allObjet, new Objet($objetFetched));
        };

        return $allObjet;
    }

    public function addObjet($objetData)
    {
        $objet = json_decode($objetData);

        $sql = "INSERT INTO `objet` (`idPersonnage`,`nom`,`bonus`,`type`,`prix`,`prixNonHumanoide`,`devise`,`idMalediction`,`categorie`,`idMateriaux`,
                                        `taille`,`degats`,`critique`,`facteurPortee`,`armure`,`bonusDexteriteMax`,`malusArmureTests`,`risqueEchecSorts`) 
                                        VALUES (:idPersonnage, :nom, :bonus, :type, :prix, :prixNonHumanoide, :devise, :idMalediction, :categorie, :idMateriaux,
                                                :taille, :degats, :critique, :facteurPortee, :armure, :bonusDexteriteMax, :malusArmureTests, :risqueEchecSorts)";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idPersonnage',$objet->idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':nom',$objet->nom, PDO::PARAM_STR);
        $commit->bindParam(':bonus',$objet->bonus, PDO::PARAM_INT);
        $commit->bindParam(':type',$objet->type, PDO::PARAM_STR);
        $commit->bindParam(':prix',$objet->prix, PDO::PARAM_INT);
        $commit->bindParam(':prixNonHumanoide',$objet->prixNonHumanoide, PDO::PARAM_INT);
        $commit->bindParam(':devise',$objet->devise, PDO::PARAM_STR);
        $commit->bindParam(':idMalediction',$objet->idMalediction, PDO::PARAM_INT);
        $commit->bindParam(':categorie',$objet->categorie, PDO::PARAM_STR);
        $commit->bindParam(':idMateriaux',$objet->idMateriaux, PDO::PARAM_INT);
        $commit->bindParam(':taille',$objet->taille, PDO::PARAM_STR);
        $commit->bindParam(':degats',$objet->degats, PDO::PARAM_STR);
        $commit->bindParam(':critique',$objet->critique, PDO::PARAM_STR);
        $commit->bindParam(':facteurPortee',$objet->facteurPortee, PDO::PARAM_STR);
        $commit->bindParam(':armure',$objet->armure, PDO::PARAM_INT);
        $commit->bindParam(':bonusDexteriteMax',$objet->bonusDexteriteMax, PDO::PARAM_INT);
        $commit->bindParam(':malusArmureTests',$objet->malusArmureTests, PDO::PARAM_INT);
        $commit->bindParam(':risqueEchecSorts',$objet->risqueEchecSorts, PDO::PARAM_STR);
        $commit->execute();
        $result = $this->_db->query('SELECT *
					from objet 
                    where idObjet=' . $this->_db->lastInsertId() . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Objet($fetchedResult);
    }

    public function updateObjet($objetData)
    {
        $objet = json_decode($objetData);
        $sql = "UPDATE objet 
                SET nom = :nom, bonus = :bonus, type = :type, prix = :prix,
                prixNonHumanoide = :prixNonHumanoide, devise = :devise, idMalediction = :idMalediction, categorie = :categorie,
                idMateriaux = :idMateriaux, taille = :taille, degats = :degats, critique = :critique, facteurPortee = :facteurPortee,
                armure = :armure, bonusDexteriteMax = :bonusDexteriteMax, malusArmureTests = :malusArmureTests, risqueEchecSorts = :risqueEchecSorts
                WHERE idObjet = :idObjet;";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idObjet',$objet->idObjet, PDO::PARAM_INT);
        $commit->bindParam(':nom',$objet->nom, PDO::PARAM_STR);
        $commit->bindParam(':bonus',$objet->bonus, PDO::PARAM_INT);
        $commit->bindParam(':type',$objet->type, PDO::PARAM_STR);
        $commit->bindParam(':effetMagique',$objet->effetMagique, PDO::PARAM_INT);
        $commit->bindParam(':prix',$objet->prix, PDO::PARAM_INT);
        $commit->bindParam(':prixNonHumanoide',$objet->prixNonHumanoide, PDO::PARAM_INT);
        $commit->bindParam(':devise',$objet->devise, PDO::PARAM_INT);
        $commit->bindParam(':idMalediction',$objet->idMalediction, PDO::PARAM_INT);
        $commit->bindParam(':categorie',$objet->categorie, PDO::PARAM_STR);
        $commit->bindParam(':idMateriaux',$objet->idMateriaux, PDO::PARAM_INT);
        $commit->bindParam(':taille',$objet->taille, PDO::PARAM_STR);
        $commit->bindParam(':degats',$objet->degats, PDO::PARAM_INT);
        $commit->bindParam(':critique',$objet->critique, PDO::PARAM_STR);
        $commit->bindParam(':facteurPortee',$objet->facteurPortee, PDO::PARAM_STR);
        $commit->bindParam(':armure',$objet->armure, PDO::PARAM_INT);
        $commit->bindParam(':bonusDexteriteMax',$objet->bonusDexteriteMax, PDO::PARAM_INT);
        $commit->bindParam(':malusArmureTests',$objet->malusArmureTests, PDO::PARAM_INT);
        $commit->bindParam(':risqueEchecSorts',$objet->risqueEchecSorts, PDO::PARAM_STR);
        $commit->execute();

        $result = $this->_db->query('SELECT *
					from objet
                    where idObjet=' . $objet->idObjet . '
                    ');
        $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        $bdd = null;

        return new Objet($fetchedResult);
    }

    public function deleteObjet($idObjet)
    {
        $this->_db->exec('DELETE FROM objet WHERE idObjet = ' . $idObjet);
    }

    public function getObjetAsNonJSon($idObjet) {
        $unmodifiedObjet = $this->getObjet($idObjet);
        $Objet = json_decode(json_encode($unmodifiedObjet));




        $EffetMagiqueManager = new EffetMagiqueManager($this->_db);
        $Objet->proprieteMagique = $EffetMagiqueManager->getAllEffetMagiqueTableAsNotJSon($idObjet);

        if (isset($Objet->idMalediction)) {
            unset($Objet->idMateriaux);
            $MaledictionManager = new Maledictionmanager($this->_db);
            $Objet->malediction = $MaledictionManager->getMaledictionAsNonJSon($unmodifiedObjet->_idMalediction);
        }
        if (isset($Objet->idMateriaux)) {
            unset($Objet->idMalediction);
            $MateriauxManager = new MateriauxManager($this->_db);
            $Objet->materiau = $MateriauxManager->getMateriauxAsNonJSon($unmodifiedObjet->_idMateriaux);
        }

        return $Objet;
    }

    public function addCompleteObjet($objetData) {
        $objet = json_decode($objetData)->Objet;
        $objetData = clone $objet;
        unset($objetData->proprieteMagique);
        unset($objetData->malediction);
        unset($objetData->materiau);
        if (isset($objet->malediction)) {
            $MaledictionManager = new MaledictionManager($this->_db);
            $malediction = $MaledictionManager->addMalediction(json_encode($objet->malediction));
            $objetData->idMalediction = $malediction->_idMalediction;
        } else
            $objetData->idMalediction = null;

        if (isset($objet->materiau)) {
            $MateriauxManager = new MateriauxManager($this->_db);
            $materiaux = $MateriauxManager->addMateriaux(json_encode($objet->materiau));
            $objetData->idMateriaux = $materiaux->_idMateriaux;
        } else
            $objetData->idMateriaux = null;


        $createdObjet = $this->addObjet(json_encode($objetData));

        if (isset($objet->proprieteMagique)) {
            $EffetMagiqueManager = new EffetMagiqueManager($this->_db);

            foreach ($objet->proprieteMagique as $propriete) {
                $EffetMagiqueManager->addCompleteEffetMagique($propriete, $createdObjet->_idObjet);
            }
        }

        return $this->getObjetAsNonJSon($createdObjet->_idObjet);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}