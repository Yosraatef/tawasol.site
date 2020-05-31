@extends('admin.index')
@section('content')

    <section class="content">

        <div class="card" style="width: 18rem; float: right;margin: 10px;" >

            <div class="card-body">

                <p class="card-text">
                    <strong>
                        عدد الأقسام الموجودة لدينا  ::
                    </strong>
                    {{$categories}}
                </p>
                <a href="{{route('categories')}}"
                   class="btn btn-primary">اضف قسم جديد</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;float: right;margin: 10px;">

            <div class="card-body">

                <p class="card-text">
                    <strong>
                        عدد الأقسام  الفرعية  ::
                    </strong>
                    {{$maincategories}}
                </p>
                <a href="{{route('mainCategories')}}"
                   class="btn btn-primary">اضف قسم جديد</a>
            </div>
        </div>
         
        
    </section>


        <script>
        function printDiv()
        {

            var divToPrint=document.getElementById('DivIdToPrint');

            var newWin=window.open('','Print-Window');

            newWin.document.open();

            newWin.document.write('<html lang="ar" style="text-align: right"><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

            newWin.document.close();

            setTimeout(function(){newWin.close();},10);

        }
    </script>


@endsection
