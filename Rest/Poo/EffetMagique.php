<?php


class EffetMagique
{
    public
        $_idEffetMagique,
        $_Objet,
        $_nom;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

	public function setIdEffetMagique($idEffetMagique)
    {
        $idEffetMagique = (int) $idEffetMagique;

        if ($idEffetMagique > 0)
        {
            $this->_idEffetMagique = $idEffetMagique;
        }
    }

	public function setObjet($ID_Objet)
    {
        $ID_Objet = (int) $ID_Objet;

        if ($ID_Objet > 0)
        {
            include('BDD.php');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

            $manager = new ObjetManager($bdd);

            $equipement = $manager->getObjet($ID_Objet);
            $this->_Objet = $equipement;
        }
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
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