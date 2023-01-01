<?php


class Objet implements JsonSerializable
{
    public
        $_idObjet,
        $_idPersonnage,
        $_nom,
        $_fauxNom,
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
        $_risqueEchecSorts,
        $_solidite,
        $_resistance,
        $_afficherNom,
        $_afficherEffetMagique,
        $_afficherMalediction,
        $_afficherMateriau,
        $_afficherInfos;

	public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
	public function setIdObjet($idObjet)
    {
        if($idObjet) {
            $idObjet = (int)$idObjet;

            if ($idObjet > 0) {
                $this->_idObjet = $idObjet;
            }
        }
    }

	public function setIdPersonnage($idPersonnage)
    {
        if($idPersonnage) {
            $idPersonnage = (int)$idPersonnage;

            if ($idPersonnage > 0) {
                $this->_idPersonnage = $idPersonnage;
            }
        }
    }

	public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

    public function setFauxNom($fauxNom)
    {
        if (is_string($fauxNom))
        {
            $this->_fauxNom = $fauxNom;
        }
    }

	public function setBonus($bonus)
    {
        if($bonus) {
            $this->_bonus = (int)$bonus;
        }
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
        if($prix || intval($prix) === 0) {
            $prix = (float)$prix;
            $this->_prix = $prix;
        }
    }
	public function setPrixNonHumanoide($prixNonHumanoide)
    {
        if($prixNonHumanoide || intval($prixNonHumanoide) === 0) {
            $prixNonHumanoide = (float)$prixNonHumanoide;
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
        if($idMalediction) {
            $idMalediction = (int)$idMalediction;

            if ($idMalediction > 0) {
                $this->_idMalediction = $idMalediction;
            }
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
        if($idMateriaux) {
            $idMateriaux = (int)$idMateriaux;

            if ($idMateriaux > 0) {
                $this->_idMateriaux = $idMateriaux;
            }
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
        if ($armure) {
            $this->_armure = (int)$armure;
        }
    }
	public function setBonusDexteriteMax($bonusDexteriteMax)
    {
        if ($bonusDexteriteMax) {
            $this->_bonusDexteriteMax = (int)$bonusDexteriteMax;
        }
    }
	public function setMalusArmureTests($malusArmureTests)
    {
        if ($malusArmureTests) {
            $this->_malusArmureTests = (int)$malusArmureTests;
        }
    }

	public function setRisqueEchecSorts($risqueEchecSorts)
    {
        if (is_string($risqueEchecSorts))
        {
            $this->_risqueEchecSorts = $risqueEchecSorts;
        }
    }
    public function setSolidite($solidite)
    {
        if ($solidite) {
            $this->_solidite = (int)$solidite;
        }
    }
    public function setResistance($resistance)
    {
        if ($resistance) {
            $this->_resistance = (int)$resistance;
        }
    }
    public function setAfficherNom($afficherNom)
    {
        $this->_afficherNom = boolval($afficherNom);
    }

    public function setAfficherEffetMagique($afficherEffetMagique)
    {
        $this->_afficherEffetMagique = boolval($afficherEffetMagique);
    }

    public function setAfficherMalediction($afficherMalediction)
    {
        $this->_afficherMalediction = boolval($afficherMalediction);
    }

    public function setAfficherMateriau($afficherMateriau)
    {
        $this->_afficherMateriau = boolval($afficherMateriau);
    }

    public function setAfficherInfos($afficherInfos)
    {
        $this->_afficherInfos = boolval($afficherInfos);
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
            'idObjet' => $this->_idObjet,
            'idPersonnage' => $this->_idPersonnage,
            'nom' => $this->_nom,
            'fauxNom' => $this->_fauxNom,
            'bonus' => $this->_bonus,
            'type' => $this->_type,
            'prix' => $this->_prix,
            'prixNonHumanoide' => $this->_prixNonHumanoide,
            'devise' => $this->_devise,
            'idMalediction' => $this->_idMalediction,
            'categorie' => $this->_categorie,
            'idMateriaux' => $this->_idMateriaux,
            'taille' => $this->_taille,
            'degats' => $this->_degats,
            'critique' => $this->_critique,
            'facteurPortee' => $this->_facteurPortee,
            'armure' => $this->_armure,
            'bonusDesteriteMax' => $this->_bonusDexteriteMax,
            'malusArmureTests' => $this->_malusArmureTests,
            'risqueEchecSorts' => $this->_risqueEchecSorts,
            'solidite' => $this->_solidite,
            'resistance' => $this->_resistance,
            'afficherNom' => $this->_afficherNom,
            'afficherEffetMagique' => $this->_afficherEffetMagique,
            'afficherMalediction' => $this->_afficherMalediction,
            'afficherMateriau' => $this->_afficherMateriau,
            'afficherInfos' => $this->_afficherInfos,
        ];
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