function getAttirupeV2(e)
{
	var attirupe = e.value;
	$.ajax({
		url: '',
		type: 'POST',
		data: { attirupe: attirupe},
		success: function (data) {
			$('#selectData').html(data);
		},
		error: function (data) {
			$('#selectData').html(data);
		}
	});
}
function getStock(e)
{
	var attirupe = e.value;
	var a = document.getElementById("attirupe");
	var b = a.value
	$.ajax({
		url: '',
		type: 'POST',
		data: { stock: attirupe, mainatt: b},
		success: function (data) {
			$('b#stock').html(data);
		},
		error: function (data) {
			$('b#stock').html(data);
		}
	});
}
function deleteGrup(e)
{
	if (confirm("Kombinasyon silinecek") == true) {
		$.ajax({
			url: '',
			type: 'POST',
			data: { deleteAttirupe: e},
			success: function (data) {
				$('#att'+e+'').remove();
			}
		});
	}
}
function deleteProduct(e)
{
	if (confirm("Eğer ürünü silerseniz ürüne ait tüm veriler silinir") == true) {
		$.ajax({
			url: '',
			type: 'POST',
			data: { deleteProduct: e},
			success: function (data) {
				alert("Ürün silindi");
				window.location.href = 'index.php';
			}
		});
	}
}
function deleteBundle(e)
{
	if (confirm("Bu ürün paketten çıkarılacak") == true) {
		$.ajax({
			url: '',
			type: 'POST',
			data: { deleteBundle: e},
			success: function (data) {
				$('#bundle'+e+'').remove();
			}
		});
	}
}
if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
}
$(document).ready(function(){ 
	$("#searchProduct").on("keyup", function() {    
		var value = $(this).val().toLowerCase();    
		$(".searchProduct").filter(function() {      
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)    
		});  
	});
});