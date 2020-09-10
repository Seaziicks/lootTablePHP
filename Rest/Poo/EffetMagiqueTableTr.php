<?php


class EffetMagiqueTableTr implements JsonSerializable
{
    public
        $_idEffetMagiqueTableTr,
        $_idEffetMagiqueTable,
        $_trContents;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function setIdEffetMagiqueTableTr($idEffetMagiqueTableTr)
    {
        $idEffetMagiqueTableTr = (int) $idEffetMagiqueTableTr;

        if ($idEffetMagiqueTableTr > 0)
        {
            $this->_idEffetMagiqueTableTr = $idEffetMagiqueTableTr;
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

    public function updateTrContent(PDO $bdd)
    {
        $EffetMagiqueTableTrContentManager = new EffetMagiqueTableTrContentManager($bdd);
        $this->_trContents = $EffetMagiqueTableTrContentManager->getAllEffetMagiqueTableTrContent($this->_idEffetMagiqueTableTr);
    }

    public function jsonSerialize()
    {
        return [
            'idEffetMagiqueTableTr' => $this->_idEffetMagiqueTableTr,
            'idEffetMagiqueTable' => $this->_idEffetMagiqueTable,
            'effetMagiqueTableTrContent' => $this->_trContents,
        ];
    }
}