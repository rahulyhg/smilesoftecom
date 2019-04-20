@extends('admin.layout')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Supplier <small>supplier list...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">Supplier List</li>
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
            <h3 class="box-title">Supplier </h3>
            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/addsupplier') }}" type="button" class="btn btn-block btn-primary">Add Supplier</a>
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
                     <th>{{ ucwords('#') }}</th>
                     <th>{{ ucwords('name') }}</th>
                     <th>{{ ucwords('contact') }}</th>
                     <th>{{ ucwords('address') }}</th>
                     <th>{{ ucwords('bank') }}</th>
                     <th>{{ ucwords('account no') }}</th>
                     <th>{{ ucwords('G S T I N') }}</th>
                     <th>{{ ucwords('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($supplier)>0)
                    @foreach ($supplier  as $key=>$item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($item->name) }}</td>
                        <td>{{ $item->contact }}</td>
                        <td>{{ ucwords($item->address) }}</td>
                        <td>{{ ucwords($item->bank) }}</td>
                        <td>{{ $item->account }}</td>
                        <td>{{ $item->gst_no }}</td>
                        <td>
                            <a href="{{ url('admin/editsupplier').'/'.base64_encode($item->id)}}">
                                <button class="btn btn-success btn-sm">Edit</button>
                            </a>
                            <button onclick="del_vendor({{ $item->id }});"
                                    class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{-- {{$manufacturers->links('vendor.pagination.default')}} --}}
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
    
    <!-- deleteManufacturerModal -->
	<div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="deleteManufacturerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteManufacturerModalLabel">{{ trans('labels.DeleteManufacturer') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deletemanufacturer', 'name'=>'deleteManufacturer', 'id'=>'deleteManufacturer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('manufacturers_id',  '', array('class'=>'form-control', 'id'=>'manufacturers_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeleteManufacturerText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<script>
  $("#username").focusout(function () {
      var username = $('#username').val();
      $.get('{{ url('check_store_username') }}', {
          username: username
      }, function (data) {
          if (data == 'Not Available') {
              $('#username').val('');
              // return false;
              setTimeout(function () {
                  Swal.fire({
                      position: 'bottom',
                      title: 'Username Not Available',
                      showConfirmButton: false,
                      timer: 1200,
                      animation: false,
                      customClass: {
                          popup: 'animated fadeInDown'
                      }
                  })
              }, 500);
          }
          //     console.log(data);
          //    alert(data);
      });
  });

  function del_vendor(id) {
      Swal.fire({
          title: 'Are you sure?',
          text: "Delete This Store",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.value) {
              $.get('{{ url('admin/deletesupplier') }}', {
                  did: id
              }, function (data) {
                  // return false;
                  setTimeout(function () {
                      Swal.fire({
                          position: 'bottom',
                          title: 'Vendor information has Been Deleted',
                          showConfirmButton: false,
                          timer: 1200,
                          animation: false,
                          customClass: {
                              popup: 'animated fadeInDown'
                          }
                      })
                  }, 500);
                  setTimeout(function () {
                      location.reload();
                  }, 1000);

                  //     console.log(data);
                  //    alert(data);
              });
          }
      })
  }
</script>
@endsection 