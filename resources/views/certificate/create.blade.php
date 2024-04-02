@extends('layouts.customapp')

@section('custom-css')
    <style>
        a {
            font-family: Roboto;
            display: block;
            color: #000;
            padding-bottom: 10px;
        }

        [href$=".pdf"]::before {
            font-family: "FontAwesome";
            content: "\f1c1";
            margin-right: 2px;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Certificate</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('certificates.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Type:</strong>

                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                            name = "type_id">
                            <option selected>Select Options</option>
                            @foreach ($data as $val)
                                <option value="{{ $val->id }}" data-href= "{{ $val->image }}">{{ $val->name }}
                                </option>
                            @endforeach


                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group downloadfiles">

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>File:</strong>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>


    <p class="text-center text-primary"><small></small></p>



@endsection

@section('script')
    <script>
        $('#floatingSelect').on('change', function() {
            alert(this.value);
            var data = $(this).find('option:selected').data('href');
            console.log($(this).find('option:selected').data('href'));
            var url = '{{ url('/uploads/form/') }}' + '/' + data;
            console.log(url);
            $('.downloadfiles').append('<strong>File:</strong><a href=' + url + '>Download Free Book</a>');

        })
    </script>
@endsection
