<?php


class CompetenceManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    function getCompetence($idCompetence) {
        $sql = 'SELECT *
                FROM competence
                WHERE idCompetence = :idCompetence';

        $competencesQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $competencesQuery->bindParam(':idCompetence',$idCompetence, PDO::PARAM_INT);
        $competencesQuery->execute();

        $competenceFetched = $competencesQuery->fetch(PDO::FETCH_ASSOC);
        $competence = new Competence($competenceFetched);
        $competence->_children = [];
        $this->setCompetenceContenu($competence);

        return $competence;
    }

    public function getCompetencesForPersonnage($idPersonnage): array
    {
        $sql = 'SELECT *
                FROM competence
                WHERE idPersonnage = :idPersonnage
                ORDER BY idCompetenceParente';

        $competencesQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $competencesQuery->bindParam(':idPersonnage',$_GET['idPersonnage'], PDO::PARAM_INT);
        $competencesQuery->execute();

        $competencesPersonnage = [];
        while ($competenceFetched = $competencesQuery->fetch(PDO::FETCH_ASSOC)) {
            $competence = new Competence($competenceFetched);
            $competence->_children = [];
            $this->setCompetenceContenu($competence);
            array_push($competencesPersonnage, $competence);
        }


        $preparedData = [];
        for ($i = 0 ; $i < count($competencesPersonnage); $i++) {
            if (!($competencesPersonnage[$i]->_idCompetenceParente)) {
                array_push($preparedData, $competencesPersonnage[$i]);
                unset($competencesPersonnage[array_search($competencesPersonnage[$i], $competencesPersonnage, true)]);
            }
        }

        /**
         * Permet de remettre les indexes à partir de 0.
         * Car le unset() enlève du tableau mais ne réarrange pas les indexes, et donc ça pose problème fans les boucles.
         */
        $competencesPersonnage = array_merge($competencesPersonnage);
        // print_r($competencesPersonnage);
        // print_r($preparedData);

        for ($i = 0 ; $i < count($competencesPersonnage); $i++) {
            for ($j = 0 ; $j < count($preparedData); $j++) {
                $this->insertChildren($preparedData[$j], $competencesPersonnage[$i]);
            }
        }

        return $preparedData;
    }

    function updateCompetence($competence)
    {
        $competence = json_decode($competence)->Competence;
        $sql = "UPDATE competence 
                SET idPersonnage = :idPersonnage, idCompetenceParente = :idCompetenceParente, titre = :titre, niveau = :niveau,
                icone = :icone, etat = :etat, optionnelle = :optionnelle
                WHERE idCompetence = :idCompetence;";

        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idCompetence', $competence->idCompetence, PDO::PARAM_INT);
        $commit->bindParam(':idPersonnage', $competence->idPersonnage, PDO::PARAM_INT);
        $commit->bindParam(':idCompetenceParente', $competence->idCompetenceParente, PDO::PARAM_INT);
        $commit->bindParam(':titre', $competence->titre, PDO::PARAM_STR);
        $commit->bindParam(':niveau', $competence->niveau, PDO::PARAM_INT);
        $commit->bindParam(':icone', $competence->icone, PDO::PARAM_STR);
        $commit->bindParam(':etat', $competence->etat, PDO::PARAM_STR);
        $commit->bindParam(':optionnelle', $competence->optionnelle, PDO::PARAM_BOOL);
        $commit->execute();

        // $commit->debugDumpParams();

        $CompetenceContenuManager = new CompetenceContenuManager($this->_db);
        foreach ($competence->contenu as $contenu) {
            $CompetenceContenuManager->updateCompetenceContenu($contenu);
        }
    }

    /**
     * Fonction recursive qui permet d'inserer les enfants dans les parents.
     * Se base sur le fait que les competences sont recuperee par idCompetenceParente par ordre croissant.
     * Ne marche pas correctement si non trie de cette maniere la, je pense. C'est donc un peu vicié.
     * @param Competence $parent    La competence dans laquelle rajouter
     * @param Competence $competence    La competence a rajouter
     */
    function insertChildren(Competence $parent, Competence $competence) {

        if ($parent->_idCompetence == $competence->_idCompetenceParente) {
            array_push($parent->_children, $competence);
        } else {
            for ($i = 0 ; $i < count($parent->_children) ; $i++) {
                $this->insertChildren($parent->_children[$i], $competence);
            }
        }
    }

    function setCompetenceContenu(Competence $competence)
    {
        $CompetenceContenuManager = new CompetenceContenuManager($this->_db);
        $competence->_contenu = $CompetenceContenuManager->getCompetencesContenusForCompetence($competence->_idCompetence);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}