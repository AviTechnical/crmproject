@extends('admin.master')
@section('content')

@section('title')
    @if (isset($editModeData))
        @lang('paygrade.edit_hourly_pay_grade')
    @else
        @lang('paygrade.add_hourly_pay_grade')
    @endif
@endsection
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
            <a href="{{ route('hourlyWages.index') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i
                    class="fa fa-list-ul" aria-hidden="true"></i> @lang('paygrade.view_hourly_pay_grade') </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if (isset($editModeData))
                            {{ Form::model($editModeData, ['route' => ['hourlyWages.update', $editModeData->hourly_salaries_id], 'method' => 'PUT', 'files' => 'true', 'class' => 'form-horizontal ajaxFormSubmit', 'id' => 'hourlyWagesForm', 'data-redirect' => route('hourlyWages.index')]) }}
                        @else
                            {{ Form::open(['route' => 'hourlyWages.store', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal ajaxFormSubmit', 'id' => 'hourlyWagesForm', 'data-redirect' => route('hourlyWages.index')]) }}
                        @endif

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">@lang('paygrade.pay_grade_name')<span
                                                class="validateRq">*</span></label>
                                        <div class="col-md-8">
                                            {!! Form::text(
                                                'hourly_grade',
                                                Input::old('hourly_grade'),
                                                $attributes = [
                                                    'class' => 'form-control required hourly_grade',
                                                    'id' => 'hourly_grade',
                                                    'placeholder' => __('paygrade.pay_grade_name'),
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">@lang('paygrade.hourly_rate')<span
                                                class="validateRq">*</span></label>
                                        <div class="col-md-8">
                                            {!! Form::number(
                                                'hourly_rate',
                                                Input::old('hourly_rate'),
                                                $attributes = [
                                                    'class' => 'form-control required hourly_rate',
                                                    'id' => 'hourly_rate',
                                                    'placeholder' => __('paygrade.hourly_rate'),
                                                    'min' => '0',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn btn-info btn_style">
                                                <i
                                                    class="fa @if (isset($editModeData)) fa-pencil @else fa-check @endif"></i>
                                                @lang('common.' . (isset($editModeData) ? 'update' : 'save'))
                                            </button>
                                        </div>
                                    </div>
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
