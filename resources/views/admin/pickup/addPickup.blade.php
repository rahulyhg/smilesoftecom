@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.AddPickup') }}
                <small>{{ trans('labels.AddPickup') }}...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="listingPickups"><i class="fa fa-dashboard"></i>{{ trans('labels.ListingAllPickup') }}</a>
                </li>
                <li class="active">{{ trans('labels.AddPickup') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.AddPickup') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info"><br>

                                        @if(count($result['message'])>0)

                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                {{ $result['message'] }}
                                            </div>
                                    @endif

                                    <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/addNewPickup', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            <div class="form-group">
                                                <label for="name"
                                                       class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="city_id" class='form-control'>
                                                        @foreach( $result['countries'] as $countries_data)
                                                            <option value="{{ $countries_data->countries_id }}"> {{ $countries_data->countries_name }} </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block"
                                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                   {{ trans('labels.ChooseZoneCountry') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name"
                                                       class="col-sm-2 col-md-3 control-label">{{ trans('labels.ShopAddress') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('shop_address',  '', array('class'=>'form-control field-validate', 'id'=>'shop_address'))!!}
                                                    <span class="help-block"
                                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                   {{ trans('labels.ShopAddressText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>

                                            {{--<div class="form-group">--}}
                                            {{--<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ZoneCode') }}--}}
                                            {{--</label>--}}
                                            {{--<div class="col-sm-10 col-md-4">--}}
                                            {{--{!! Form::text('zone_code',  '', array('class'=>'form-control  field-validate', 'id'=>'zone_code'))!!}--}}
                                            {{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">--}}
                                            {{--{{ trans('labels.ZoneCodeText') }}</span>--}}
                                            {{--<span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}


                                        <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit"
                                                        class="btn btn-primary">{{ trans('labels.AddPickup') }}</button>
                                                <a href="listingPickups" type="button"
                                                   class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>
                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection 