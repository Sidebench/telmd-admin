@php
    $gridName = $name;
    $gridName = str_replace('[', '_', str_replace(']', '_', $gridName));
@endphp
<table class="table table-bordered mg-b-0" id="{{$gridName}}">
    <thead>
        <tr>
            @foreach($columns as $fieldName => $data)
            <th @if($data['type'] == 'textarea') style="min-width:230px;" @endif>{{$data['label']}}</th>
            @endforeach
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @if(is_array($value) || $value instanceof \Illuminate\Support\Collection)
        @foreach($value as $index => $entity)
            @php
                $entity = is_array($entity) ? (object) $entity : $entity;
            @endphp
            <tr data-row-number="{{$index + 1}}">
                @foreach($columns as $fieldName => $data)
                <td>
                    @switch($data['type'])
                        @case('select')
                            <select class="form-control" name="{{$name}}[{{$index}}][{{$fieldName}}]" 
                            @if(!empty($data['required']))
                                required
                            @endif
                            >
                            @if(empty($data['required']))
                                <option value="">{{ __('Please select') }}</option>
                            @endif
                            @foreach($data['source']->getOptions() as $value => $label)
                                <option value="{{ $value }}" @if(isset($entity->$fieldName) && $entity->$fieldName == $value) selected="selected" @endif>{{ $label }}</option>
                            @endforeach
                            </select>
                            @break
                        @case('text')
                            <input class="form-control" name="{{$name}}[{{$index}}][{{$fieldName}}]" type="{{$data['type']}}" value="{{ !empty($entity->$fieldName) ? $entity->$fieldName : '' }}" 
                            @if(!empty($data['required']))
                                required
                            @endif
                            />
                            @break;
                        @case('textarea')
                            <textarea rows="7" class="form-control" name="{{$name}}[{{$index}}][{{$fieldName}}]"  
                            @if(!empty($data['required']))
                                required
                            @endif
                            >{{ !empty($entity->$fieldName) ? $entity->$fieldName : '' }}</textarea>
                            @break;
                        @case('file')
                            <input type="hidden" name="{{$name}}[{{$index}}][{{$fieldName}}]" value="{{ !empty($entity->$fieldName) ? $entity->$fieldName : '' }}" />
                            <input class="form-control" name="{{$name}}[{{$index}}][{{$fieldName}}][file]" type="{{$data['type']}}" 
                                @if(!empty($data['required']) && empty($entity->$fieldName))
                                    required
                                @endif
                            />
                            @if(!empty($entity->$fieldName))
                            <img src="{{ method_exists($entity, 'getAttributeUrl') ? $entity->getAttributeUrl($fieldName) : asset($entity->$fieldName) }}" width="50" />
                            @endif
                            @break;
                    @endswitch
                </td>
                @endforeach
                <td width="5%">
                    <input type="hidden" name="{{$name}}[{{$index}}][id]" value="{{!empty($entity->id) ? $entity->id : $index}}" />
                    <a href="javascript:void(0)" class="btn btn-danger ml-2 btn-sm remove"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{count($columns)}}"></td>
            <td><a href="javascript:void(0)" onclick="{{$gridName}}_Rows.addRow();" class="btn btn-success ml-2 btn-sm add"><i class="fa fa-plus-circle"></i></a></td>
        </tr>
    </tfoot>
</table>
<script id="{{$gridName}}-row-template" type="template/html">
<tr data-row-number="{index}">
    @foreach($columns as $fieldName => $data)
    <td>
        @switch($data['type'])
            @case ('file')
            <input class="form-control" name="{{$name}}[{index}][{{$fieldName}}][file]" type="{{$data['type']}}" value="" 
                @if(!empty($data['required']))
                    required
                @endif
                />
            @break;
            @case ('text')
                <input class="form-control" name="{{$name}}[{index}][{{$fieldName}}]" type="{{$data['type']}}" value="" 
                @if(!empty($data['required']))
                    required
                @endif
                />
            @break;
            @case('textarea')
                <textarea rows="7" class="form-control" name="{{$name}}[{index}][{{$fieldName}}]" 
                @if(!empty($data['required']))
                    required
                @endif
                ></textarea>
            @break;
            @case('select')
                <select class="form-control" name="{{$name}}[{index}][{{$fieldName}}]" 
                @if(!empty($data['required']))
                    required
                @endif
                >
                @if(empty($data['required']))
                    <option value="">{{ __('Please select') }}</option>
                @endif
                @foreach($data['source']->getOptions() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
                </select>
            @break
        @endswitch
    </td>
    @endforeach
    <td>
        <a href="javascript:void(0)" class="btn btn-danger ml-2 btn-sm remove"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>
</script>
<script type="text/javascript">
// <![CDATA[
var {{$gridName}}_Rows = {
    datepickerOptions : {
        showOtherMonths: true,
        selectOtherMonths: true
    },
    initialized: false,
    timepickerOptions : { 'step': 15 },
    init : function() {
        var self = this;
        this.currentRowNumber = $('#{{$gridName}} tbody tr').last().data('row-number') || 0;
        $('#{{$gridName}} a.remove').click(this.removeRow.bind(this));
    },
    addRow : function(event) {
        console.log('OK');
        this.currentRowNumber++;
        var row = $('#{{$gridName}}-row-template').html().replaceAll('{index}', this.currentRowNumber);
        row = $(row);
        row.find('a.remove').click(this.removeRow.bind(this));
        $('#{{$gridName}} tbody').append(row);
    },
    removeRow : function(event) {
        $(event.target).parents('tr').remove();
    },
};
{{$gridName}}_Rows.init();
// ]]>
</script>