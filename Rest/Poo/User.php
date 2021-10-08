<?php


class User implements JsonSerializable
{
    public
        $_idUser,
        $_username,
        $_password,
        $_idPersonnage,
        $_isGameMaster,
        $_isAdmin;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function setIdUser($idUser)
    {
        $idUser = (int) $idUser;

        if ($idUser > 0)
        {
            $this->_idUser = $idUser;
        }
    }

    public function setUsername($username)
    {
        if (is_string($username))
        {
            $this->_username = $username;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password))
        {
            $this->_password = $password;
        }
    }

    public function setIdPersonnage($idPersonnage)
    {
        $idPersonnage = (int) $idPersonnage;

        if ($idPersonnage > 0)
        {
            $this->_idPersonnage = $idPersonnage;
        }
    }

    public function setIsGameMaster($isGameMaster)
    {
        $this->_isGameMaster = (bool)$isGameMaster;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->_isAdmin = (bool)$isAdmin;
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
            'idUser' => $this->_idUser,
            'username' => $this->_username,
            'password' => $this->_password,
            'idPersonnage' => $this->_idPersonnage,
            'isGameMaster' => (bool)$this->_isGameMaster,
            'isAdmin' => (bool)$this->_isAdmin,
        ];
    }
}