@extends('admin.index')



@section('content')
    <h2>تعديل المديرين </h2>

    <div class="col-sm-6">

        <form action="{{route('admin.users.update',$user->id)}}" method="POST" enctype="multipart/form-data" >


            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">الايميل</label>
                <input type="email" name="email"
                       value="{{$user->email}}"
                       placeholder="ادخل البريد الالكتروني"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="name">الرقم السري</label>
                <input type="password" name="password"
                       value="{{$user->password}}"
                       placeholder="ادخل الرقم السري"
                       class="form-control">
            </div>

           
            <div  class="form-group ">
                  <input id="is_manger" class="is_manger" value="1" type="checkbox" name="is_manger" @if($user->type == 2) {{'checked'}} @endif>
                  <label for="is_manger">رئيس</label>
                  
            </div>
            <div class="section_id" class="form-group " >
                <label for="section_id">اسم القسم</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="section_id">
                  <option value="">اختر القسم المناسب</option>
                  @foreach($sections as $section)
                    <option value="{{$section->id}}"
                       @if($user->section_id == $section->id)
                     selected
                  @endif>{{ $section->name}}</option >
                  @endforeach
                </select>
            </div>
             <div class="section_id" class="form-group " >
                <label for="section_id">الكود الوظيفي</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="code_id">
                  <option value="">اختر الكود المناسب</option>
                  @foreach($codes as $code)
                    <option value="{{$code->id}}"
                     @if($user->code_id == $code->id)
                     selected
                  @endif>{{ $code->code}}</option>
                  @endforeach
                </select>
              </div>
              </br>
             <div  class="form-group image" >
                  <label for="image">الصورة الشخصية</label>
                  <input type="file" name="image" id="image">
                  <img style="height:120px;" 
                            src="{{asset('public/pictures/profile/'.$user->image) }}">
                </div>
            <br>
           
            <div class="form-group">
                <input type="submit"  value="تعديل" class="form-control">
            </div>


        </form>


    </div>


@endsection
@section('scripts')
<script>
        $(document).ready(function(){
            $('.is_manger').click(function(){
                if($(this).filter(":checked").val() == 1){
                    $(".section_id").show();
                }else{
                    $(".section_id").hide();

                }
                
            });
        });

    </script>
@endsection