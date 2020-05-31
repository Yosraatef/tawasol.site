@extends('admin.index')
@section('styles')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endsection
@section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         اضافة  مناسبة  جديدة
      </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('occasions.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                <div class="form-group">
                  <label for="name_owner">اسم صاحب المناسبة</label>
                  <input type="text" class="form-control" name="name_owner" id="name_owner  " placeholder="ادخل  اسم  صاحب  المناسبة">
                </div>
                <div class="form-group">
                  <label for="name_occasion">اسم  المناسبة</label>
                  <input type="text" class="form-control" name="name_occasion" 
                  id="name_occasion" placeholder="ادخل  اسم  المناسبة ">
                </div>

                 <div class="form-group">
                  <label for="date">تاريخ  المناسبة</label>
                  <input type="date" class="form-control" name="date" 
                  id="date" placeholder="ادخل  تاريخ  المناسبة ">
                </div>
                 <div class="form-group">
                  <label for="time">وقت  المناسبة</label>
                  <input type="time" class="form-control" name="time" 
                  id="time" placeholder="ادخل  وقت  المناسبة ">
                </div>
                @include('admin.partials.maps')
                 <div  class="form-group image" >
                  <label for="image">صورة المناسبة</label>
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
              <div id="user_id" class="form-group " >
                <label for="user_id">اسم  الموظف المسؤول  عن المناسبة</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="user_id">
                  <option value="">اختر  اسم  الموظف</option>
                  @foreach($users as $user)
                    <option value="{{$user->id}}">{{ $user->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group ">
                  <input id="is_public" class="privet" value="1" type="radio" name="is_public">
                  <label for="is_public"> للعامة </label>
                  
            </div>
            <div class="form-group ">
                  <input id="is_public" class="privet" value="0" type="radio" name="is_public">
                  <label for="is_public"> مناسبة خاصة للقسم  </label>
                  
            </div>
             <div class="form-group ">
                  <input id="privet" class="privet" value="2" type="radio" name="is_public">
                  <label for="is_public"> مناسبة خاصه للفرد  </label>
                  
            </div>
            <div class="form-group ">
                  <input id="is_public" class="privet" value="3" type="radio" name="is_public">
                  <label for="is_public"> المناسبة مرفوضة </label>
                  
            </div>
            <div  class="form-group invitation" style="display: none;">
             <strong> اختر الموظفين المدعوي</strong>
              <select  name="invitationUser_ids[]" id="multiple-checkboxes" multiple="multiple" data-live-search="true" >
                 
                  @foreach($users as $user)
                    <option value="{{$user->id}}">{{ $user->code_job}}</option>
                  @endforeach
              </select>
            </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" href="{{ route('section.index') }}">الرجوع</a>
               </div>
                </div>
              </div> 
            </form>
    @endsection
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#multiple-checkboxes').selectpicker();
        $('#multiple-checkboxes').multiselect({
           buttonWidth: '300px'
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('.privet').click(function(){
                if($(this).filter(":checked").val() == 2){
                    $(".invitation").show();
                }else{
                    $(".invitation").hide();

                }
                
            });
        });

    </script>
@endsection