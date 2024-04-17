@extends('admin.layouts.app')

@section('content')
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Sub-Category Tables</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href='{{ route('sub-categories.index') }}'>Sub-Category Tables</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('admin.message')
        </div>
        {{-- <a href="{{ route('categories.create') }}" class="btn btn-primary pull-right">New Brand</a> --}}
        <div class="col-md-12">
            <div class="tile">
                <div class="row">
                    <div class="col-6">
                        <button type="button" onclick="window.location.href='{{ route('sub-categories.index') }}'"
                            class="btn btn-outline-dark ml-3">Reset</button>
                    </div>
                    <div class="col-6">
                        <form>
                            <div class="input-group input-group pull-right" style="width: 250px;">
                                <input type="text" value="{{ Request::get('search') }}" name="search"
                                    class="form-control form-control pull-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary fa fa-search">
                                    </button>
                                </div>
                            </div>
                            {{-- <a href="{{ route('brands.create') }}" class="btn btn-primary pull-right">New Brand</a> --}}
                        </form>
                    </div>
                </div>
                <hr>
                <table class="table table-hover table-bordered dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" width="60">ID</th>
                            <th class="sorting sorting_asc">Sub-Category Name</th>
                            <th class="sorting sorting_asc">Slug</th>
                            <th class="sorting sorting_asc">Category</th>

                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($subCategories->isNotEmpty())
                            @foreach ($subCategories as $subCategory)
                                <tr>
                                    <td>{{ $subCategory->id }}</td>
                                    <td>{{ $subCategory->name }}</td>
                                    <td>{{ $subCategory->categoryName }}</td>
                                    <td>{{ $subCategory->slug }}</td>

                                    <td>
                                        @if ($subCategory->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                width="20%" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                width="20%" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('sub-categories.edit', $subCategory->id) }}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                width="20%" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a>

                                        <a href="#" onclick="deleteSubCategory({{ $subCategory->id }})"
                                            class="text-danger w-4 h-4 mr-1">
                                            <svg wire:loading.remove.delay="" wire:target="" width="20%"
                                                class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path ath fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Record Not Found! :)</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="card-footer clearfix">
                    {{ $subCategories->links() }}
                </div>
            </div>
        </div>
    @endsection

    @section('customJs')
        <script>
            function deleteSubCategory(id) {
                var url = '{{ route('sub-categories.delete', 'ID') }}';
                var newurl = url.replace("ID", id);
                if (confirm("Are you sure you want to delete!")) {
                    $.ajax({
                        url: newurl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            window.location.href = "{{ route('sub-categories.index') }}";
                            // if (response["status"]) {
                            //     window.location.href = "{{ route('sub-categories.index') }}";
                            // }
                        }
                    });
                }
            }
        </script>
    @endsection
