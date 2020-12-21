@php
$format = !empty($format) ? $format : 'Y-m-d';
@endphp
<input 
    @if(!empty($id))
    id="{{ $id }}" 
    @endif
    type="text" 
    name="{{ $name }}" 
    class="form-control" 
    value="{{ $value instanceof \Illuminate\Support\Carbon ? $value->format($format) : $value }}"
    data-type="datepicker"
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly
    disabled
    @endif
/>
@php
$format = str_replace('Y', 'yyyy', $format);
$format = str_replace('m', 'mm', $format);
$format = str_replace('d', 'dd', $format);
@endphp
<script type="text/javascript">
$(function() {
    $('input[name="{{ $name }}"]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{ $format }}'
    });
});
</script>