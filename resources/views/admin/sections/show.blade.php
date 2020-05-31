
@extends('admin.index')



@section('content')
    <h2>عرض الأقسام</h2>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>الاسم</th>
                <th>الحدث</th>
            </tr>
            </thead>
            @if(count($sections) > 0)
                @foreach($sections as $section)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$section->name}}</td>
                        <td>
                         <a href="{{route('section.edit', $section->id)}}">
        
                                    <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('section.destroy',$section->id)}}" method="POST">
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

        {{ $sections->links() }}

    </div>

@endsection