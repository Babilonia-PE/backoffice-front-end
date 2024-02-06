@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/ColReorder-1.7.0/css/colReorder.dataTables.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
	table th,
	table td{
    	padding: 4px!important;
		vertical-align: middle!important;
	}
	.btn-action{
		border-radius: 0.6rem;
		padding: 0.5rem 0.8rem;
		border:1px solid #eeeeee;
		background: #fff;
		justify-content: center;
		width: max-content;
		font-size: 16px;
    	display: flex;
	}
	.btn-action.download{
		background: #28A745;
		color: #fff;
	}
</style>
@endsection

@section('page')

Reportes automáticos

@endsection

@section('content')
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
				<p class="text-center" name="loading"><img src="public/assets/img/loading.gif" width="50" /></p>
                <table class="display table table-bordered table-striped nowrap compact responsive d-none" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>N°</th>
							<th>Reporte</th>
							<th>Descripción</th>
							<th>Frecuencia</th>
							<th width="1%"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Agentes pagos VS Leads</td>
							<td>Reporte de agentes con paquetes pagados vs Leads generados</td>
							<td>Mes anterior</td>
							<td>
								<a href="{{ env('URL_WEB') }}assets/reports/agentsBuyedLeads.xlsx" download class="btn-action download">
									<i class="fas fa-download"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Agentes leads vs Distritos</td>
							<td>Reporte de agentes con paquetes pagados vs Cantidad de inmuebles en cada distrito</td>
							<td>Ayer</td>
							<td>
								<a href="{{ env('URL_WEB') }}assets/reports/agentsLeadsDitricts.xlsx" download class="btn-action download">
									<i class="fas fa-download"></i>
								</a>
							</td>
						</tr>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade p-0" id="rowDetails" tabindex="-1" role="dialog" aria-labelledby="rowDetailsLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title">Detalles para</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="box-details"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="public/plugins/LibDataTables/datatables.min.js"></script>
<script src="public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="public/plugins/LibDataTables/ColReorder-1.7.0/js/dataTables.colReorder.min.js"></script>
<script src="@asset("public/assets/js/components/datatableSimple.js")?v={{ APP_VERSION }}"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	const dom = 'rt';
	const options = {
		dom
	};
	
	datatable(options);
</script>
@endsection