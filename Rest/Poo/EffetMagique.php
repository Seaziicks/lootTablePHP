<?php


class EffetMagique implements JsonSerializable
{
    public
        $_idEffetMagique,
        $_idObjet,
        $_title;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

	public function setIdEffetMagique($idEffetMagique)
    {
        $idEffetMagique = (int) $idEffetMagique;

        if ($idEffetMagique > 0)
        {
            $this->_idEffetMagique = $idEffetMagique;
        }
    }

	public function setIdObjet($ID_Objet)
    {
        $ID_Objet = (int) $ID_Objet;

        if ($ID_Objet > 0)
        {
            $this->_idObjet = $ID_Objet;
        }
    }

	public function setTitle($title)
    {
        if (is_string($title))
        {
            $this->_title = $title;
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
            'idEffetMagique' => $this->_idEffetMagique,
            'idObjet' => $this->_idObjet,
            'title' => $this->_title
        ];
    }

}