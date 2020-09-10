<?php


class EffetMagiqueTableTitle implements JsonSerializable
{
    public
        $_idEffetMagiqueTableTitle,
        $_idEffetMagiqueTable,
        $_titleContents;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueTableTitle($idEffetMagiqueTableTitle)
    {
        $idEffetMagiqueTableTitle = (int) $idEffetMagiqueTableTitle;

        if ($idEffetMagiqueTableTitle > 0)
        {
            $this->_idEffetMagiqueTableTitle = $idEffetMagiqueTableTitle;
        }
    }
    public function setIdEffetMagiqueTable($idEffetMagiqueTable)
    {
        $idEffetMagiqueTable = (int) $idEffetMagiqueTable;

        if ($idEffetMagiqueTable > 0)
        {
            $this->_idEffetMagiqueTable = $idEffetMagiqueTable;
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

    public function updateTitleContent(PDO $bdd)
    {
        $EffetMagiqueTableTitleContentManager = new EffetMagiqueTableTitleContentManager($bdd);
        $this->_titleContents = $EffetMagiqueTableTitleContentManager->getAllEffetMagiqueTableTitleContent($this->_idEffetMagiqueTableTitle);
    }

    public function jsonSerialize()
    {
        return [
            'idEffetMagiqueTableTitle' => $this->_idEffetMagiqueTableTitle,
            'idEffetMagiqueTable' => $this->_idEffetMagiqueTable,
            'effetMagiqueTableTitleContent' => $this->_titleContents,
        ];
    }
}