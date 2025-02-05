@extends('layout.dashboard_template')

@section('title')
    <title>Test System All</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- <div class="bg-light" id="show-data"></div> --}}
        <h1>Show Data</h1>
        <button class="btn btn-success" id="fetch_data">ShowConsoleLog</button>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function queryData() {
                $.ajax({
                    url: '127.0.0.1:3000/api/users',
                    method: 'get',
                    success: function(response) {
                        // Swal.close();
                        console.log(response);
                    }
                });
            }
            $('#fetch_data').on('click', function() {
                queryData();
            });
        });
    </script>
@endsection
