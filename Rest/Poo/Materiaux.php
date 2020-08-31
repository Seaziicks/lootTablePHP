<?php


class Materiaux
{
    public
        $_idMateriaux,
        $_nom,
        $_effet;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

	public function setIdMateriaux($idMateriaux)
    {
        $idMateriaux = (int) $idMateriaux;

        if ($idMateriaux > 0)
        {
            $this->_idMateriaux = $idMateriaux;
        }
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

	public function setEffet($effet)
    {
        if (is_string($effet))
        {
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

}