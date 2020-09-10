<?php


class EffetMagiqueTableTitleContent implements JsonSerializable
{
    public
        $_idEffetMagiqueTableTitleContent,
        $_idEffetMagiqueTableTitle,
        $_contenu;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueTableTitleContent($idEffetMagiqueTableTitleContent)
    {
        $idEffetMagiqueTableTitleContent = (int) $idEffetMagiqueTableTitleContent;

        if ($idEffetMagiqueTableTitleContent > 0)
        {
            $this->_idEffetMagiqueTableTitleContent = $idEffetMagiqueTableTitleContent;
        }
    }
    public function setIdEffetMagiqueTableTitle($idEffetMagiqueTableTitle)
    {
        $idEffetMagiqueTableTitle = (int) $idEffetMagiqueTableTitle;

        if ($idEffetMagiqueTableTitle > 0)
        {
            $this->_idEffetMagiqueTableTitle = $idEffetMagiqueTableTitle;
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
            'idEffetMagiqueTableTitleContent' => $this->_idEffetMagiqueTableTitleContent,
            'idEffetMagiqueTableTitle' => $this->_idEffetMagiqueTableTitle,
            'contenu' => $this->_contenu,
        ];
    }
}