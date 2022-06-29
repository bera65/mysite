<?php

Class Functions
{
	public static function getProducts()
	{
		$getProduct	= Tools::getQuery('product p LEFT JOIN image i ON p.id_product = i.id_product','i.cover = 1 ORDER BY p.id_product DESC');
		$html = '';
		foreach ($getProduct as $product)	
		{
			$html .= '
			<div class="col-12 col-sm-6 col-md-4 productList">
				<div class="card" aria-hidden="true">
				  <div class="row g-0">
					<div class="col-md-4 col-4 productImage">
					<a href="product.php?product='.$product['id_product'].'">
					  <img class="rounded-start" src="img/'.$product['id_image'].'.jpg" alt="'.$product['name'].'" />
					</a>
					</div>
					<div class="col-md-8 col-8">
					  <div class="card-body">
						<h5 class="card-title">'.$product['name'].'</h5>
						<p class="card-text">'.substr($product['description'], 0,80).'</p>
						<p class="card-text"><b>₺ '.$product['price'].'</b></p>
					  </div>
					</div>
				  </div>
				</div>
			</div>
			';
		}
		echo $html;
	}
	public static function getProductImage($idProduct)
	{
		$getRow = Tools::getQuery('image','id_product = '.(int)$idProduct.' AND cover = 1');
		$html = '';
		foreach ($getRow as $product)	
		{
			$html = '<img class="rounded-start" src="img/'.$product['id_image'].'.jpg" alt="Ürün Resmi" />';
		}
		echo $html;
	}
	public static function getProduct($idProduct)
	{
		$getRow = Tools::getQuery('product', 'id_product = '.(int)$idProduct.'');
		$html = '';
		$price = 0;
		$stock = 0;
		if ($getRow)
		{
			foreach ($getRow as $product)	
			{
				$price = $product['price'];
				$stock = $product['stock'];
				$html .= '<h3>'.$product['name'].'</h3>';
				$html .= '<p>'.$product['description'].'</p>';
				$array = json_decode($product['bundle'], true);
				if (@COUNT($array))
				{
					$html .= '<h3>Paketteki ürünler</h3> <hr />
						<table class="table table-striped">
						<thead>
							<tr>
							  <th scope="col">Ürün Adı</th>
							  <th scope="col">Kombinasyon</th>
							  <th scope="col">Stok</th>
							  <th scope="col">&nbsp;</th>
							</tr>
						</thead>
					  <tbody>
					';
					$stocs = array();
					$price = 0;
					foreach ($array as $ar => $key)
					{
						$html .= Functions::getProductList($key);

						if ($product['btotal'])
							$price += Functions::totalPrice($key);
						else
							$price = $product['price'];
						$stocs[] = Functions::getStok($key);
					}
					$stock = min($stocs);
					$html .= '</tbody></table>';
				}
				else
				{
					if (Tools::isHaveAttirupe($idProduct))
						$html .= Functions::attirupeData($idProduct);
				}
				$html .= '<p>'.$product['description_long'].'</p>';
			}
			
			$html .= '<div class="productFooter"> <span>Ürün Stok : <b id="stock">'.$stock.'</b></span> <span>Ürün Fiyat: <b>₺ '.$price.'</b></span></div>';
			echo $html;
		}
		else
			header("location:404.php");
	}
	public static function getProductList($idProduct, $page = NULL)
	{
		$getProduct	= Tools::getQuery('attirupe_grup ag INNER JOIN product p ON ag.id_product = p.id_product','ag.id_grup = '.(int)$idProduct.'');
		$html = '';
		foreach ($getProduct as $product)	
		{
			if ($page)
			{
				$html .= '
					<tr id="bundle'.$product['id_grup'].'">
						<td>'.$product['name'].'</td>
						<td>'.Functions::getGrup($product['value1']).' > '.Functions::getGrup($product['value2']).'</td>
						<td>'.$product['quantity'].'</td>
						<td><a class="btn btn-danger" onClick="deleteBundle('.$product['id_grup'].')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
					</tr>
				';
			}
			else
				$html .= '
					<tr>
						<td>'.$product['name'].'</td>
						<td>'.Functions::getGrup($product['value1']).' &nbsp;&nbsp;&nbsp;'.Functions::getGrup($product['value2']).'</td>
						<td>'.$product['quantity'].'</td>
						<td>&nbsp;</td>
					</tr>
				';
		}
		return $html;
	}	
	public static function getGrup($idGrup)
	{
		$getGrup = Tools::getQuery('attirupe_value','id_attirupe_value = '.(int)$idGrup.'');
		foreach ($getGrup as $gg)
		{
			return $gg['value'];
		}
	}
	public static function getStok($idProduct)
	{
		$getProduct = Tools::getRow('attirupe_grup ','id_grup = '.(int)$idProduct.' ORDER BY quantity ASC', 'quantity');

		return $getProduct;
	}
	public static function totalPrice($idProduct)
	{
		$getProduct = Tools::getQuery('attirupe_grup ag INNER JOIN product p ON ag.id_product = p.id_product', 'id_grup = '.(int)$idProduct.'');
		$html = 0;
		foreach ($getProduct as $product)	
		{
			$html += $product['price'];
		}
		return $html;
	}
	public static function attirupeData($idData, $type = NULL)
	{
		$idProduct = Tools::getValue('product');
		$label = '';
		if ($type)
			$attirupes = Tools::getQuery('attirupe_grup ag INNER JOIN attirupe_value av ON ag.value2 = av.id_attirupe_value INNER JOIN attirupe a ON av.id_attirupe = a.id_attirupe', 'ag.value1 = '.(int)$idData.' AND ag.id_product = '.(int)$idProduct.'');
		else	
			$attirupes = Tools::getQuery('attirupe_grup ag INNER JOIN attirupe_value av ON ag.value1 = av.id_attirupe_value INNER JOIN attirupe a ON av.id_attirupe = a.id_attirupe', 'ag.id_product = '.(int)$idData.' GROUP BY ag.value1');
		if ($attirupes)
		{
			$option = '<option selected>----------</option>';
			foreach ($attirupes as $at)
			{
				$label 		= $at['attirupe_name'];
				$option 	.= '<option value="'.$at['id_attirupe_value'].'">'.$at['value'].'</option>';
			}
			if ($type)
			{
				$html = '<div class="attirupeDiv">
				<label for="attirupe">'.$label.' </label> 
				<select name="" id="attirupe" id="attirupeV2" onChange="getStock(this)">
					'.$option.'
				</select>
				</div>';
			}
			else
			{
			$html = '<div class="attirupeDiv">
				<label for="attirupe">'.$label.' </label> 
				<select name="" id="attirupe" onChange="getAttirupeV2(this)">
					'.$option.'
				</select>
				</div><div id="selectData"></div>';
			}
			return $html;
		}
		else
			return 0;
	}
	public static function attirupeName($name)
	{
		if (Tools::isInt($name))
		{
			return Tools::getRow('attirupe_value', 'id_attirupe_value = '.(int)$name.'', 'value');
		}
	}

}