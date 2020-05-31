@extends('admin.index')



@section('content')
    <h2>عرض  المناسبات</h2>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>اسم  صاحب  الحدث</th>
                <th>اسم  الحدث</th>
                <th>التاريخ</th>
                <th>التوقيت</th>
                <th>العنوان</th>
                <th>صورة المناسبة</th>
                <th>اسم  القسم</th>
                <th>اسم  الموظف</th>
                <th>حالت المناسبة</th>
                <th>المدعوين</th>
                <th>تعديل </th>
                <th>مسح </th>
            </tr>
            </thead>
            @if(count($occasions) > 0)
                @foreach($occasions as $ocs)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$ocs->name_occasion}}</td>
                        <td>{{$ocs->name_owner}}</td>
                        <td>{{$ocs->date}}</td>
                        <td>{{$ocs->time}}</td>
                        <td>{{$ocs->address}}</td>
                         <td>
                              <img style="width:80px;height:80px;" 
                            src="{{asset('public/pictures/occasions/'.$ocs->image) }}">
                        </td>
                        <td>{{$ocs->section->name}}</td>
                        <td>{{$ocs->user->name}}</td>
        
                        @if( $ocs->is_public == 1)
                             <td>للعامة</td>
                             <td>الكل </td>
                        @elseif($ocs->is_public == 0)
                            <td>مناسبة خاصة للقسم </td>
                            <td> جميع من في القسم مدعو </td>
                        @elseif($ocs->is_public == 2)
                            <td>مناسبة خاصة  للفرد </td> 
                            <td>{{$ocs->user->name}}</td> 
                        @elseif($ocs->is_public == 3)
                            <td>مناسبة مرفوضة </td>    
                            <td>لا يوجد  احد مدعي</td>    
                        @endif
                          
                                         
                        <td>
                         <a href="{{route('occasions.edit', $ocs->id)}}">
        
                                    <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('occasions.destroy',$ocs->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-outline-danger">احذف</button>

                            </form>

                        </td>

                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>

        {{ $occasions->links() }}

    </div>

@endsection