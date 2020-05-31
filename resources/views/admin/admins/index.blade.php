@extends('admin.index')



@section('content')
    <h2>مسؤلي العلاقات العامة</h2>

    <div class="col-sm-6">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">

            @csrf

            
            <div class="form-group">
                <label for="name">الايميل</label>
                <input type="email" name="email"
                       placeholder="ادخل البريد الاكتروني "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="password">الرقم السري</label>
                <input type="password" name="password"
                       placeholder="ادخل الرقم السري"
                       class="form-control">
            </div>

            <div  class="form-group ">
                  <input id="type" class="type" value="2" type="checkbox" name="type">
                  <label for="type"> رئيس قسم </label>
                  
            </div>
           <div class="section_id" class="form-group " style="display: none;">
                <label for="section_id">اسم القسم</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="section_id">
                  <option value="">اختر القسم المناسب</option>
                  @foreach($sections as $section)
                    <option value="{{$section->id}}">{{ $section->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="section_id" class="form-group " style="display: none;">
                <label for="section_id">الكود الوظيفي</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="code_id">
                  <option value="">اختر الكود المناسب</option>
                  @foreach($codes as $code)
                    <option value="{{$code->id}}">{{ $code->code}}</option>
                  @endforeach
                </select>
              </div>
              <br>
            <div  class="form-group image section_id" style="display: none;">
                  <label for="image">صورة الصفحة الشخصية</label>
                  <input type="file" name="image" id="image">
                </div>
            <br>
            <div class="form-group">
                <input type="submit"  value="اضافة" class="form-control">
            </div>


        </form>


    </div>
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>الاسم</th>
                <th>البريد الالكتروني</th>

                <th>صلحيات </th>
                <th>اسم القسم </th>
                <th> الصورة   </th>
                <th>الكود الوظيفي   </th>
                
                <th>تعديل</th>
                <th>حذف</th>
                
            </tr>
            </thead>
            @if(count($users) > 0)
                @foreach($users as $user)
                     @if($user->type == 2 OR $user->type == 1)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1}}</td>
                        <td>
                            
                              {{$user->name}}
                            
                        </td>
                        <td>{{$user->email}}</td>
                        @if($user->type == 1)
                        <td>مدير عام</td>
                        <td>كل  الاقسام</td>
                        <td></td>
                        @elseif($user->type == 2)
                        <td>رئيس قسم </td>
                        <td>{{$user->section->name}}</td>
                         <td>
                        <img style="width:80px;height:80px;" 
                            src="{{asset('public/pictures/profile/'.$user->image) }}">
                        </td>
                        @endif
                        <td>{{$user->code_job}}</td>
                       
                         <td>
                            <a href="{{route('admin.users.edit',$user->id)}}">
        
                                    <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('admin.users.delete',$user->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-outline-danger">احذف</button>

                            </form>

                        </td>

                    </tr>
                    </tbody>
                    @endif
                @endforeach
            @endif
        </table>


    </div>

@endsection
@section('scripts')
<script>
        $(document).ready(function(){
            $('.type').click(function(){
                if($(this).filter(":checked").val() == 2){
                    $(".section_id").show();
                }else{
                    $(".section_id").hide();

                }
                
            });
        });

    </script>
@endsection