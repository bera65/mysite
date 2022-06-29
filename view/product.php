<div class="main">
	<div class="row">
		<div class="col-sm-4"><?php Functions::getProductImage(Tools::getValue('product'), 'create'); ?></div>
		<div class="col-sm-8"><?php Functions::getProduct(Tools::getValue('product')); ?></div>
	</div>
	<div class="row">
		<div class="col-12">
		<p><br /></p>
		<hr />
			<a href="addproduct.php?updateproduct=<?php echo Tools::getValue('product'); ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ürünü Güncelle</a>
		</div>
	</div>
</div>
