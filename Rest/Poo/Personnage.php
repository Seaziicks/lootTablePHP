<?php


class Personnage implements JsonSerializable
{
    public
        $_idPersonnage,
        $_nom,
        $_niveau,
        $_intelligence = 0,
        $_force = 0,
        $_agilite = 0,
        $_sagesse = 0,
        $_constitution = 0,
        $_vitalite = 0,
        $_mana = 0;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
	public function setIdPersonnage($idPersonnage)
    {
        $idPersonnage = (int) $idPersonnage;
        $this->_idPersonnage = $idPersonnage;
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
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

    public function setMana($mana)
    {
        $this->_mana = (int)$mana;
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
            'idPersonnage' => $this->_idPersonnage,
            'nom' => $this->_nom,
            'niveau' => $this->_niveau,
            'intelligence' => $this->_intelligence,
            'force' => $this->_force,
            'agilite' => $this->_agilite,
            'sagesse' => $this->_sagesse,
            'constitution' => $this->_constitution,
            'vitalite' => $this->_vitalite,
            'mana' => $this->_mana
        ];
    }

}