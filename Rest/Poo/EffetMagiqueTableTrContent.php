<?php


class EffetMagiqueTableTrContent implements JsonSerializable
{
    public
        $_idEffetMagiqueTableTrContent,
        $_idEffetMagiqueTableTr,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueTableTrContent($idEffetMagiqueTableTrContent)
    {
        $idEffetMagiqueTableTrContent = (int) $idEffetMagiqueTableTrContent;

        if ($idEffetMagiqueTableTrContent > 0)
        {
            $this->_idEffetMagiqueTableTrContent = $idEffetMagiqueTableTrContent;
        }
    }
    public function setIdEffetMagiqueTableTr($idEffetMagiqueTableTr)
    {
        $idEffetMagiqueTableTr = (int) $idEffetMagiqueTableTr;

        if ($idEffetMagiqueTableTr > 0)
        {
            $this->_idEffetMagiqueTableTr = $idEffetMagiqueTableTr;
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
            'idEffetMagiqueTableTrContent' => $this->_idEffetMagiqueTableTrContent,
            'idEffetMagiqueTableTr' => $this->_idEffetMagiqueTableTr,
            'contenu' => $this->_contenu,
        ];
    }
}