@php
    $array = new StdClass;
    $storage = isset($storage) && !empty($storage)? $storage:null;
        if(isset($storage) && !empty($storage) ) $array->storage = $storage;

    $id = isset($id) && !empty($id)? $id : "user_id";
        if(isset($id) && !empty($id) ) $array->id = $id;
    
    $json = json_encode($array, true);
@endphp
<select name="{{ $id }}" id="{{ $id }}" class="form-control selectpicker user-search {{ $id }}" data-live-search="true" title="Buscar por Nombre o nombre comercial"></select>
<script>
    window.addEventListener("load", (event) => {
        userSearch({!! $json !!});
    });
</script>