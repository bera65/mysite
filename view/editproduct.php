<?php
	$idProduct 	= Tools::getValue('updateproduct');
	$product 	= Tools::getQuery('product', 'id_product = '.(int)$idProduct.'');
	$images 	= Tools::getQuery('image', 'id_product = '.(int)$idProduct.'');
	$attirupes	= Tools::getQuery('attirupe', 'id_attirupe > 0');
	$attirupeG	= Tools::getQuery('attirupe_grup', 'id_product = '.(int)$idProduct.'');
	$productL	= Tools::getQuery('attirupe_grup ag INNER JOIN product p ON ag.id_product = p.id_product', 'ag.id_product > 0');
	
	function attirupeValue($id)
	{
		if (Tools::isInt($id))
		{
			return Tools::getQuery('attirupe_value', 'id_attirupe = '.(int)$id.'');
		}
	}
	foreach ($product as $p)
	{
		$name 				= $p['name'];
		$price 				= $p['price'];
		$description 		= $p['description'];
		$description_long 	= $p['description_long'];
		$stock 				= $p['stock'];
		$bundle 			= $p['bundle'];
	}
$html = '
<div class="main">
<form action="" method="POST" enctype="multipart/form-data" class="addProductForm">
<h3>'.$name.' Güncelle</h3>
<hr />
  <div class="mb-3 row">
    <label for="productName" class="col-sm-4 col-form-label">Ürün Adı</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="productName" value="'.$name.'" id="productName">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productPrice" class="col-sm-4 col-form-label">Ürün Fiyatı</label>
    <div class="col-sm-8">
		<div class="input-group">
		  <input type="text" name="productPrice" value="'.$price.'" class="form-control">
		  <span class="input-group-text" id="productPrice">₺</span>
		</div>
		<small>Küsürat için lütfen "." (nokta) girin virgül yazmayınız ve sadece rakam kullanın. ör: 15.99</small>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productQuantity" class="col-sm-4 col-form-label">Stok Miktarı</label>
    <div class="col-sm-8">
		<div class="input-group">
		  <input type="number" name="productQuantity" value="'.$stock.'" class="form-control" value="0">
		  <span class="input-group-text" id="productQuantity">adet</span>
		</div>
		<small>Eğer ürüne kombinasyon eklerseniz kombinasyon stoğunu baz alır. Stoğu 0 girin</small>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productDescShort" class="col-sm-4 col-form-label">Kısa Açıklama</label>
    <div class="col-sm-8">
      <textarea class="form-control" name="productDescShort">'.$description.'</textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productDesc" class="col-sm-4 col-form-label">Uzun Açıklama</label>
    <div class="col-sm-8">
      <textarea class="form-control" id="editor" name="productDesc">'.$description_long.'</textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="attirupe" class="col-sm-4 col-form-label">Kombinasyon Var mı?</label>
    <div class="col-sm-8">
      <select name="attirupe" id="attirupe" class="form-control" onChange="addAttirupe(this)">
		<option value="0">Hayır</option>
		<option value="1">Evet</option>
	  </select>
    </div>
  </div>
  <div id="addAttirupeDiv" class="hideDiv">
	<div class="mb-3 row">
    <label for="attirupe" class="col-sm-4 col-form-label">Kombinasyonlar</label>
    <div class="col-sm-8"> <div class="row">';
      foreach ($attirupes as $at)
	  {
		  $html .= '<div class="col-sm-4"><input type="hidden" name="attirupeMain[]" value="'.$at['id_attirupe'].'" />';
		  $html .= '<h5>'.$at['attirupe_name'].'</h5>';
			foreach (attirupeValue($at['id_attirupe']) as $av)
			{
				$html .= '
					<div class="form-check">
					  <input class="form-check-input" name="attirupe'.$at['id_attirupe'].'[]" type="checkbox" value="'.$av['id_attirupe_value'].'" id="attirupe">
					  <label class="form-check-label" for="flexCheckDefault">
						'.$av['value'].'
					  </label>
					</div>
				';
			}
		  $html .= '</div>';
	  }
$html .= '<button type="submit" name="addAttirupeNew" value="1" class="btn btn-success">Kombinasyon Oluştur</button></div></div>
  </div>
  </div>
