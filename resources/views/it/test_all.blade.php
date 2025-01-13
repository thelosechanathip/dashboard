@extends('layout.dashboard_template')

@section('title')
    <title>Test System All</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        <div class="bg-light" id="show-data"></div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function queryData() {
                $.ajax({
                    url: '{{ route('itFetchDataAll') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#show-data").html(response);
                        $("#show_data_table").DataTable({
                            // order: [0, 'ASC']
                        });
                    }
                });
            }
        });
    </script>
@endsection
