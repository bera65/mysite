<?php
	include('controller/config.php');
	$product = Tools::getValue('product');
	if (((bool)Tools::isSubmit('attirupe')) == true)
	{
		$idAttirupe = Tools::getValue('attirupe');
		if(Functions::attirupeData($idAttirupe, 'value2'))
			echo Functions::attirupeData($idAttirupe, 'value2');
		else
		{
			$quantity = Tools::getRow('attirupe_grup', 'value1 = '.(int)$idAttirupe.'', 'quantity');
			echo '
				<script type="text/javascript">
					$("#stock").html('.$quantity.')
				</script>
			';
		}
		exit();
	}
	else if (((bool)Tools::isSubmit('stock')) == true)
	{
		$stock 	= Tools::getValue('stock');
		$mainatt = Tools::getValue('mainatt');
		if (Tools::isInt($stock) AND Tools::isInt($mainatt))
		{
			$getStock = Tools::getRow('attirupe_grup', 'id_product = '.(int)$product.' AND value2 = '.(int)$stock.' AND value1 = '.(int)$mainatt.'', 'quantity');
			if ($getStock)
				echo $getStock;
			else
				echo 0;
		}
		exit();
	}
	else
	{
		$productName = $getStock = Tools::getRow('product', 'id_product = '.(int)$product.'', 'name');
		$page->createPage('product', $productName);
	}
?>