';
$i = 1;
foreach ($attirupeG as $ag)
{
	$name = '';
	if ($ag['value1'])
		$name .= Functions::attirupeName($ag['value1']);
	if ($ag['value2'])
		$name .= ' > '.Functions::attirupeName($ag['value2']);
	if ($ag['value3'])
		$name .= ' > '.Functions::attirupeName($ag['value3']);
	
	$html .= '
	<div id="att'.$ag['id_grup'].'" class="mb-3 row">
		<label for="attirupe" class="col-sm-4 col-form-label">'.$i.'. Kombinasyon</label>
		<input type="hidden" name="attValue[]" value="'.$ag['id_grup'].'" />
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-8 col-7"><span class="form-control">'.$name.'</span></div> 
				<div class="col-sm-2 col-3"><input type="number" class="form-control" name="stock[]" value="'.$ag['quantity'].'" /></div>
				<div class="col-sm-1 col-2"><button type="button" class="btn btn-danger" onClick="deleteGrup('.$ag['id_grup'].')"><i class="fa fa-trash-o"></i></button></div>
			</div>
		</div>
	</div>
	';
$i++;
}

$html .= '
	<div class="mb-3 row">
    <label for="bundle" class="col-sm-4 col-form-label">Ürün Paketi mi?</label>
    <div class="col-sm-8">
      <select name="bundlee" id="bundles" class="form-control" onChange="addBundle(this)">
		<option value="0">Hayır</option>
		<option value="1">Evet</option>
	  </select>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="totalprice" class="col-sm-4 col-form-label">Paket Fiyatı</label>
    <div class="col-sm-8">
      <select name="totalprice" id="totalprice" class="form-control">
		<option value="1">Ürünlerin toplamını baz al</option>
		<option value="0">Girilen fiyatı baz al</option>
	  </select>
    </div>
  </div>
  <div id="bundle" class="hideDiv">
	<div class="mb-3 row">
		<label for="bundle" class="col-sm-4 col-form-label">Ürün Ara</label>
		<div class="col-sm-8">
			<input id="searchProduct" class="form-control" type="text" placeholder="Ürün Ara">
		</div>
	</div>
	<table class="table table-striped">
	<thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Ürün Adı</th>
		  <th scope="col">Kombinasyon</th>
		</tr>
	</thead>
  <tbody>';
  foreach ($productL as $pl)
  {
	  $html .= '<tr class="searchProduct">
		<td><input type="checkbox" name="bundle[]" value="'.$pl['id_grup'].'" /></td>
		<td>'.$pl['name'].'</td>
		<td>'.Functions::attirupeName($pl['value1']).' > '.Functions::attirupeName($pl['value2']).' '.Functions::attirupeName($pl['value3']).'</td>
	  </tr>';
  }
	
$html .= '</tbody></table></div>';
$countBundle = json_decode($bundle, true);
if ($countBundle)
{
	$html .= '<h3>Paketteki ürünler</h3> <hr />
		<table class="table table-striped">
		<thead>
			<tr>
			  <th scope="col">Ürün Adı</th>
			  <th scope="col">Kombinasyon</th>
			  <th scope="col">Stok</th>
			  <th scope="col">Sil</th>
			</tr>
		</thead>
	  <tbody>
	';
	$array = json_decode($bundle, true);
	foreach ($array as $ar => $key)
	{
		$html .= Functions::getProductList($key, 'edit');
	}
	$html .= '</tbody></table>';
}

$html .= '
	<div class="mb-3 row">
	  <label for="formFile" class="col-sm-4 col-form-label">Resim Yükle</label>
		<div class="col-sm-8">
			<input class="form-control" type="file" name="imageUpload" id="formFile">
			<small>Resim boyutu 600x600 </small>
		</div>
	</div>
	<div class="mb-3 row">
		<label for="formFile" class="col-sm-4 col-form-label">&nbsp;</label>
		<div class="col-sm-8">';
		foreach ($images as $i)
		{
			$html .= '<img src="img/'.$i['id_image'].'.jpg" alt="Resim" class="productImages" />';
		}
$html .= '</div></div>
<button type="submit" name="editaProduct" value="1" class="btn btn-primary">Kaydet</button>
<button type="button" name="deleteProducts" onclick="deleteProduct('.$idProduct.')" class="btn btn-danger">Ürünü Sil</button>
</form>
</div>';
echo $html;
?>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
		setTimeout(function() {
			$('.rightPanel').fadeOut('fast');
		}, 4000);
	function addAttirupe(e) {
		$('#addAttirupeDiv').hide();
		var elemnts = e.value;
		if (elemnts == 1)
		{
			$('#addAttirupeDiv').show();
		}
	}
	function addBundle(e) {
		$('#bundle').hide();
		var elemnts = e.value;
		if (elemnts == 1)
		{
			$('#bundle').show();
		}
	}
</script>