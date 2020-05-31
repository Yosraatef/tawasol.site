@extends('admin.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         اضافة كود وظيفي جديد
      </h1>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('codes.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                <div class="form-group">
                  <label for="code">الكود</label>
                  <input type="text" class="form-control" name="code" id="code" placeholder="اضافة كود">
                </div>
                 <div class="form-group">
                  <label for="name">الاسم</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="اضافة اسم المستخدم">
                </div>
                 <div class="form-group">
                  <label for="phone">رقم التلفون</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="اضافة رقم التلفون">
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" href="{{ route('codes.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection