<?php


class EffetMagiqueDescription implements JsonSerializable
{
    public
        $_idEffetMagiqueDescription,
        $_idEffetMagique,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueDescription($idEffetMagiqueDescription)
    {
        $idEffetMagiqueDescription = (int) $idEffetMagiqueDescription;

        if ($idEffetMagiqueDescription > 0)
        {
            $this->_idEffetMagiqueDescription = $idEffetMagiqueDescription;
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
    public function setContenu($contenu)
    {
        if (is_string($contenu)) {
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
            'idEffetMagiqueDescription' => $this->_idEffetMagiqueDescription,
            'idEffetMagique' => $this->_idEffetMagique,
            'contenu' => $this->_contenu,
        ];
    }
}