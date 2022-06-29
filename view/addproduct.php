<div class="main">
<form action="" method="POST" class="addProductForm">
<h3>Yeni Bir Ürün Oluşturun</h3>
<hr />
  <div class="mb-3 row">
    <label for="productName" class="col-sm-4 col-form-label">Ürün Adı</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="productName" id="productName">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productPrice" class="col-sm-4 col-form-label">Ürün Fiyatı</label>
    <div class="col-sm-8">
		<div class="input-group">
		  <input type="text" name="productPrice" class="form-control">
		  <span class="input-group-text" id="productPrice">₺</span>
		</div>
		<small>Küsürat için lütfen "." (nokta) girin virgül yazmayınız ve sadece rakam kullanın. ör: 15.99</small>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productQuantity" class="col-sm-4 col-form-label">Stok Miktarı</label>
    <div class="col-sm-8">
		<div class="input-group">
		  <input type="number" name="productQuantity" class="form-control" value="0">
		  <span class="input-group-text" id="productQuantity">adet</span>
		</div>
		<small>Eğer ürüne kombinasyon eklerseniz kombinasyon stoğunu baz alır. Stoğu 0 girin</small>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productDescShort" class="col-sm-4 col-form-label">Kısa Açıklama</label>
    <div class="col-sm-8">
      <textarea class="form-control" name="productDescShort"></textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="productDesc" class="col-sm-4 col-form-label">Uzun Açıklama</label>
    <div class="col-sm-8">
      <textarea class="form-control" id="editor" name="productDesc"></textarea>
    </div>
  </div>
  <button type="submit" name="addProduct" value="1" class="btn btn-primary">Kaydet ve Devam Et</button>
</form>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
		setTimeout(function() {
			$('.rightPanel').fadeOut('fast');
		}, 4000);
</script>