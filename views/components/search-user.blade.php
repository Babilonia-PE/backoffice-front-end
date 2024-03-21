@php
    $array = new StdClass;
    $storage = isset($storage) && !empty($storage)? $storage:null;
        if(isset($storage) && !empty($storage) ) $array->storage = $storage;

    $id = isset($id) && !empty($id)? $id : "user_id";
        if(isset($id) && !empty($id) ) $array->id = $id;

    $placeholder = isset($placeholder) && !empty($placeholder)? $placeholder : "Buscar por Nombre o nombre comercial";
    $class = isset($class) && !empty($class)? $class: "";
    $json = json_encode($array, true);
@endphp
<select name="{{ $id }}" id="{{ $id }}" class="form-control selectpicker user-search {{ $id }} {{ $class }}" data-live-search="true" title="{{ $placeholder }}"></select>
@push('child-scripts')
    <script>
        window.addEventListener("load", (event) => {
            userSearch({!! $json !!});
        });
    </script>
@endpush