<?php


class Niveau
{
    public
        $_idNiveau,
        $_idPersonnage,
        $_niveau,
        $_intelligence = 0,
        $_force = 0,
        $_agilite = 0,
        $_sagesse = 0,
        $_constitution = 0,
        $_vitalite = 0,
        $_deVitalite = 0,
        $_vitaliteNaturelle = 0,
        $_mana = 0,
        $_deMana = 0,
        $_manaNaturel = 0;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function setIdNiveau($idNiveau)
    {
        $idNiveau = (int) $idNiveau;

        if ($idNiveau > 0)
        {
            $this->_idNiveau = $idNiveau;
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

    public function settitle($title)
    {
        if (is_string($title))
        {
            $this->_title = $title;
        }
    }

    public function setNiveau($niveau)
    {
        $this->_niveau = (int)$niveau;
    }

    public function setIntelligence($intelligence)
    {
        $this->_intelligence = (int)$intelligence;
    }

    public function setForce($force)
    {
        $this->_force = (int)$force;
    }

    public function setAgilite($agilite)
    {
        $this->_agilite = (int)$agilite;
    }

    public function setSagesse($sagesse)
    {
        $this->_sagesse = (int)$sagesse;
    }

    public function setConstitution($constitution)
    {
        $this->_constitution = (int)$constitution;
    }

    public function setVitalite($vitalite)
    {
        $this->_vitalite = (int)$vitalite;
    }

    public function setDeVitalite($deVitalite)
    {
        $this->_deVitalite = (int)$deVitalite;
    }

    public function setVitaliteNaturelle($_vitaliteNaturelle)
    {
        $this->_vitaliteNaturelle = (int)$_vitaliteNaturelle;
    }

    public function setMana($mana)
    {
        $this->_mana = (int)$mana;
    }

    public function setDeMana($deMana)
    {
        $this->_deMana = (int)$deMana;
    }

    public function setManaNaturel($manaNaturel)
    {
        $this->_manaNaturel = (int)$manaNaturel;
    }

    public function getNbStatistique() {
        return $this->_mana + $this->_vitalite + $this->_constitution + $this->_sagesse + $this->_intelligence +
            $this->_agilite + $this->_force;
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
            'idNiveau' => $this->_idNiveau,
            'idPersonnage' => $this->_idPersonnage,
            'niveau' => $this->_niveau,
            'intelligence' => $this->_intelligence,
            'force' => $this->_force,
            'agilite' => $this->_agilite,
            'sagesse' => $this->_sagesse,
            'constitution' => $this->_constitution,
            'vitalite' => $this->_vitalite,
            'deVitalite' => $this->_deVitalite,
            'vitaliteNaturelle' => $this->_vitaliteNaturelle,
            'mana' => $this->_mana,
            'deMana' => $this->_deMana,
            'manaNaturel' => $this->_manaNaturel,
        ];
    }
}