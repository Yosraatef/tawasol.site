@extends('admin.index')



@section('content')
    <h2>عرض الأكواد</h2>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>الاسم</th>
                <th>الكود</th>
                <th>رقم التلفون</th>
                <th>تعديل</th>
                <th>حذف</th>
            </tr>
            </thead>
            @if(count($codes) > 0)
                @foreach($codes as $code)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$code->name}}</td>
                        <td>{{$code->code}}</td>
                        <td>{{$code->phone}}</td>
                        <td>
                         <a href="{{route('codes.edit', $code->id)}}">
        
                                    <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('codes.destroy',$code->id)}}" method="POST">
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

        {{ $codes->links() }}

    </div>

@endsection