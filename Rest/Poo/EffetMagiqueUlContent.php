<?php


class EffetMagiqueUlContent implements JsonSerializable
{
    public
        $_idEffetMagiqueUlContent,
        $_idEffetMagiqueUl,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueUlContent($idEffetMagiqueUlContent)
    {
        $idEffetMagiqueUlContent = (int) $idEffetMagiqueUlContent;

        if ($idEffetMagiqueUlContent > 0)
        {
            $this->_idEffetMagiqueUlContent = $idEffetMagiqueUlContent;
        }
    }

    public function setIdEffetMagiqueUl($idEffetMagiqueUl)
    {
        $idEffetMagiqueUl = (int) $idEffetMagiqueUl;

        if ($idEffetMagiqueUl > 0)
        {
            $this->_idEffetMagiqueUl = $idEffetMagiqueUl;
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
            'idEffetMagiqueUlContent' => $this->_idEffetMagiqueUlContent,
            'idEffetMagiqueUl' => $this->_idEffetMagiqueUl,
            'contenu' => $this->_contenu,
        ];
    }
}