@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Pickups') }} <small>  {{ trans('labels.ListingAllPickup') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active"> {{ trans('labels.Pickups') }}</li>
    </ol>
  </section>
  
  <!--  content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.ListingAllPickup') }} </h3>
            <div class="box-tools pull-right">
            	<a href="addPickup" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddPickup') }}</a>
            </div>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID{{--{{ trans('labels.ID') }}--}}</th>
                      <th>Shop Address{{--{{ trans('labels.Zone') }}--}}</th>
                      {{--<th>{{ trans('labels.Code') }}</th>--}}
                      <th>City{{--{{ trans('labels.Country') }}--}}</th>
                      <th>Address{{--{{ trans('labels.Action') }}--}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($result['pickup_points'] as $key=>$zones)
                        <tr>
                            <td>{{ $zones->id }}</td>
                            <td>{{ $zones->shop_address }}</td>
{{--                            <td>{{ $zones->zone_code }}</td>--}}
                            <td>{{ $zones->countries_name }}</td>
                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editPickup/{{ $zones->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a  data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deletezoneId" zone_id ="{{ $zones->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$result['pickup_points']->links('vendor.pagination.default')}}
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
        <!-- deleteZoneModal -->
	<div class="modal fade" id="deleteZoneModal" tabindex="-1" role="dialog" aria-labelledby="deleteZoneModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteZoneModalLabel">{{ trans('labels.DeletePickup') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deletePickup', 'name'=>'deletePickup', 'id'=>'deletePickup', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'pickup_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeletePickupText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Cancel') }}</button>
			<button type="submit" class="btn btn-primary" id="deletePickup">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    
    <!--  row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 