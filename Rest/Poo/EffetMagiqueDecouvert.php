<?php


class EffetMagiqueDecouvert implements JsonSerializable
{
    public
        $_idEffetMagiqueDecouvert,
        $_idPersonnage,
        $_idObjet,
        $_effet;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function setIdEffetMagiqueDecouvert($idEffetMagiqueDecouvert)
    {
        $idEffetMagiqueDecouvert = (int) $idEffetMagiqueDecouvert;

        if ($idEffetMagiqueDecouvert > 0)
        {
            $this->_idEffetMagiqueDecouvert = $idEffetMagiqueDecouvert;
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

    public function setIdObjet($idObjet)
    {
        $idObjet = (int) $idObjet;

        if ($idObjet > 0)
        {
            $this->_idObjet = $idObjet;
        }
    }

    public function setEffet($effet)
    {
        if (is_string($effet)) {
            $this->_effet = $effet;
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
            'idEffetMagiqueDecouvert' => $this->_idEffetMagiqueDecouvert,
            'idPersonnage' => $this->_idPersonnage,
            'idObjet' => $this->_idObjet,
            'effet' => $this->_effet,
        ];
    }
}