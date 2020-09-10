<?php


class EffetMagiqueUl implements JsonSerializable
{
    public
        $_idEffetMagiqueUl,
        $_idEffetMagique,
        $_position,
        $_lis;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
	public function setIdEffetMagiqueUl($idEffetMagiqueUl)
    {
        $idEffetMagiqueUl = (int) $idEffetMagiqueUl;

        if ($idEffetMagiqueUl > 0)
        {
            $this->_idEffetMagiqueUl = $idEffetMagiqueUl;
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

    public function setLis()
    {

    }

    public function updateLis(PDO $bdd) {
        /* Récupération des lignes de la table */


            /* Récupération des lignes de la table */
            $effetMagiqueUlContentsQuery = $bdd->query('SELECT *
					from effetmagiqueulcontent
                    where idEffetMagiqueUl='.$this->_idEffetMagiqueUl);

            $li= [];
            while ($effetMagiqueUlContent = $effetMagiqueUlContentsQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($li, $effetMagiqueUlContent['contenu']);
            }
            $this->_lis = $li;
    }

    public function updateLisBis(PDO $bdd) {
        /* Récupération des lignes de la table */

        $EffetMagiqueUlContentManager = new EffetMagiqueUlContentManager($bdd);
        /* Récupération des lignes de la table */

        $this->_lis = $EffetMagiqueUlContentManager->getAllEffetMagiqueUlContent($this->_idEffetMagiqueUl);
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
            'idEffetMagiqueUl' => $this->_idEffetMagiqueUl,
            'idEffetMagique' => $this->_idEffetMagique,
            'position' => $this->_position,
            'effetMagiqueUlContent' => $this->_lis
        ];
    }

}