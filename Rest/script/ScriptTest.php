<html>
<body>
<?php




$array_expression = [
    'idEffetMagique' => 0,
    'Objet' => 3,
    'nom' => 1,
    'niveau' => 5,
    'effet' => 1,
    'prix' => 2,
    'prixNonHumanoide' => 2,
    'devise' => 1,
    'idMalediction' => 3,
    'categorie' => 1,
    'idMateriaux' => 3,
    'taille' => 1,
    'degats' => 1,
    'critique' => 1,
    'facteurPortee' => 1,
    'armure' => 5,
    'bonusDexteriteMax' => 5,
    'malusArmureTests' => 5,
    'risqueEchecSorts' => 1
];

?>
<textarea style="height : 100%; width : 100%">
<?php
?>
public
<?php
foreach ($array_expression as $key => $value){

	?> $_<?=$key?>,
	<?php
}

?>

	public function __construct(array $donnees)
	  {
		$this->hydrate($donnees);
	  }
<?php

foreach ($array_expression as $key => $value){
    if ($value == 0){
	?>
	public function set<?=ucfirst($key)?>($<?=$key?>)
	{
	$<?=$key?> = (int) $<?=$key?>;

		if ($<?=$key?> > 0)
		{
			$this->_<?=$key?> = $<?=$key?>;
		}
	}
<?php
	}elseif ($value == 1){
		?>

	public function set<?=ucfirst($key)?>($<?=$key?>)
	{
		if (is_string($<?=$key?>))
		{
			$this->_<?=$key?> = $<?=$key?>;
		}
	}
<?php
	}elseif($value == 2){
		?>
	public function set<?=ucfirst($key)?>($<?=$key?>)
	{
	$<?=$key?> = (float) $<?=$key?>;

		if ($<?=$key?> > 0)
		{
			$this->_<?=$key?> = $<?=$key?>;
		}
	}
<?php
	}elseif ($value == 3){
		?>

	public function set<?=ucfirst($key)?>($ID_<?=$key?>)
	{
	$ID_<?=$key?> = (int) $ID_<?=$key?>;

		if ($ID_<?=$key?> > 0)
		{
			include('BDD.php');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

			$manager = new EquipementManager($bdd);

			$equipement = $manager->get($ID_<?=$key?>);
			$this->_<?=$key?> = $equipement;
		}
	}
<?php
	}elseif($value == 4){
		?>
	public function set<?=ucfirst($key)?>($<?=$key?>)
	{
	$this->_<?=$key?> = (float)$<?=$key?>;
	}
<?php
	}elseif($value == 5){
		?>
	public function set<?=ucfirst($key)?>($<?=$key?>)
	{
	$this->_<?=$key?> = (int)$<?=$key?>;
	}
<?php
	}
}
foreach ($array_expression as $key => $value) {
    ?>
    $reponse['<?= $key ?>'] = 0;
    <?php
}
?>

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
</textarea>
</body>
</html>