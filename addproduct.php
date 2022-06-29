<?php
	include('controller/config.php');
	$output = '';
	if (((bool)Tools::isSubmit('addProduct')) == true)
	{
		$productName 		= Tools::getValue('productName');
		$productPrice 		= Tools::getValue('productPrice');
		$productQuantity 	= Tools::getValue('productQuantity');
		$productDescShort 	= Tools::getValue('productDescShort');
		$productDesc 		= Tools::getValue('productDesc');
		if (Tools::isName($productName) AND Tools::isPrice($productPrice) AND Tools::isInt($productQuantity) AND Tools::isCleanHtml($productDescShort) AND Tools::isCleanHtml($productDesc))
		{
			$data = array(
				'name' 				=> $productName,
				'price' 			=> $productPrice,
				'description' 		=> $productDescShort,
				'description_long' 	=> $productDesc,
				'stock' 			=> $productQuantity,
			);
			$lastID = Tools::insert('product', $data);
			$output = $lastID.'<div class="alert alert-success rightPanel" role="alert">Başarıyla oluşturuldu</div>';
			header("location:addproduct.php?updateproduct=".(int)$lastID."");
		}
		else
			$output = '<div class="alert alert-danger rightPanel" role="alert">Ürün eklerken hata oluştu lüften kontrol edip tekrar yükleyiniz</div>';
	}
	if (((bool)Tools::getValue('updateproduct')) == true)
	{
		$idProduct 	= Tools::getValue('updateproduct');
		if (Tools::isInt($idProduct))
		{
			$product 	= Tools::getQuery('product', 'id_product = '.(int)$idProduct.'');
			
			if ($product)
				$page->createPage('editproduct', 'Ürünü Düzenle');
			else
			{
				echo '<div class="alert alert-danger rightPanel" role="alert">Ürün bulunamadı</div>';
				$page->createPage('addproduct', 'Yeni Ürün Ekle');
			}
		}
		else
		{
			echo '<div class="alert alert-danger rightPanel" role="alert">Ürün bulunamadı</div>';
			$page->createPage('addproduct', 'Yeni Ürün Ekle');
		}
		if (((bool)Tools::isSubmit('deleteBundle')) == true)
		{
			$deleteValue = Tools::getValue('deleteBundle');
			if (Tools::isInt($deleteValue))
			{
				if (Tools::getQuery('attirupe_grup', 'id_grup = '.(int)$deleteValue.''))
				{
					$getProduct = Tools::getRow('product', 'id_product = '.(int)$idProduct.'', 'bundle');
					$numbers = json_decode($getProduct,true);

					if (($key = array_search($deleteValue, $numbers)) !== false) {
						unset($numbers[$key]);
					}
					$numbers_final = json_encode($numbers, true);
					echo $numbers_final.'-'.$idProduct;
					$data = array(
						'bundle' => $numbers_final
					);
					Tools::update('product', $data, 'id_product = '.(int)$idProduct.'');
				}
			}
		}
		if (((bool)Tools::isSubmit('deleteProduct')) == true)
		{
			$deleteValue = Tools::getValue('deleteProduct');
			if (Tools::isInt($deleteValue))
			{
				if (Tools::getQuery('product', 'id_product = '.(int)$deleteValue.''))
				{
					Tools::deleteQuery('product', 'id_product = '.(int)$deleteValue.' LIMIT 1');
					Tools::deleteQuery('attirupe_grup', 'id_product = '.(int)$deleteValue.'');
					Tools::deleteQuery('image', 'id_product = '.(int)$deleteValue.'');
				}
			}
		}
		if (((bool)Tools::isSubmit('deleteAttirupe')) == true)
		{
			$deleteValue = Tools::getValue('deleteAttirupe');
			if (Tools::isInt($deleteValue))
			{
				if (Tools::getQuery('attirupe_grup', 'id_grup = '.(int)$deleteValue.''))
					Tools::deleteQuery('attirupe_grup', 'id_grup = '.(int)$deleteValue.' LIMIT 1');
			}
		}
		if (((bool)Tools::isSubmit('editaProduct')) == true)
		{
			/*** Ürün Güncelleme başlangıç ****/
			$productName 		= Tools::getValue('productName');
			$productPrice 		= Tools::getValue('productPrice');
			$productQuantity 	= Tools::getValue('productQuantity');
			$productDescShort 	= Tools::getValue('productDescShort');
			$productDesc 		= Tools::getValue('productDesc');
			$attirupe 			= Tools::getValue('attirupe');
			$stock 				= Tools::getValue('stock');
			$attValue 			= Tools::getValue('attValue');
			$bundle 			= Tools::getValue('bundle');
			$bundlee 			= Tools::getValue('bundlee');
			$totalprice 		= Tools::getValue('totalprice');
			
			
		/** Ürün kombinasyon stok güncelle ****/	
			if ($stock)
			{
				for ($att = 0; $att < COUNT($attValue); $att++)
				{
					$data = array(
						'quantity' => $stock[$att]
					);
					Tools::update('attirupe_grup', $data, 'id_grup = '.(int)$attValue[$att].'');
				}
			}
			
		/** Ürün paketi oluştur ****/
			if ($bundlee == 1 AND COUNT($bundle))
			{
				$json = '';
				for ($b = 0; $b < COUNT($bundle); $b++)
				{
					if ($b == 0)
						$json .= '"'.$b.'" : '.$bundle[$b].'';
					else
						$json .= ',"'.$b.'" : '.$bundle[$b].'';
				}
				
				$data = array(
					'bundle' => "{".$json."}"
				);
				Tools::update('product', $data, 'id_product = '.(int)$idProduct.'');
			}
			
			/** Hepsini Kaydet ****/
			
				$data = array(
					'name' => $productName,
					'price' => $productPrice,
					'description' => $productDescShort,
					'description_long' => $productDesc,
					'btotal' => $totalprice,
					'stock' => $productQuantity,
				);
				Tools::update('product', $data, 'id_product = '.(int)$idProduct.'');
			
			/** Resim Yükle ****/
				
			if ($_FILES['imageUpload']['tmp_name'])
			{
				Tools::deleteQuery('image', 'id_product = '.(int)$idProduct.'');
				$data = array(
					'id_product' => $idProduct,
					'cover' 	=> 1,
				);
				
				$lasID = Tools::insert('image', $data);
				function resizeImage($resourceType, $image_width, $image_height, $resizeWidth, $resizeHeight)
				{
					$imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
					imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
					return $imageLayer;
				}
				$new_width = 600;
				$new_height = 600;
				$fileName = $_FILES['imageUpload']['tmp_name'];
				$sourceProperties = getimagesize($fileName);
				$resizeFileName = $lasID;
				$uploadPath = "img/";
				$fileExt = pathinfo($_FILES['imageUpload']['name'], PATHINFO_EXTENSION);
				$uploadImageType = $sourceProperties[2];
				$sourceImageWidth = $sourceProperties[0];
				$sourceImageHeight = $sourceProperties[1];
				switch ($uploadImageType)
				{
					case IMAGETYPE_JPEG:
						$resourceType = imagecreatefromjpeg($fileName);
						$imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
						imagejpeg($imageLayer, $uploadPath . $resizeFileName . '.' . $fileExt);
					break;

					case IMAGETYPE_GIF:
						$resourceType = imagecreatefromgif($fileName);
						$imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
						imagegif($imageLayer, $uploadPath . $resizeFileName . '.' . $fileExt);
					break;

					case IMAGETYPE_PNG:
						$resourceType = imagecreatefrompng($fileName);
						$imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
						imagepng($imageLayer, $uploadPath . $resizeFileName . '.' . $fileExt);
					break;

					case IMAGETYPE_JPG:
						$resourceType = imagecreatefrompng($fileName);
						$imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
						imagepng($imageLayer, $uploadPath . $resizeFileName . '.' . $fileExt);
					break;

					default:
						$imageProcess = 0;
					break;
				}
			}
			echo '<div class="alert alert-success rightPanel" role="alert">Ürün başarıyla güncellendi</div>';
		}	

		if (((bool)Tools::isSubmit('addAttirupeNew')) == true)
		{
			$attirupeMain = Tools::getValue('attirupeMain');
			$idProduct	  = Tools::getValue('updateproduct');
			$newArray = '';
			Tools::deleteQuery('attirupe_grup', 'id_product = '.(int)$idProduct.'');
			$attCount = COUNT($attirupeMain);
			if (Tools::getValue('attirupe2') AND Tools::getValue('attirupe3'))
			{
				$attirupe1 = Tools::getValue('attirupe1');
				$attirupe2 = Tools::getValue('attirupe2');
				$attirupe3 = Tools::getValue('attirupe3');
				for ($a = 0; $a < COUNT($attirupe1); $a++)
				{
					for ($b = 0; $b < COUNT($attirupe2); $b++)
					{
						for ($c = 0; $c < COUNT($attirupe3); $c++)
						{
							$data = array(
								'value1' => (int)$attirupe1[$a],
								'value2' => (int)$attirupe2[$b],
								'value3' => (int)$attirupe3[$c],
								'id_product' => (int)$idProduct,
							);
							$lastID = Tools::insert('attirupe_grup', $data);
						}
					}
				}
			}
			else if (Tools::getValue('attirupe1') AND Tools::getValue('attirupe2'))
			{
				$attirupe1 = Tools::getValue('attirupe1');
				if (Tools::getValue('attirupe2'))
					$attirupe2 = Tools::getValue('attirupe2');
					
				for ($a = 0; $a < COUNT($attirupe1); $a++)
				{
					for ($b = 0; $b < COUNT($attirupe2); $b++)
					{
						$data = array(
							'value1' => (int)$attirupe1[$a],
							'value2' => (int)$attirupe2[$b],
							'id_product' => (int)$idProduct,
						);
						$lastID = Tools::insert('attirupe_grup', $data);
					}
				}
			}
			else if (Tools::getValue('attirupe1') OR Tools::getValue('attirupe2') OR Tools::getValue('attirupe3'))
			{
				if (Tools::getValue('attirupe1'));
					$attirupe1 = Tools::getValue('attirupe1');
				if (Tools::getValue('attirupe2'))
					$attirupe1 = Tools::getValue('attirupe2');
				if (Tools::getValue('attirupe3'))
					$attirupe1 = Tools::getValue('attirupe3');
				for ($a = 0; $a < COUNT($attirupe1); $a++)
				{
					$data = array(
						'value1' => (int)$attirupe1[$a],
						'id_product' => (int)$idProduct,
					);
					$lastID = Tools::insert('attirupe_grup', $data);
				}
			}
			echo '<script type="text/javascript">
				if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
				}
				$(document).ready(function () {
					location.reload(); 
				});
			</script>';			
		}
	}
	else
	{
		echo $output;
		$page->createPage('addproduct', 'Yeni Ürün Ekle');
	}
?>