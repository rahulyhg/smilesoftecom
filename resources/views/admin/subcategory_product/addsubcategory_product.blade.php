@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Add Sub Category Products
            <small>Add Sub Category Products...</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/subcategoriesproduct')}}"><i class="fa fa-bars"></i>Sub Category Product</a></li>
            <li class="active">Add Subcategory Product</li>
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
                        <h3 class="box-title">Add Sub Category Product </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <br>
                                    @if (count($errors) > 0)
                                    @if($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    @endif
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/addnewsubcategoryproduct', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control typeDD requireDD"
                                                        name="parent_id"
                                                        id="parent_id"
                                                        onchange="category_change();">

                                                    <option value="0">Select Category</option>
                                                    @foreach ($result['categories'] as $categories)
                                                        <option value="{{$categories->mainId}}">{{$categories->mainName}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.ChooseMainCategory') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Sub Category</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control typeDD requireDD" name="sabcategory_id" id="subcatid">
                                                    <option value="0">Select Subcategory</option>
                                                    {{--Value are coming from Loop--}}
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.ChooseMainCategory') }}</span>
                                            </div>
                                        </div>

                                        @foreach($result['languages'] as $languages)

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $languages->name }})</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="categoryName_<?=$languages->languages_id?>" class="form-control field-validate">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                   {{ trans('labels.SubCategoryName') }} ({{ $languages->name }}).</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::file('newImage', array('id'=>'newImage')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.UploadSubCategoryImage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Icon') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::file('newIcon', array('id'=>'newIcon')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadSubCategoryIcon') }}</span>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">Add Subcategory Product</button>
                                            <a href="{{ URL::to('admin/subcategoriesproduct')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
            var subcategory_id = [];
            var subcategory_name = [];

            $(".typeDD").select2({
                placeholder: "Select"
            });

            $('input[name="parent_id"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
                maxYear: parseInt(moment().format('YYYY'), 10)
            });
            $('input[name="sabcategory_id"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
                maxYear: parseInt(moment().format('YYYY'), 10)
            });
        });

        function category_change()
        {
            var category_id = $('#parent_id').val();

            if (category_id == 0)
                location.reload();

            $.get('{{url('admin/category_change')}}', {category_id: category_id}, function (data)
            {
//                $('#parent_id').html(data);
                $('#subcatid').html('');
//                console.log(data);
                for (var i=0;i<data.length;i++)
                {
                    $strop = '<option value="0">Select Subcategory</option>';
                    $('#subcatid').append($strop);
                    $('#subcatid').append('<option value="' + data[i].mainId + '">' + data[i].mainName + '</option>');
                }
            });
        }
    </script>
@endsection