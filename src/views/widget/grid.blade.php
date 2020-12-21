@extends('admin::layouts.app')

@section('content')
<div class="container-fluid grid">
    <div class="row pt-2 pb-2">
        <div class="col-sm-9"><h4 class="page-title">{{ $grid->getTitle() }}</h4></div>
        <div class="col-sm-3">
            <div class="btn-group float-sm-right">
            @foreach ($grid->getButtons() as $data)
                @includeIf('admin::widget.button', $data)
            @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total {{ $grid->getCollection()->total() }} records found</h5>
                    <div class="table-responsive">
                        <form action="{{ $grid->getGridUrl() }}" method="get">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        @foreach ($grid->getColumns() as $index => $column)
                                        <th class="align-top">
                                            <strong>{{ $column['label'] }}</strong>
                                            @if($column['sortable'])
                                            <button type="button" class="btn btn-light m-1 float-sm-right order btn-sm">
                                                @if($grid->getOrderBy() == $index && $grid->getDirection() == 'desc')
                                                    <i class="fa fa-long-arrow-down" data-sort-by="{{ $index }}" data-direction="asc"></i>
                                                @elseif($grid->getOrderBy() == $index && $grid->getDirection() == 'asc')
                                                    <i class="fa fa-long-arrow-up" data-sort-by="{{ $index }}" data-direction="desc"></i>
                                                @else
                                                    <i class="fa fa-arrows-v" data-sort-by="{{ $index }}" data-direction="desc"></i>
                                                @endif
                                            </button>
                                            @endif
                                        </th>
                                        @endforeach
                                        <th class="align-top" width="10%">Actions</th>
                                    </tr>
                                    <tr>
                                        @foreach ($grid->getColumns() as $index => $column)
                                        <th>
                                            @if ($grid->isColumnFilterable($index))
                                                @switch($column['type'])
                                                    @case('select')
                                                        <select class="form-control" name="{{ $index }}">
                                                            <option value="">Please Select</option>
                                                            @foreach($grid->getColumnSourceModel($column)->getOptions() as $value => $label)
                                                            <option value="{{ $value }}" 
                                                                @if (strlen($grid->getRequest($index)) && $grid->getRequest($index) == $value)
                                                                selected="selected"
                                                                @endif
                                                            >
                                                                {{ is_array($label) ? $label['label'] : $label }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @break
                                                    @case('text')
                                                        <input type="text" name="{{ $index }}" class="form-control" value="{{ $grid->getRequest($index) }}" />
                                                        @break
                                                @endswitch
                                            @endif
                                        </th>
                                        @endforeach
                                        <th>
                                            <button type="submit" class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                <i class="fa fa-check-circle"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="setLocation('{{ $grid->getGridUrl() }}');">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($grid->getCollection()->count())
                                    @foreach ($grid->getCollection() as $instance)
                                    <tr>
                                        @foreach ($grid->getColumns() as $index => $column)
                                        <td>
                                            @switch($column['type'])
                                                @case('image')
                                                    <img src="{{ $instance->getAttributeUrl($index) }}" width="75" />
                                                    @break
                                                @case('date')
                                                    {{ $instance->getAttribute($index) ? $instance->getAttribute($index)->format(!empty($column['options']['format']) ? $column['options']['format'] : 'd M Y') : false }}
                                                    @break
                                                @case('select')
                                                    {{ $grid->getColumnSourceModel($column)->getOptionLabel($instance->getAttribute($index)) }}
                                                    @break
                                                @case('multiselect')
                                                    @foreach($instance->getAttribute($index) as $_value)
                                                        {{ $grid->getColumnSourceModel($column)->getOptionLabel($_value) }}
                                                        <br />
                                                    @endforeach
                                                    @break
                                                @case('text')
                                                @default
                                                    <p style="white-space: normal;">{{ $instance->getAttribute($index) }}</p>
                                            @endswitch
                                        </td>
                                        @endforeach
                                        <td>
                                            @foreach ($grid->getActions() as $data)
                                                @php
                                                    $data['action'] = route($data['route'], ['id' => $instance->id]);
                                                    $data['hide_label'] = true;
                                                @endphp
                                                @includeIf('admin::widget.button', $data)
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ count($grid->getColumns()) + 1 }}">There no items found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <input type="hidden" name="order_by" value="{{ $grid->getOrderBy() }}" />
                            <input type="hidden" name="direction" value="{{ $grid->getDirection() }}" />
                            <input type="hidden" name="data" value="" />
                        </form>
                    </div>
                </div>
            </div>

            {{ $grid->pagination() }}

        </div>
    </div>
</div>
@includeIf('admin::widget.confirmation')

@endsection