<?php


class Competence implements JsonSerializable
{
    public
        $_idCompetence,
        $_idPersonnage,
        $_idCompetenceParente,
        $_titre,
        $_niveau,
        $_icone,
        $_contenu,
        $_etat,
        $_optionnelle,
        $_children;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function setIdCompetence($idCompetence)
    {
        $idCompetence = (int) $idCompetence;

        if ($idCompetence > 0)
        {
            $this->_idCompetence = $idCompetence;
        }
    }

    public function setIdPersonnage($idPersonnage)
    {
        $idPersonnage = (int) $idPersonnage;

        if ($idPersonnage > 0)
        {
            $this->_idPersonnage = $idPersonnage;
        }
    }

    public function setIdCompetenceParente($idCompetenceParente)
    {
        if ($idCompetenceParente && (int) $idCompetenceParente > 0)
        {
            $this->_idCompetenceParente = $idCompetenceParente;
        } else {
            $this->_idCompetenceParente = null;
        }
    }

    public function setTitre($titre)
    {
        if (is_string($titre))
        {
            $this->_titre = $titre;
        }
    }

    public function setNiveau($niveau)
    {
        $niveau = (int) $niveau;

        if ($niveau > 0)
        {
            $this->_niveau = $niveau;
        }
    }

    public function setIcone($icone)
    {
        if (is_string($icone))
        {
            $this->_icone = $icone;
        }
    }

    public function setContenu($contenu)
    {
        if (is_string($contenu))
        {
            $this->_contenu = $contenu;
        }
    }

    public function setEtat($etat)
    {
        if (is_string($etat))
        {
            $this->_etat = $etat;
        }
        $this->_etat = $this->_niveau > 0 ? 'selected' : 'locked';
    }

    public function setOptionnelle($optionnelle)
    {
        $this->_optionnelle = (bool)$optionnelle;
    }

    public function setChildren($children)
    {
        $this->_children = $children;
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
            'idCompetence' => $this->_idCompetence,
            'idPersonnage' => $this->_idPersonnage,
            'idCompetenceParente' => $this->_idCompetenceParente,
            'titre' => $this->_titre,
            'niveau' => $this->_niveau,
            'icone' => $this->_icone,
            'contenu' => $this->_contenu,
            'etat' => $this->_etat,
            'optionnelle' => $this->_optionnelle,
            'children' => $this->_children
        ];
    }

}