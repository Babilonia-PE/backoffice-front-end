@extends('Layout.master')

@section('styles')

@endsection

@section('page')

Mi cuenta - {{ $data["fullname"]??'' }}

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        
        
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Detalle de usuario</h3>
			</div>
			<div class="card-body">

				<div class="card-body table-responsive">					
					<div class="row">
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <strong>Nombre completo:</strong> {{ $data["fullname"]??'' }}
                        </div>
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <strong>Username:</strong> {{ $data["username"]??'' }}
                        </div>
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <strong>Email:</strong> {{ $data["email"]??'' }}
                        </div>
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <strong>Celular:</strong> {{ $data["celular"]??'' }}
                        </div>
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <strong>DNI:</strong> {{ $data["dni"]??'' }}
                        </div>                          
                    </div>                    
				</div>
			</div>
			
		</div>

    </div>
</div>

@endsection

@section('scripts')

@endsection