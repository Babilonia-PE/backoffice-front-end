@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="@asset("css/jquery.nestable.css")">
<style>
.socialite { display: block; float: left; height: 35px; }
.gap-1{gap: 0.5rem}
.gap-2{gap: 1rem}
.gap-3{gap: 1.5rem}
</style>
@endsection

@section('page')

Configuración

@endsection

@section('content')
<div class="row">
	<div class="col-12">

		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Men&uacute;</h3>
			</div>
			<div class="card-body">

				<form id="add-item" class="d-flex flex-row flex-wrap gap-1 w-100">
					<input class="form-control flex-fill w-auto" type="text" name="name" placeholder="Name">
					<input class="form-control flex-fill w-auto" type="text" name="url" placeholder="Url">
					<input class="form-control flex-fill w-auto" type="text" name="controller" placeholder="Identificador">
					<input class="form-control flex-fill w-auto" type="text" name="icon" placeholder="Icono" value="far fa-circle nav-icon">
					<select class="form-control flex-fill w-auto" name="state">
						<option value="on">Visible</option>
						<option value="off">Invisible</option>
					</select>
					<button class="btn btn-primary w-auto" type="submit">Añadir menu</button>
				</form>
			
				<hr />

				@php 
					echo menu_drag_sort();
				@endphp


				<div class="clearfix"></div>
				
				<hr />

				<form action="/menu" method="post" class="d-block w-100 mt-2" id="save-menu">
					<input type="hidden" id="nestable-output" name="menu">
					<button type="submit" class="btn btn-primary">Guardar Menu</button>
				</form>

			</div>

		</div>

	</div>
</div>

@endsection

@section('scripts')
<script src="public/plugins/LibDataTables/datatables.min.js"></script>
<script src="public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script src="@asset("js/jquery.nestable.js")"></script>
<script type="text/javascript">
	$(document).ready(function () {

		var updateOutput = function () {
			$('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
		};

		$('#nestable').nestable({group : 0}).on('change', updateOutput);

		updateOutput();

		$("#add-item").submit(function (e) {
			e.preventDefault();
			id = Date.now();
			let label = $("#add-item > [name='name']").val();
			let url = $("#add-item > [name='url']").val();
			let controller = $("#add-item > [name='controller']").val();
			let icon = $("#add-item > [name='icon']").val();
			let state = $("#add-item > [name='state']").val();
			if ((url == "") || (label == "") || (controller == "")) return;
			let item =
				'<li class="dd-item dd3-item" data-id="' + id + '" data-label="' + label + '" data-url="' + url + '" data-controller="' + controller + '" data-icon="'+ icon +'" data-state="'+ state +'">' +
				'<div class="dd-handle dd3-handle" > Drag</div>' +
				'<div class="dd3-content"><span>' + label + '</span>' +
				'<div class="item-edit">Edit</div>' +
				'</div>' +
				'<div class="item-settings d-none">' +
				'<p><label for="">Navigation Label<br><input type="text" name="navigation_label" value="' + label + '"></label></p>' +
				'<p><label for="">Navigation Url<br><input type="text" name="navigation_url" value="' + url + '"></label></p>' +
				'<p><label for="">Navigation ID<br><input type="text" name="navigation_controller" value="' + controller + '"></label></p>' +
				'<p><label for="">Navigation Icono<br><input type="text" name="navigation_icon" value="' + icon + '"></label></p>' +
				`<p><label for="">Navigation Estado<br>
					<select name="navigation_state">
						<option value="on" ${state=="on"?'selected':''}>Visible</option>
						<option value="off" ${state=="off"?'selected':''}>Invisble</option>
					</select>	
				</p>` +
				'<p><a class="item-delete" href="javascript:;">Remove</a> |' +
				'<a class="item-close" href="javascript:;">Close</a></p>' +
				'</div>' +
				'</li>';

			$("#nestable > .dd-list").append(item);
			$("#nestable").find('.dd-empty').remove();
			$("#add-item > [name='name']").val('');
			$("#add-item > [name='url']").val('');
			$("#add-item > [name='controller']").val('');
			$("#add-item > [name='state']").val('');
			updateOutput();
		});

		$("body").delegate(".item-delete", "click", function (e) {
			$(this).closest(".dd-item").remove();
			updateOutput();
		});


		$("body").delegate(".item-edit, .item-close", "click", function (e) {
			var item_setting = $(this).closest(".dd-item").find(".item-settings");
			if (item_setting.hasClass("d-none")) {
				item_setting.removeClass("d-none");
			} else {
				item_setting.addClass("d-none");
			}
		});

		$("body").delegate("input[name='navigation_label']", "change paste keyup", function (e) {
			$(this).closest(".dd-item").data("label", $(this).val());
			$(this).closest(".dd-item").find(".dd3-content span").text($(this).val());
		});

		$("body").delegate("input[name='navigation_url']", "change paste keyup", function (e) {
			$(this).closest(".dd-item").data("url", $(this).val());
		});
		
		$("body").delegate("input[name='navigation_controller']", "change paste keyup", function (e) {
			$(this).closest(".dd-item").data("controller", $(this).val());
		});

		$("body").delegate("input[name='navigation_icon']", "change paste keyup", function (e) {
			$(this).closest(".dd-item").data("icon", $(this).val());
		});

		$("[name='navigation_state']").on('change', function (e) {
			$(this).closest(".dd-item").data("state", $(this).val());
		})

	});
</script>
@endsection