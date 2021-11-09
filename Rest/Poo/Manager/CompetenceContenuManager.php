<?php


class CompetenceContenuManager
{
    /* @var $_db PDO */
    private $_db; // Instance de PDO

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function getCompetenceContenu($idCompetenceContenu) {
        $sql = 'SELECT *
                FROM competencecontenu
                WHERE idCompetenceContenu = :idCompetenceContenu';

        $competenceContenuQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $competenceContenuQuery->bindParam(':idCompetenceContenu', $idCompetenceContenu, PDO::PARAM_INT);
        $competenceContenuQuery->execute();

        $competenceContenuFetched = $competenceContenuQuery->fetch(PDO::FETCH_ASSOC);

        return new CompetenceContenu($competenceContenuFetched);
    }

    public function getCompetencesContenusForCompetence($idCompetence)
    {
        $sql = 'SELECT * 
                FROM competencecontenu 
                WHERE idCompetence = :idCompetence
                ORDER BY niveauCompetenceRequis';

        $contenuQuery = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $contenuQuery->bindParam('idCompetence', $idCompetence, PDO::PARAM_INT);
        $contenuQuery->execute();

        $contenus = [];
        while ($contenuFetched = $contenuQuery->fetch(PDO::FETCH_ASSOC)) {
            array_push($contenus, new CompetenceContenu($contenuFetched));
        }

        return $contenus;
    }

    function updateCompetenceContenu($competenceContenu) {
        $sql = "UPDATE competencecontenu 
                SET idCompetence = :idCompetence, niveauCompetenceRequis = :niveauCompetenceRequis, contenu = :contenu
                WHERE idCompetenceContenu = :idCompetenceContenu;";

        $test = 'Projette un jet de lave qui inflige 1D4 de dégâts + bonusIntelligence.';
        // print_r($competenceContenu->contenu);
        $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $commit->bindParam(':idCompetence', $competenceContenu->idCompetence, PDO::PARAM_INT);
        $commit->bindParam(':niveauCompetenceRequis', $competenceContenu->niveauCompetenceRequis, PDO::PARAM_INT);
        $commit->bindParam(':contenu', $competenceContenu->contenu, PDO::PARAM_STR);
        $commit->bindParam(':idCompetenceContenu', $competenceContenu->idCompetenceContenu, PDO::PARAM_INT);
        $commit->execute();

        // $commit->debugDumpParams();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}