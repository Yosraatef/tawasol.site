@extends('admin.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        اضافة  موظف جديد 
      </h1>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('users.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

             

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             <div id="section_id" class="form-group " >
                <label for="section_id">الكود الوظيفي</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="code_id">
                  <option value="">اختر الكود المناسب</option>
                  @foreach($codes as $code)
                    <option value="{{$code->id}}">{{ $code->code}}</option>
                  @endforeach
                </select>
              </div>
            
               <div class="form-group">
                <label for="password">الرقم السري</label>
                <input type="password" name="password"
                       placeholder="ادخل الرقم السري"
                       class="form-control">
            </div>
               
            <div  class="form-group image" >
                  <label for="image">صورة الصفحة الشخصيه الخاصه بك</label>
                  <br>
                  <input type="file" name="image" id="image">
                </div>
            <div id="section_id" class="form-group " >
                <label for="section_id">اسم القسم</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="section_id">
                  <option value="">اختر القسم المناسب</option>
                  @foreach($sections as $section)
                    <option value="{{$section->id}}">{{ $section->name}}</option>
                  @endforeach
                </select>
              </div>
              
               
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('users.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection