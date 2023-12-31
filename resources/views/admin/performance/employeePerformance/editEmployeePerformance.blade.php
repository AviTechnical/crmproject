@extends('admin.master')
@section('content')
@section('title')
    @lang('performance.edit_employee_performance')
@endsection
<style>
    .table>tbody>tr>td {
        padding: 5px 7px;
    }
</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>
            </ol>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <a href="{{ route('employeePerformance.index') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i
                    class="fa fa-list-ul" aria-hidden="true"></i> @lang('performance.view_employee_performance') </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {{ Form::model($editModeData, ['route' => ['employeePerformance.update', $editModeData->employee_performance_id], 'method' => 'PUT', 'files' => 'true', 'id' => 'employeePerformance', 'class' => 'ajaxFormSubmit', 'data-redirect' => route('employeePerformance.index')]) }}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('common.employee_name')<span
                                                class="validateRq">*</span></label>
                                        <select name="employee_id" class="form-control employee_id required select2">
                                            <option value="">--- @lang('common.please_select') ---</option>
                                            @foreach ($employeeList as $value)
                                                <option value="{{ $value->employee_id }}"
                                                    @if ($value->employee_id == $editModeData->employee_id) {{ 'selected' }} @endif>
                                                    {{ $value->first_name }} {{ $value->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label for="exampleInput">@lang('common.month')<span class="validateRq">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input class="form-control required monthField" readonly="readonly"
                                            id="month" placeholder="@lang('common.month')" name="month" type="text"
                                            value="{{ $editModeData->month }}">
                                    </div>

                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('performance.remarks')</label>
                                        <textarea class="form-control" id="Remarks" placeholder="@lang('performance.remarks')" name="remarks">{{ $editModeData->remarks }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <h3 class="box-title">@lang('performance.criteria_list')</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="">
                                                <th class="col-md-4">@lang('performance.performance_category_list')</th>
                                                <th class="col-md-5">@lang('performance.performance_criteria_list') </th>
                                                <th class="col-md-3">@lang('performance.rating') (@lang('performance.out_of_ten'))</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($criteriaDataFormat as $key => $value)
                                        <tbody class="report_row">
                                            <tr>
                                                <td rowspan="{{ count($value) }}">{{ $key }}</td>
                                                <td> {{ $value[0]['performance_criteria_name'] }}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-star-o"></i></span>
                                                        <input type="number" name="rating[]" class="form-control"
                                                            placeholder="EX: 5" max="10"
                                                            value="{{ $value[0]['rating'] }}">
                                                        <input type="hidden" name="performance_criteria_id[]"
                                                            value="{{ $value[0]['performance_criteria_id'] }}">
                                                        <input type="hidden" name="employee_performance_details_id[]"
                                                            value="{{ $value[0]['employee_performance_details_id'] }}">
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach ($value as $k => $v)
                                                @if ($k != 0)
                                                    <tr>
                                                        <td>{{ $v['performance_criteria_name'] }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-star-o"></i></span>
                                                                <input type="number" name="rating[]"
                                                                    class="form-control" max="10"
                                                                    placeholder="Enter Rating"
                                                                    value="{{ $v['rating'] }}">
                                                                <input type="hidden" name="performance_criteria_id[]"
                                                                    value="{{ $v['performance_criteria_id'] }}">
                                                                <input type="hidden"
                                                                    name="employee_performance_details_id[]"
                                                                    value="{{ $v['employee_performance_details_id'] }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-info btn_style"> @lang('common.update') </button>
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script type="text/javascript">
    $(document).ready(function() {

        @php
            if (isset($editModeData->status)) {
                if ($editModeData->status == 1) {
                    echo "$('#employeePerformance').find('input').attr('readonly', true);";
                    echo "$('#employeePerformance').find('textarea').attr('readonly', true);";
                    echo "$('#employeePerformance').find('select').css('pointer-events', 'none');";
                    echo "$('#employeePerformance').find('#add').remove();";
                    echo "$('#employeePerformance').find('.btn-danger').remove();";
                    echo "$('#employeePerformance').find('.select2').prop('disabled', true);";
                    echo "$('#employeePerformance').find('#AutoComplete').prop('disabled', true);";
                }
            }
        @endphp

    });
</script>
@endsection
