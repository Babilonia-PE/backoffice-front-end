@php
    $storage = isset($storage) && !empty($storage)? $storage:'';
@endphp
<select name="user_id" id="user_id" class="form-control selectpicker user-search" data-live-search="true" title="Buscar por Nombre o nombre comercial"></select>
<script>
    window.addEventListener("load", (event) => {
        userSearch({
            storage : '{{ $storage }}'
        });
    });
</script>