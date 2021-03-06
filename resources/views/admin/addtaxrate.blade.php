@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddTaxRate') }} <small>{{ trans('labels.AddTaxRate') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/taxrates')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.ListingAllTaxRates') }}</a></li>
      <li class="active">{{ trans('labels.AddTaxRate') }}</li>
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
            <h3 class="box-title">{{ trans('labels.AddTaxRate') }}</h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
          <div class="row">
              <div class="col-xs-12">              		
				  @if (count($errors) > 0)
					  @if($errors->any())
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  {{$errors->first()}}
						</div>
					  @endif
				  @endif
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
              	  <div class="box box-info"><br>
                                   
                       	@if(count($result['message'])>0)
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						 {{ $result['message'] }}
						</div>						
						@endif 
						
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/addnewtaxrate', 'method'=>'post', 'class' => 'form-horizontal  form-validate', 'enctype'=>'multipart/form-data')) !!}
                            
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }}
                                </label>
								<div class="col-sm-10 col-md-4">
                                	<select name="tax_class_id" class="form-control">
                                    @foreach($result['tax_class'] as $tax_class)
                                    	<option value="{{ $tax_class->tax_class_id }}"> {{ $tax_class->tax_class_title }}</option>
                                    @endforeach
                                    </select>
                                	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                	{{ trans('labels.ChooseTaxClass') }}</span>
								</div>
							</div>
                            
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zone') }}
                                </label>
								<div class="col-sm-10 col-md-4">
                                	<select name="tax_zone_id" class="form-control">
                                    @foreach($result['zones'] as $zones)
                                    	<option value="{{ $zones->zone_id }}"> {{ $zones->zone_name }}</option>
                                    @endforeach
                                    </select>
                               		<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRateText') }}</span>
								</div>
							</div>
                            
                            <div class="form-group" style="margin-top: -15px;">
								<label for="name" style="margin-top: 26px;" class="col-sm-2 col-md-3 control-label">GST Rate (%)
                                </label>
                                <div class="col-sm-10 col-md-2" style="margin-top: 27px;">
                                    <input type="text"
                                           name="tax_rate"
                                           id="tax_rate"
                                           minlength="1"
                                           maxlength="2"
                                           onkeyup="ratecalc();"
                                           class="form-control number-validate">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>
                                    <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                </div>
                                <div class="col-sm-10 col-md-2" id="cgst_id">
                                    <label for="cgst" class="control-label">CGST </label>
                                    <input type="text"
                                           name="cgst"
                                           id="cgst"
                                           {{--readonly="readonly"--}}
                                           class="form-control number-validate">
                                    {{--{!! Form::text('cgst',  '', array('class'=>'form-control number-validate', 'id'=>'cgst'))!!}--}}
                                    {{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>--}}
                                    <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                </div>
                                <div class="col-sm-10 col-md-2">
                                    <label for="sgst" class="control-label">SGST
                                    </label>
                                    <input type="text"
                                           name="sgst"
                                           id="sgst"
                                           readonly="readonly"
                                           class="form-control number-validate">
{{--                                    {!! Form::text('sgst',  '', array('class'=>'form-control number-validate', 'id'=>'sgst'))!!}--}}
                                    {{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>--}}
                                    <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                </div>
                                <div class="col-sm-10 col-md-2" id="igst_id">
                                    <label for="igst" class="control-label">IGST
                                    </label>
                                    <input type="text"
                                           name="igst"
                                           id="igst"
                                           {{--readonly="readonly"--}}
                                           class="form-control number-validate">
{{--                                    {!! Form::text('igst',  '', array('class'=>'form-control number-validate', 'id'=>'igst'))!!}--}}
                                    {{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>--}}
                                    <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                </div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}
                                </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::textarea('tax_description',  '', array('class'=>'form-control', 'id'=>'tax_description'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TaxDescription') }}</span>
								</div>
							</div>							
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<button type="submit" class="btn btn-primary">{{ trans('labels.AddTaxRate') }}</button>
								<a href="{{ URL::to('admin/taxrates')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
    <script>
        $(function () {
            $('#sgst').val(0);
            $('#cgst').val(0);
            $('#igst').val(0);
        });
        function ratecalc()
        {
            var tax = $('#tax_rate').val();
            var cgst = $('#cgst').val();
            var sgst = $('#sgst').val();
            var igst = $('#igst').val();

            var temp = parseFloat(tax/2);
            $('#sgst').val(temp);
            $('#cgst').val(temp);
            $('#igst').val(0);
            if(tax == '' || tax == 0)
            {
                $('#sgst').val(0);
                $('#cgst').val(0);
                $('#igst').val(0);
            }
        }
    </script>
@endsection 