<?php


class Objet
{
    public
        $_idObjet,
        $_Personnage,
        $_nom,
        $_bonus,
        $_type,
        $_prix,
        $_prixNonHumanoide,
        $_devise,
        $_idMalediction,
        $_categorie,
        $_idMateriaux,
        $_taille,
        $_degats,
        $_critique,
        $_facteurPortee,
        $_armure,
        $_bonusDexteriteMax,
        $_malusArmureTests,
        $_risqueEchecSorts;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
	public function setIdObjet($idObjet)
    {
        $idObjet = (int) $idObjet;

        if ($idObjet > 0)
        {
            $this->_idObjet = $idObjet;
        }
    }

	public function setPersonnage($Personnage)
    {
        $Personnage = (int) $Personnage;

        if ($Personnage > 0)
        {
            include('BDD.php');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

            $manager = new PersonnageManager($bdd);

            $equipement = $manager->get($Personnage);
            $this->_Personnage = $equipement;
        }
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }
	public function setBonus($bonus)
    {
        $this->_bonus = (int)$bonus;
    }

	public function setType($type)
    {
        if (is_string($type))
        {
            $this->_type = $type;
        }
    }
	public function setPrix($prix)
    {
        $prix = (float) $prix;

        if ($prix > 0)
        {
            $this->_prix = $prix;
        }
    }
	public function setPrixNonHumanoide($prixNonHumanoide)
    {
        $prixNonHumanoide = (float) $prixNonHumanoide;

        if ($prixNonHumanoide > 0)
        {
            $this->_prixNonHumanoide = $prixNonHumanoide;
        }
    }

	public function setDevise($devise)
    {
        if (is_string($devise))
        {
            $this->_devise = $devise;
        }
    }

	public function setIdMalediction($idMalediction)
    {
        $idMalediction = (int) $idMalediction;

        if ($idMalediction > 0)
        {
            include('BDD.php');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

            $manager = new MaledictionManager($bdd);

            $equipement = $manager->get($idMalediction);
            $this->_idMalediction = $equipement;
        }
    }

	public function setCategorie($categorie)
    {
        if (is_string($categorie))
        {
            $this->_categorie = $categorie;
        }
    }

	public function setIdMateriaux($idMateriaux)
    {
        $idMateriaux = (int) $idMateriaux;

        if ($idMateriaux > 0)
        {
            include('BDD.php');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

            $manager = new MateriauxManager($bdd);

            $equipement = $manager->get($idMateriaux);
            $this->_idMateriaux = $equipement;
        }
    }

	public function setTaille($taille)
    {
        if (is_string($taille))
        {
            $this->_taille = $taille;
        }
    }

	public function setDegats($degats)
    {
        if (is_string($degats))
        {
            $this->_degats = $degats;
        }
    }

	public function setCritique($critique)
    {
        if (is_string($critique))
        {
            $this->_critique = $critique;
        }
    }

	public function setFacteurPortee($facteurPortee)
    {
        if (is_string($facteurPortee))
        {
            $this->_facteurPortee = $facteurPortee;
        }
    }
	public function setArmure($armure)
    {
        $this->_armure = (int)$armure;
    }
	public function setBonusDexteriteMax($bonusDexteriteMax)
    {
        $this->_bonusDexteriteMax = (int)$bonusDexteriteMax;
    }
	public function setMalusArmureTests($malusArmureTests)
    {
        $this->_malusArmureTests = (int)$malusArmureTests;
    }

	public function setRisqueEchecSorts($risqueEchecSorts)
    {
        if (is_string($risqueEchecSorts))
        {
            $this->_risqueEchecSorts = $risqueEchecSorts;
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

/*
    $reponse['idObjet'] = 0;
    $reponse['Personnage'] = 0;
    $reponse['nom'] = 0;
    $reponse['bonus'] = 0;
    $reponse['type'] = 0;
    $reponse['prix'] = 0;
    $reponse['prixNonHumanoide'] = 0;
    $reponse['devise'] = 0;
    $reponse['idMalediction'] = 0;
    $reponse['categorie'] = 0;
    $reponse['idMateriaux'] = 0;
    $reponse['taille'] = 0;
    $reponse['degats'] = 0;
    $reponse['critique'] = 0;
    $reponse['facteurPortee'] = 0;
    $reponse['armure'] = 0;
    $reponse['bonusDexteriteMax'] = 0;
    $reponse['malusArmureTests'] = 0;
    $reponse['risqueEchecSorts'] = 0;
*/


}