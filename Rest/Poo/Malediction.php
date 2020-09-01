<?php


class Malediction implements JsonSerializable
{
    public
        $_idMalediction,
        $_nom,
        $_description;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

	public function setIdMalediction($idMalediction)
    {
        $idMalediction = (int) $idMalediction;

        if ($idMalediction > 0)
        {
            $this->_idMalediction = $idMalediction;
        }
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

	public function setDescription($description)
    {
        if (is_string($description))
        {
            $this->_description = $description;
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
            'idMalediction' => $this->_idMalediction,
            'nom' => $this->_nom,
            'description' => $this->_description
        ];
    }
}