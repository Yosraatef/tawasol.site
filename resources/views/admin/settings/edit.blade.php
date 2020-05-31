
@extends('admin.index')



@section('content')
    <h2> التعديل علي الاعدادت </h2>

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

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{route('settings.update',$setting->id)}}" method="POST" >


            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">اسم الشركة </label>
                <input type="text"
                       name="name"
                       value="{{$setting->name}}"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="name">رقم الجوال</label>
                <input type="text"
                       name="phone_number"
                       value="{{$setting->phone_number}}"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="name">البريد الالكتروني</label>
                <input type="email"
                       name="email"
                       value="{{$setting->email}}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="name">عين الشركة</label>
                <textarea name="slug" id="" cols="30" rows="10" class="form-control">
                    {{$setting->slug}}
                </textarea>
            </div>


            <div class="form-group">
                <input type="submit"
                       value="Add"
                       class="form-control">
            </div>


        </form>


    </div>


@endsection