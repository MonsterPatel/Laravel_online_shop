@extends('admin.layouts.app')

@section('content')
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Category Edit</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            {{-- <li class="breadcrumb-item">Forms</li> --}}
            <li class="breadcrumb-item"><a href='{{ route('categories.create') }}'>Category Edit Forms</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="" method="post" id="categoryForm" name="categoryForm">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $category->name }}" placeholder="Name">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control"
                                    value="{{ $category->slug }}" placeholder="Slug">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active
                                    </option>
                                    <option {{ $category->status == 0 ? 'selected' : '' }} value="0">Block
                                    </option>
                                </select>
                            </div>

                            <div class="tile-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        $('#categoryForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('categories.update', $category->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response["status"] == true) {
                        $("button[type=submit]").prop('disabled', false);
                        window.location.href = "{{ route('categories.index') }}";

                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html("");

                        $("#slug").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html("");
                    } else {
                        if (response["notFound"] == true) {
                            window.location.href = "{{ route('categories.index') }}";
                        }
                        var errors = response['errors'];
                        if (errors['name']) {
                            $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $("#name").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html("");
                        }
                        if (errors['slug']) {
                            $("#slug").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['slug']);
                        } else {
                            $("#slug").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html("");
                        }
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("something went wrong");
                },
            });
        });

        $('#name').change(function() {
            element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('getSlug') }}',
                type: 'get',
                data: {
                    title: element.val()
                },
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response['status'] = true) {
                        $('#slug').val(response["slug"]);
                    }
                }
            });
        });

        {
            /* Dropzone.autoDiscover = false;
                    const dropzone = $("#image").dropzone({
                        init: function() {
                            this.on('addedfile', function(file) {
                                if (this.files.length > 1) {
                                    this.removeFile(this.files[0]);
                                }
                            });
                        },
                        url: "{{ route('temp-images.create') }}",
                        maxFiles: 1,
                        paramName: 'image',
                        addRemoveLinks: true,
                        acceptedFiles: "image/jpeg,image/png,image/gif",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(file, response) {
                            $("#image_id").val(response.image_id);
                            //console.log(response)
                        }
                    }); */
        }
    </script>
@endsection
