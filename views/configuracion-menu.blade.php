@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
	
    /*
    @media(max-width: 575px) {
		div.dtsp-panesContainer div.dtsp-searchPanes div.dtsp-searchPane {
			max-width: 100%;
		}
    }
	.dtsp-searchPane:first-child {
		display: none;
	}*/
	div.dataTables_wrapper div.dataTables_processing {
		position: fixed;
		top: 30%!important;
		left: 50%;
		margin: 0;
		z-index: 999;
	}
    .dataTables_wrapper .dt-buttons{
        gap: .5rem;
    }
    .dataTables_wrapper .dataTables_length label{
        margin: .5rem;
    }
    .table td, .table th {
        padding: 0.3rem 0.5rem;
    }
	.dtr-bs-modal{
		padding: 0!important;
	}
	span.dtr-data {
		word-wrap: unset;
		overflow-wrap: anywhere;
		text-wrap: wrap;
	}
    @media(max-width: 575px) {
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
    }
	.box-details{
		display: flex;
		flex-direction: row;
		gap: 1rem;
		align-items: center;
    	padding: 0.3rem 0.5rem;
	}
	.box-details:not(:last-child) {
		border-bottom: 1px solid #dee2e6;
	}
	.box-details > div{
		overflow-wrap: anywhere;
	}
	.box-details > div:last-child {
		flex: 1;
	}
	.box-details > div:first-child {
		font-weight: 600;
	}
	.badge:is(.published,.not_published,.unpublished,.expired,.deleted){
		box-shadow: 2px 2px 17px 1px rgba(0, 0, 0, 0.2)
	}
	.badge.published{
		background-color: #198754;
		color: #ffffff;
	}
	.badge.not_published{
		background-color: #ffffff;
		color: #000000;
	}
	.badge.unpublished{
		background-color: #ff8300;
		color: #000000;
	}
	.badge.expired{
		background-color: #dc3545;
		color: #ffffff;
	}
	.badge.deleted{
		background-color: #000000;
		color: #ffffff;
	}
    @media(max-width: 400px) {
		.box-details{
			flex-direction: column;
			gap: 0rem;
			align-items: start;
        }
    }
</style>
@endsection

@section('page')

Configuración

@endsection

@section('content')
<div class="row">
	<div class="col-12">
        <div id="filter_box" class="card collapsed-card">
			<div class="card-header">
                <h5 class="card-title">Menú</h5>
                <div class="card-tools">
                  	<button type="button" class="btn btn-tool" data-card-widget="collapse">
                    	<i id="icon_filter_box" class="fas fa-plus"></i>
                  	</button>
                </div>
            </div>
            <div class="card-body">
				<div class="row align-items-end">
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Estado</label>
                  			<select class="form-control select2" id="state" style="width: 100%;">
								<option selected disabled value="">Elige una opción</option>
								<option value="published">Publicado</option>
								<option value="not_published">No publicado</option>
								<option value="unpublished">Despublicado</option>
								<option value="expired">Expirado</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de operación</label>
                  			<select class="form-control select2" id="listing_type" style="width: 100%;">
								<option selected disabled value="">Elige una opción</option>
								<option value="sale">Venta</option>
								<option value="rent">Alquiler</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de inmueble</label>
                  			<select class="form-control select2" id="property_type" style="width: 100%;">
								<option selected disabled value="">Elige una opción</option>
								<option value="apartment">Departamento</option>
								<option value="house">Casa</option>
								<option value="commercial">Local Comercial</option>
								<option value="office">Oficina</option>
								<option value="land">Terreno</option>
							</select>
                		</div>
                	</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Precio</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="price_from" placeholder="desde">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="price_to" placeholder="hasta">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de publicación</label>
							<div class="form-row">
								<div class="col-6">
									<input type="date" class="form-control" id="date_from" placeholder="Desde">
								</div>
								<div class="col-6">
									<input type="date" class="form-control" id="date_to" placeholder="Hasta">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<button id="applyfiltters" type="button" class="btn btn-primary btn-block"><i class="fas fa-filter"></i> Aplicar filtros</button>
								</div>
								<div class="col-auto">
									<button id="removefiltters" type="button" class="btn btn-secondary"><i class="fas fa-trash"></i></button>
								</div>
							</div>
						</div>
					</div>
                </div>
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
@endsection