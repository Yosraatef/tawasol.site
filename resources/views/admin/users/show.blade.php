@extends('admin.index')



@section('content')
    <h2> المستخدمين</h2>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th >الاسم</th>
                <th >الكود الوظيفي</th>
                <th >رقم التلفون</th>
                <th >القسم التابع له</th>
                <td>صورة شخصية</td>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($users) > 0)
                @foreach($users as $user)
                    <?php 
                        $nameSec = DB::table('sections')->where('id',$user->section_id)->value('name');
                        $code = DB::table('codes')->where('id',$user->code_id)->value('code');
                        $name = DB::table('codes')->where('id',$user->code_id)->value('name');
                        $phone = DB::table('codes')->where('id',$user->code_id)->value('phone');
                    ?>
                     @if($user->type == 0)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$name}}</td>
                        <td>{{$code}}</td>
                        <td>{{$phone }}</td>
                        <td>{{$nameSec}}</td>
                         <td>
                              <img style="width:80px;height:80px;" 
                            src="{{asset('public/pictures/profile/'.$user->image) }}">
                        </td>
                        <td><a href="{{route('users.edit', $user->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('users.destroy',$user->id)}}" method="POST">
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

        {{ $users->links() }}

    </div>

@endsection