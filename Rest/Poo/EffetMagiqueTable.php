<?php


class EffetMagiqueTable implements JsonSerializable
{
    public
        $_idEffetMagiqueTable,
        $_idEffetMagique,
        $_position,
        $_titles,
        $_trs;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
	public function setIdEffetMagiqueTable($idEffetMagiqueTable)
    {
        $idEffetMagiqueTable = (int) $idEffetMagiqueTable;

        if ($idEffetMagiqueTable > 0)
        {
            $this->_idEffetMagiqueTable = $idEffetMagiqueTable;
        }
    }
	public function setIdEffetMagique($idEffetMagique)
    {
        $idEffetMagique = (int) $idEffetMagique;

        if ($idEffetMagique > 0)
        {
            $this->_idEffetMagique = $idEffetMagique;
        }
    }
	public function setPosition($position)
    {
        $position = (int) $position;

        if ($position > 0)
        {
            $this->_position = $position;
        }
    }

    public function setTitles()
    {

    }

    public function updateTitles(PDO $bdd) {
        /* Récupération des titres de la table */
        $effetMagiqueTableTitlesQuery = $bdd->query('SELECT *
					from effetmagiquetabletitle 
                    where idEffetMagiqueTable='.$this->_idEffetMagiqueTable);

        $titles= [];
        while ($effetMagiqueTableTitle = $effetMagiqueTableTitlesQuery->fetch(PDO::FETCH_ASSOC)) {

            $effetMagiqueTableTitleContensQuery = $bdd->query('SELECT *
					from effetmagiquetabletitlecontent 
                    where idEffetMagiqueTableTitle='.$effetMagiqueTableTitle['idEffetMagiqueTableTitle']);

            $title= [];
            while ($effetMagiqueTableTitleContent = $effetMagiqueTableTitleContensQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($title, $effetMagiqueTableTitleContent['contenu']);
            }
            array_push($titles, $title);
        }
        $this->_titles = $titles;
    }

    public function setTrs()
    {

    }

    public function updateTrs(PDO $bdd) {
        /* Récupération des lignes de la table */
        $effetMagiqueTableTrsQuery = $bdd->query('SELECT *
					from effetmagiquetabletr
                    where idEffetMagiqueTable='.$this->_idEffetMagiqueTable);

        $trs= [];
        while ($effetMagiqueTableTr = $effetMagiqueTableTrsQuery->fetch(PDO::FETCH_ASSOC)) {

            $effetMagiqueTableTrContensQuery = $bdd->query('SELECT *
					from effetmagiquetabletrcontent 
                    where idEffetMagiqueTableTr='.$effetMagiqueTableTr['idEffetMagiqueTableTr']);

            $tr= [];
            while ($effetMagiqueTableTrContent = $effetMagiqueTableTrContensQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($tr, $effetMagiqueTableTrContent['contenu']);
            }
            array_push($trs, $tr);
        }
        $this->_trs = $trs;
    }

	public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    public function jsonSerialize()
    {
        return [
            'position' => $this->_position,
            'title' => $this->_titles,
            'tr' => $this->_trs
        ];
    }
}