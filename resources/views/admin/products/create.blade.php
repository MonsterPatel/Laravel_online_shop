@extends('admin.layouts.app')

@section('content')
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Product Form </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            {{-- <li class="breadcrumb-item">Forms</li> --}}
            <li class="breadcrumb-item"><a href='{{ route('products.create') }}'>Product forms</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="" id="ProductForm" name="ProductForm" method="POST">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description" id="description" class="form-control" placeholder="Enter Description"
                                    rows="3.5"></textarea>
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Product Name">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input type="number" name="price" id="price" class="form-control"
                                    placeholder="Product Price">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <input type="hidden" id="image_id" name="image_id" value="">
                                <label for="image" class="form-label">Image</label>
                                <div id="image" class="form-control" id="formFileMultiple" multiple>
                                    {{-- <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control"
                                    placeholder="Slug">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="brand">Brands</label>
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Select a Brand.</option>
                                    @if ($brands->isNotEmpty())
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category.</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>

                            {{-- <div class="form-group">
                                <label for="sub-category">Sub-Category</label>
                                <select name="sub-category" id="sub-category" class="form-control">
                                    <option value="">Select a Sub-Category.</option>
                                    @if ($subcategories->isNotEmpty())
                                        @foreach ($subcategories as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>  --}}

                            <div class="form-group">
                                <label for="qty">Product Qty</label>
                                <input type="number" name="qty" id="qty" class="form-control"
                                    placeholder="Product Qty">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>

                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <a href="{{ route('brands.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $('#ProductForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('products.store') }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response["status"] == true) {
                        $("button[type=submit]").prop('disabled', false);
                        window.location.href = "{{ route('sub-categories.index') }}";

                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html("");

                        $("#slug").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html("");
                    } else {
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
    </script>

    <script>
        //slug code
        $('#description').change(function() {
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

        //Image Drop-Zone code
        Dropzone.autoDiscover = false;
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
        });
    </script>
@endsection
