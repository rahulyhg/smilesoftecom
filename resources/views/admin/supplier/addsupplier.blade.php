@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Add Supplier <small>Add Supplier...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/supplier')}}"><i class="fa fa-dashboard"></i>Supplier</a></li>
      <li class="active">Add Supplier</li>
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
            <h3 class="box-title">Add New Supplier </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <br>                       
                        @if (count($errors) > 0)
                              @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  {{$errors->first()}}
                                </div>
                              @endif
                          @endif
                        <!-- /.box-header -->
                        <!-- form start -->                        
                         <div class="box-body">
                            <form action="{{ url('admin/addnewsupplier') }}" method="post" id="insert_store">
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="" class="pull-left">Vendor Name *</label>
                                            <input type="text" name="name" autocomplete="off"
                                                   class="form-control required" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="" class="pull-left">Contact *</label>
                                            <input type="tel" name="contact" autocomplete="off"
                                                   class="form-control required nospc"
                                                   placeholder="Enter Mobile Number" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="address" class="pull-left">Full Address *</label>
                                            <input type="text"
                                                   name="address"
                                                   maxlength="25"
                                                   id="address"
                                                   autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Enter Vendor's Full Address" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="bank" class="pull-left">Bank Name *</label>
                                            <input type="text"
                                                   name="bank"
                                                   maxlength="25"
                                                   id="bank"
                                                   autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Enter Bank Name" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="account" class="pull-left">Bank Account Number *</label>
                                            <input type="text"
                                                   name="account"
                                                   maxlength="25"
                                                   id="account"
                                                   autocomplete="off"
                                                   class="form-control required nospc"
                                                   placeholder="Enter Account Number" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="gst_no" class="pull-left">GST Number *</label>
                                            <input type="text"
                                                   name="gst_no"
                                                   maxlength="20"
                                                   id="gst_no"
                                                   autocomplete="off"
                                                   class="form-control required nospc"
                                                   placeholder="Enter GST Number" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="amount" class="pull-left">Opening Amount *</label>
                                            <input type="text"
                                                   name="amount"
                                                   maxlength="8"
                                                   id="amount"
                                                   autocomplete="off"
                                                   class="form-control required nospc"
                                                   placeholder="Enter Opening Amount">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="" class="pull-left">Transaction Type *</label>
                                            <select name="ttype" id="ttype" class="form-control required">
                                                <option value="0">--Select Transaction Type--</option>
                                                <option value="Credit">Credit</option>
                                                <option value="Debit">Debit</option>
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary pull-left">Create Supplier &nbsp;<i
                                                        class="fa fa-users"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </form>
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