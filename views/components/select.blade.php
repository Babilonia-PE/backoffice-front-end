@php
    $data = isset($data) && !empty($data)? $data: [];
    $class = isset($class) && !empty($class)? $class: "";
    $id = isset($id) && !empty($id)? $id: "";
    $first = isset($first) && !empty($first)? $first: false;
    $n = 0;

    $data = unsetArray($data, 0, !$first);
    
@endphp
<select name="{{ $id }}" id="{{ $id }}" class="form-control select2 {{$class}}" title="{{ $placeholder }}" placeholder="{{ $placeholder }}" style="width: 100%;">
    <option selected disabled value="">Elige una opción</option>
    @foreach ($data as $k => $item)
        <option value="{{ $k }}">{{ $item }}</option>
    @endforeach
</select>
@php
 $n++;
@endphp