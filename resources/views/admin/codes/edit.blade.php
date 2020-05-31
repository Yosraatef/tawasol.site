@extends('admin.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          تعديل الكود الوظيفي
      </h1>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('codes.update',$code->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                <div class="form-group">
                  <label for="code">الكود</label>
                  <input type="text" class="form-control" name="code" id="code" value="{{$code->code}}" placeholder="اضافة الكود">
                </div>
                 <div class="form-group">
                  <label for="name">اسم المستخدم</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{$code->name}}" placeholder="اضافة اسم المستخدم">
                </div>
                 <div class="form-group">
                  <label for="phone">رقم التلفون</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{$code->phone}}" placeholder="اضافة رقم التلفون">
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" href="{{ route('codes.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection