@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.EditTaxRate') }} <small>{{ trans('labels.EditTaxRate') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/taxrates')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.TaxRates') }}</a></li>
      <li class="active">{{ trans('labels.EditTaxRate') }}</li>
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
            <h3 class="box-title">{{ trans('labels.EditTaxRate') }}</h3>
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
						
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/updatetaxrate', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            {!! Form::hidden('id', $result['taxClass'][0]->tax_rates_id, array('class'=>'form-control', 'id'=>'tax_rate'))!!}
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }}  </label>
								<div class="col-sm-10 col-md-4">
                                	<select name="tax_class_id" class="form-control">
                                    @foreach($result['tax_class'] as $tax_class)
                                    	<option 
                                        	@if($result['taxClass'][0]->tax_class_id == $tax_class->tax_class_id)
                                            	selected
                                            @endif
                                         value="{{ $tax_class->tax_class_id }}"> {{ $tax_class->tax_class_title }}</option>
                                    @endforeach
                                    </select>
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseTaxClass') }}</span>
								</div>
							</div>
                            
                            <div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zone') }}
                                </label>
								<div class="col-sm-10 col-md-4">
                                	<select name="tax_zone_id" class="form-control">
                                    @foreach($result['zones'] as $zones)
                                    	<option 
                                         @if($result['taxClass'][0]->tax_zone_id == $zones->zone_id)
                                            	selected
                                         @endif
                                         value="{{ $zones->zone_id }}"> {{ $zones->zone_name }}</option>
                                    @endforeach
                                    </select>
                                	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRateText') }}</span>
								</div>
							</div>
                            
                            {{--<div class="form-group">--}}
								{{--<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AddTaxRatePercentage') }}--}}
                                {{--</label>--}}
								{{--<div class="col-sm-10 col-md-4">--}}
									{{--{!! Form::text('tax_rate',  $result['taxClass'][0]->tax_rate, array('class'=>'form-control number-validate', 'id'=>'tax_rate'))!!}--}}
                                	{{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>--}}
                                    {{--<span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>--}}
								{{--</div>--}}
							{{--</div>--}}

                             {{----}}
                             <div class="form-group" style="margin-top: -15px;">
                                 <label for="name" style="margin-top: 26px;" class="col-sm-2 col-md-3 control-label">GST Rate (%)
                                 </label>
                                 <div class="col-sm-10 col-md-2" style="margin-top: 27px;">
                                     <input type="text"
                                            name="tax_rate"
                                            id="tax_rate_gst"
                                            minlength="1"
                                            maxlength="2"
                                            onkeyup="ratecalc();"
                                            value="{{$result['taxClass'][0]->tax_rate}}"
                                            class="form-control number-validate">
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>
                                     <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                 </div>
                                 <div class="col-sm-10 col-md-2" id="cgst_id">
                                     <label for="cgst" class="control-label">CGST </label>
                                     <input type="text"
                                            name="cgst"
                                            id="cgst"
                                            value="{{$result['taxClass'][0]->cgst}}"
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
                                            value="{{$result['taxClass'][0]->sgst}}"
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
                                            value="{{$result['taxClass'][0]->igst}}"
                                            {{--readonly="readonly"--}}
                                            class="form-control number-validate">
                                     {{--                                    {!! Form::text('igst',  '', array('class'=>'form-control number-validate', 'id'=>'igst'))!!}--}}
                                     {{--<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>--}}
                                     <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                 </div>
                             </div>
                             {{----}}


							<div class="form-group">
								<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}
                                </label>
								<div class="col-sm-10 col-md-4">
									{!! Form::textarea('tax_description',  $result['taxClass'][0]->tax_description, array('class'=>'form-control', 'id'=>'tax_description'))!!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TaxDescription') }}</span>
								</div>
							</div>							
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
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
    function ratecalc()
    {
        var tax = parseFloat($('#tax_rate_gst').val());
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
        if(cgst == '' || cgst == 0)
        {
            $('#igst').val(sgst);
        }
    }
</script>
@endsection 