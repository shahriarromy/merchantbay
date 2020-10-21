<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ public_path('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ public_('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Merchant Bay') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest

                        @else
                            @if (Auth::user()->user_type == 'admin')
                            <li class="nav-item"><a class="nav-link" href="/admin">Headings of Title</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/rfq">RFQ</a></li>
                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#headings_image').change(function(e){
                let fileName = e.target.files[0].name;
                //alert(fileName);
                $('label[for=headings_image]').html(fileName);
            });
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('adminheading.tables') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'headings_title', name: 'headings_title', orderable: false, searchable: true},
                    {data: 'headings_image', name: 'headings_image', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            $('.data-table-rfq').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('adminrfq.tables') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'rfq_name', name: 'rfq_name', orderable: false, searchable: true},
                    {data: 'rfq_email', name: 'rfq_email', orderable: false, searchable: true},
                    {data: 'rfq_company', name: 'rfq_company', orderable: false, searchable: true},
                    {data: 'rfq_description', name: 'rfq_description', orderable: false, searchable: false},
                    {data: 'view', name: 'view', orderable: false, searchable: false},
                ]
            });
            // $('.headings_image_ac').click(function () {
            //     alert('sd');
            // });
            $( "#imageUploadForm" ).submit(function( e ) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: 'imageresize',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        console.log(data);
                        $('.data-table').DataTable().ajax.reload();
                        $('#imageEditModal').modal('hide');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
        $(document).on('click', '.viewRFQsingle', function (e) {
            e.preventDefault();
            let token = $('meta[name="csrf-token"]').attr('content');
            let id = $(this).attr('data-ids');
            $.ajax({
                url: '/adminrfqsingle',
                type: 'POST',
                data: {id: id, _token: token},
                dataType: 'json',
                cache: false,
                success: function (data) {
                    console.log(data);
                    $('#rfqViewModal').modal('show');
                    $('#rfq_name').html(data.rfq_name);
                    $('#rfq_email').html(data.rfq_email);
                    $('#rfq_company').html(data.rfq_company);
                    $('#rfq_description').html(data.rfq_description);
                }
            });
        });
        function edit_image_modal(id){
            $('#imageEditModal').modal('show');
            $('[name=headings_id]').val(id);
        }

    </script>
</body>
</html>
