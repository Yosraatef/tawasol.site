@extends('admin.index')


@section('content')
    
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



    <form action="{{route('settings.store')}}" method="POST" >

        @csrf

       
        
        <div class="form-group">
            <label for="name">وصف التطبيق</label>
            <textarea name="aboutApp"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("aboutApp",$settings_data)){{$settings_data["aboutApp"]}}@endif
            </textarea>
        </div>
        <div class="form-group">
            <label for="name">وصف التطبيق</label>
            <textarea name="aboutApp2"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("aboutApp2",$settings_data)){{$settings_data["aboutApp2"]}}@endif
            </textarea>
        </div>
         <div class="form-group">
            <label for="name">وصف التطبيق</label>
            <textarea name="aboutApp3"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("aboutApp3",$settings_data)){{$settings_data["aboutApp3"]}}@endif
            </textarea>
        </div>
         <div class="form-group">
            <label for="name">الشروط والاحكام</label>
            <textarea name="conditions"
                      id=""
                      cols="30"
                      rows="30"
                      class="form-control">
                @if(array_key_exists("conditions",$settings_data)){{$settings_data["conditions"]}}@endif
            </textarea>
        </div>
        <div class="form-group">
            <label for="name">من  نحن</label>
            <textarea name="who"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("who",$settings_data)){{$settings_data["who"]}}@endif
            </textarea>
        </div>
        <div class="form-group">
            <input type="submit"  value="Add" class="form-control">
        </div>


    </form>


</div>
@stop