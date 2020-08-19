@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                            <li class="breadcrumb-item active">All users</li>
                        </ol>
                    </div>
                </div>
            </div>
        <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('user.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> User</a>
                            </div>
                            <div class="card-body">
{{--                                @if (count($users) > 0)--}}
                                    <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role(s)</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key=>$user)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                            <td>{{ $user->email ? $user->email : $user->phone_number }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <a class="badge-primary badge text-white">{{ $role->name }}</a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($user->status === 0)
                                                    <a class="badge-danger badge text-white">Inactive</a>
                                                @elseif ($user->status === 1)
                                                    <a class="badge-success badge text-white">Active</a>
                                                @elseif ($user->status === null)
                                                    <a class="badge-info badge text-white">Invalid</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary mr-3"
                                                   href="{{ route('user.edit', $user->id) }}"><i
                                                        class="far fa-edit"></i></a>
{{--                                                <button class="btn btn-danger btn-sm" type="button"--}}
{{--                                                        onclick="deleteGame({{ $game->id }})">--}}
{{--                                                    <i class="far fa-trash-alt"></i></button>--}}
{{--                                                <form id="delete-form-{{ $game->id }}"--}}
{{--                                                      action="{{ route('game.destroy', $game->id) }}"--}}
{{--                                                      method="post" style="display: none;">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('DELETE')--}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
{{--                                @else--}}
{{--                                    <h4 class="text-center">No data found</h4>--}}
{{--                                @endif--}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script type="text/javascript">
        function deleteGame(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ml-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-' + id).submit();
                    swalWithBootstrapButtons.fire({
                        title: 'Deleted!',
                        text: 'Your file has been deleted.',
                        icon: 'success',
                        timer: 1500,
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: 'Cancelled',
                        text: 'Your imaginary file is safe :)',
                        icon: 'error',
                        timer: 1500,
                    })
                }
            });
        }
    </script>
@endsection

