<?php


class CompetenceContenu implements JsonSerializable
{
    public
        $_idCompetenceContenu,
        $_idCompetence,
        $_niveauCompetenceRequis,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function setIdCompetenceContenu($idCompetenceContenu)
    {
        $idCompetenceContenu = (int) $idCompetenceContenu;

        if ($idCompetenceContenu > 0)
        {
            $this->_idCompetenceContenu = $idCompetenceContenu;
        }
    }

    public function setIdCompetence($idCompetence)
    {
        $idCompetence = (int) $idCompetence;

        if ($idCompetence > 0)
        {
            $this->_idCompetence = $idCompetence;
        }
    }

    public function setNiveauCompetenceRequis($niveauCompetenceRequis)
    {
        if ($niveauCompetenceRequis && (int) $niveauCompetenceRequis > 0)
        {
            $this->_niveauCompetenceRequis = $niveauCompetenceRequis;
        } else {
            $this->_niveauCompetenceRequis = null;
        }
    }

    public function setContenu($contenu)
    {
        if (is_string($contenu))
        {
            $this->_contenu = $contenu;
        }
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
            'idCompetenceContenu' => $this->_idCompetenceContenu,
            'idCompetence' => $this->_idCompetence,
            'niveauCompetenceRequis' => $this->_niveauCompetenceRequis,
            'contenu' => $this->_contenu
        ];
    }

}