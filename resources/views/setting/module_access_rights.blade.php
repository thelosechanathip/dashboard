@extends('layout.dashboard_template')

@section('title')
    <title>Setting</title>
@endsection

@section('content')
    {{-- Modal Start --}}
        {{-- Type Start --}}
            <div class="modal fade" id="type_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="type_title">เพิ่มข้อมูล Type</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="type_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="type_id_find_one" name="type_id_find_one">
                                <div class="mb-3">
                                    <label for="type_name" class="form-label">ชื่อ Type</label>
                                    <input type="text" class="form-control" id="type_name" name="type_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="type_submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Type End --}}
        {{-- Status Start --}}
            <div class="modal fade" id="status_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="status_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="status_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="status_id_find_one" name="status_id_find_one">
                                <div class="mb-3">
                                    <label for="status_name" class="form-label">ชื่อ Status</label>
                                    <input type="text" class="form-control" id="status_name" name="status_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="status_submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Status End --}}
        {{-- Module Start --}}
            <div class="modal fade" id="module_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="module_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="module_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="module_id" name="module_id">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">ชื่อ Module</label>
                                    <input type="text" class="form-control" id="module_name" name="module_name">
                                </div>
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">ชื่อ Module</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id" id="status_id">
                                        <option selected value="0"></option>
                                        @foreach($status_model AS $sm)
                                            <option value="{{ $sm->id }}">{{ $sm->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="module_submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Module End --}}
    {{-- Modal End --}}
    <main class="main-content">
        <div class="">
            <div class="my-1">
                <h1>Module Access Rights Page</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-2 bg-success p-3 rounded rounded " style="height: 700px;">
                    <div class="d-flex justify-content-start align-items-center">
                        <ul class="text-white">
                            <li class="my-2 zoom-text"><a href="#type_setting_page" class="text-white text-decoration-none p-2">ตั้งค่า Type</a></li>
                            <li class="my-2 zoom-text"><a href="#status_setting_page" class="text-white text-decoration-none p-2">ตั้งค่า Status</a></li>
                            <li class="my-2 zoom-text"><a href="#module_setting_page" class="text-white text-decoration-none p-2">ตั้งค่า Module</a></li>
                            <li class="my-2 zoom-text"><a href="#accessibility_setting_page" class="text-white text-decoration-none p-2">ตั้งค่า Accessibility</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-10 bg-white p-3" id="module-access-rights-page" style="height: 700px; overflow-y: auto;">
                    {{-- Type Page Start --}}
                    <div class="my-1" id="type_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Type</h3>
                            <button type="button" class="btn btn-success zoom-card type_modal_add" id="type_modal_add" data-bs-toggle="modal" data-bs-target="#type_modal">Add Type</button>
                        </div>
                        <hr>
                        <div class="" id="type_show_data_all"></div>
                    </div>
                    {{-- Type Page End --}}
                    <hr>
                    {{-- Status Page Start --}}
                    <div class="my-1" id="status_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Status</h3>
                            <button type="button" class="btn btn-success zoom-card status_modal_add" id="status_modal_add" data-bs-toggle="modal" data-bs-target="#status_modal">Add Status</button>
                        </div>
                        <hr>
                        <div class="" id="status_show_data_all"></div>
                    </div>
                    {{-- Status Page End --}}
                    <hr>
                    {{-- Module Page Start --}}
                    <div class="my-1" id="module_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Module</h3>
                            <button type="button" class="btn btn-success zoom-card module_modal_add" id="module_modal_add" data-bs-toggle="modal" data-bs-target="#module_modal">Add Status</button>
                        </div>
                        <hr>
                        <div class="" id="module_show_data_all"></div>
                    </div>
                    {{-- Module Page End --}}
                    <hr>
                    <div class="my-1" id="accessibility_setting_page">
                        <h3 class="fw-bold">ตั้งค่า Accessibility</h3>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis maxime perferendis nemo quam. Nulla, nostrum voluptatem provident eveniet repellat ea sapiente totam placeat adipisci. Fuga vero error dolorum tempore neque! Aspernatur consequuntur unde tempora reprehenderit totam atque quo reiciendis illo. Rerum, commodi. Nemo, obcaecati, eaque numquam architecto nobis animi ab suscipit veritatis impedit molestiae et libero magni atque repellat inventore neque, labore tenetur illo amet! Quas, fugiat impedit praesentium nisi quidem id, quisquam blanditiis voluptatum aspernatur, doloremque dolor? Ullam libero dolorum unde beatae, tempora nesciunt fugit? Cum possimus molestiae ullam. Tempore, sequi. Asperiores libero quasi ratione ab repellat sequi autem ullam distinctio iste consequatur sint eius delectus quam sit id consectetur beatae tenetur, rem earum odit cum nihil. Repellendus sunt beatae molestias repudiandae, veritatis, alias dicta qui iure, tempore fugit rem accusantium. Placeat dolore, natus reiciendis incidunt in deserunt commodi aliquid aspernatur nam cum non eaque nihil? Reprehenderit, porro temporibus dolorem provident architecto, animi recusandae unde molestias voluptate, vitae aspernatur sed accusamus? Quos sit voluptas expedita aperiam quidem tenetur accusamus doloribus iste iusto cum, eum accusantium consectetur nam aut assumenda ipsum ducimus vitae. Unde soluta in possimus blanditiis non id fugiat voluptatem corrupti et tempora assumenda consequuntur eum officiis, quibusdam delectus. Facere pariatur amet ea. Voluptas cupiditate unde eveniet laudantium possimus rem recusandae voluptate incidunt, distinctio maiores sed animi repellendus illum natus totam quis delectus dolor voluptatum. Et nobis doloremque vero aperiam temporibus mollitia iure repellendus iusto soluta architecto explicabo inventore ratione laudantium quidem iste blanditiis incidunt, dolorum nostrum culpa officiis delectus. Nisi ex, numquam molestiae totam debitis omnis. Enim, impedit dicta. Corrupti, distinctio ipsam eos placeat nemo non temporibus odio recusandae ea molestiae et aspernatur porro quae harum dignissimos beatae impedit odit! Magni illo enim ullam iste natus aliquam adipisci eligendi architecto beatae tempora quaerat expedita aperiam doloribus quidem quo, ea dolorum ut. Accusamus consequatur laboriosam exercitationem voluptatibus iure quia amet eaque dignissimos maiores labore adipisci, dolores voluptatum vel dolorum quas nisi? Tempora vel esse accusantium inventore rerum expedita repellendus eius nesciunt ducimus ea voluptates atque totam a earum temporibus beatae error assumenda consectetur, explicabo, iusto iste quam! Nisi numquam illo architecto delectus sint sequi voluptas perferendis dolor reiciendis autem! Voluptates optio corrupti, consequuntur cum adipisci harum obcaecati dolores eaque? Modi dolores natus facilis. Distinctio blanditiis vitae fuga est quae asperiores incidunt suscipit itaque, totam ab laboriosam voluptate ipsum commodi reprehenderit nemo quas nobis tenetur quis expedita reiciendis. Ex, nisi inventore ut necessitatibus quos minima accusamus magni officiis tenetur, atque esse totam? Minima iure libero, inventore quia maxime, nihil fugit in vitae laboriosam porro illo quibusdam praesentium quae modi labore quidem enim repellat! Eius sint nisi molestiae itaque nihil voluptates facilis necessitatibus cum illum laboriosam minus id nemo magni, esse et minima optio sunt iste. Doloribus nesciunt iusto mollitia, magni et hic nam atque vero ipsum qui modi esse ex officia iure dignissimos animi, aperiam ipsam facere, tenetur nemo placeat. Excepturi maxime earum dicta laudantium sequi. Esse ad optio voluptates, vero saepe atque. Fugiat asperiores, itaque eos, architecto ratione voluptates assumenda exercitationem ullam vero omnis placeat illum expedita minus facilis ab odio in sapiente corrupti! Asperiores, dicta modi. Qui doloribus unde repudiandae expedita? Voluptates tempora nihil quaerat itaque assumenda. Architecto, aspernatur dolores excepturi saepe enim recusandae hic! Dicta ratione necessitatibus quidem quasi vero dolorem, quia earum voluptates. Quam alias quidem iure aperiam iusto dolorem nostrum consequatur obcaecati pariatur beatae corrupti eligendi repellendus neque omnis deserunt sed, mollitia reprehenderit quas, aut dignissimos ad nihil expedita, a asperiores! Enim amet voluptates dolorum, porro deserunt sunt eos minima omnis magnam, suscipit numquam pariatur nemo fuga vel blanditiis qui perspiciatis, culpa sequi adipisci consectetur voluptatem eligendi veniam modi officiis? Ut possimus molestiae illo tempore rem! Quas maiores voluptates aperiam asperiores sit accusantium cupiditate, omnis voluptatem adipisci nesciunt velit dignissimos porro obcaecati nemo inventore libero doloremque vitae dolores eum odio soluta commodi eius tempora ratione! Consectetur ipsa voluptatibus velit adipisci enim laboriosam asperiores repellendus dolorem magni doloremque exercitationem fugit placeat necessitatibus excepturi dolorum deserunt, eveniet recusandae rem nesciunt animi. Officia quae, sapiente ipsa voluptatem porro possimus esse similique fuga. Perferendis rem quasi aspernatur debitis natus praesentium accusantium inventore, voluptatum officiis accusamus id sint ab et dicta itaque deserunt quam alias molestias excepturi? Nam fuga ex perspiciatis amet recusandae vel nobis? Ducimus, deleniti nemo minus ex iusto itaque eum voluptates alias optio eius nam, magnam omnis corporis eaque maiores, sit officiis culpa sequi placeat tempora odio tenetur dolore doloribus. Assumenda maiores fuga placeat, cupiditate reiciendis saepe quis, illo ipsum ex, modi eum nobis dolore. Aut explicabo in odio, hic, sequi inventore suscipit eveniet repellat, beatae dolorem itaque debitis velit blanditiis perferendis odit! Autem quidem magnam reprehenderit dolorum, cumque quia consequuntur eaque expedita, sed aspernatur aliquid vel atque voluptatum at quis nam est maxime alias voluptate! Dolorum, natus nulla accusantium veritatis, non facere esse deleniti a quo ducimus doloremque eos impedit possimus asperiores aliquam nihil odit quod aut commodi consectetur dolorem eligendi cumque ipsam laborum. Nesciunt et recusandae quibusdam ut sequi assumenda nihil aspernatur laborum veniam dolores cum ratione eveniet error sunt est iusto culpa, tempore quam rem eum molestiae mollitia. Quisquam repellendus, ducimus id tempora ipsam maxime. Saepe ea similique illo quo id unde iste temporibus quae, repudiandae magnam voluptatem laborum fuga natus adipisci facere consequatur. Temporibus, deleniti cumque! Voluptatibus natus a enim neque facere minima dolore aspernatur repellendus! Est neque quaerat suscipit laudantium, optio quo mollitia! Inventore voluptatibus laborum adipisci, quod minus, suscipit dolorum ipsa voluptates asperiores totam hic assumenda rerum! Nihil ipsam deserunt, iste nemo officia voluptas mollitia pariatur ad exercitationem, sint non? Similique beatae, voluptate facere iusto quas culpa, molestiae laudantium obcaecati molestias temporibus voluptas exercitationem provident velit maiores commodi tenetur incidunt placeat illo eum sequi optio ipsam sit atque! Rerum quia cum nulla tempora delectus deserunt possimus nisi et placeat provident. Temporibus recusandae ad omnis deserunt iure nam sequi blanditiis nesciunt eaque, sint animi deleniti. A repellendus asperiores magnam unde quae recusandae ab tenetur voluptates omnis corporis sint suscipit pariatur, numquam rerum reprehenderit. Quo ratione molestias, ex magnam officia quibusdam saepe.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Change Mode add || update Start
                // Type Start
                    $('.type_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#type_title').text('เพิ่มข้อมูล');
                        $('#type_submit').text('Add Data');
                        $("#type_form")[0].reset();
                    });

                    $(document).on('click', '.type_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#type_title').text('แก้ไขข้อมูล');
                        $('#type_submit').text('Update Data');
                    });
                // Type End
                // Status Start
                    $('.status_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#status_title').text('เพิ่มข้อมูล');
                        $('#status_submit').text('Add Data');
                        $("#status_form")[0].reset();
                    });

                    $(document).on('click', '.status_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#status_title').text('แก้ไขข้อมูล');
                        $('#status_submit').text('Update Data');
                    });
                // Status End
                // Module Start
                    $('.module_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#module_title').text('เพิ่มข้อมูล');
                        $('#module_submit').text('Add Data');
                        $("#module_form")[0].reset();
                    });

                    $(document).on('click', '.module_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#module_title').text('แก้ไขข้อมูล');
                        $('#module_submit').text('Update Data');
                    });
                // Module End
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#type_form")[0].reset();
                });
            // Reset Form End

            // Fetch All Data Type Start
                fetchAllDataType();

                function fetchAllDataType() {
                    $.ajax({
                        url: '{{ route('fetchAllDataType') }}',
                        method: 'get',
                        success: function(response) {
                            $("#type_show_data_all").html(response);
                            $("#type_table").DataTable({
                                order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Type End

            // Insert && Update Data Type Start
                $("#type_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataType') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataType();
                                    $("#type_form")[0].reset();
                                    $("#type_modal").modal('hide');
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataType') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataType();
                                    $("#type_form")[0].reset();
                                    $("#type_modal").modal('hide');
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Type End

            // Find One Data Type Start
                $(document).on('click', '.type_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataType') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#type_name").val(response.type_name);
                            $("#type_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Type End

            // Delete Data Type Start
                $(document).on('click', '.type_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
                    let csrf = '{{ csrf_token() }}';
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('deleteDataType') }}',
                                method: 'delete',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    if(response.status === 400) {
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                    } else {
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                        fetchAllDataType();
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Type End

            // Fetch All Data Status Start
                fetchAllDataStatus();

                function fetchAllDataStatus() {
                    $.ajax({
                        url: '{{ route('fetchAllDataStatus') }}',
                        method: 'get',
                        success: function(response) {
                            $("#status_show_data_all").html(response);
                            $("#status_table").DataTable({
                                order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Status End

            // Insert && Update Data Status Start
                $("#status_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataStatus') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataStatus();
                                    $("#status_form")[0].reset();
                                    $("#status_modal").modal('hide');
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataStatus') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataStatus();
                                    $("#status_form")[0].reset();
                                    $("#status_modal").modal('hide');
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Status End

            // Find One Data Status Start
                $(document).on('click', '.status_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataStatus') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#status_name").val(response.status_name);
                            $("#status_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Status End

            // Delete Data Status Start
                $(document).on('click', '.status_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
                    let csrf = '{{ csrf_token() }}';
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('deleteDataStatus') }}',
                                method: 'delete',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    if(response.status === 400) {
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                    } else {
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                        fetchAllDataStatus();
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Status End

            // Fetch All Data Module Start
                fetchAllDataModule();

                function fetchAllDataModule() {
                    $.ajax({
                        url: '{{ route('fetchAllDataModule') }}',
                        method: 'get',
                        success: function(response) {
                            $("#module_show_data_all").html(response);
                            $("#module_table").DataTable({
                                order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Module End
        });
    </script>
@endsection
