<?php


class EffetMagiqueInfos implements JsonSerializable
{
    public
        $_idEffetMagiqueInfos,
        $_idEffetMagique,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueInfos($idEffetMagiqueInfos)
    {
        $idEffetMagiqueInfos = (int) $idEffetMagiqueInfos;

        if ($idEffetMagiqueInfos > 0)
        {
            $this->_idEffetMagiqueInfos = $idEffetMagiqueInfos;
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
            'idEffetMagiqueInfos' => $this->_idEffetMagiqueInfos,
            'idEffetMagique' => $this->_idEffetMagique,
            'contenu' => $this->_contenu,
        ];
    }
}