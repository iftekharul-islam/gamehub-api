@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lending history</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Lend history</li>
                        </ol>
                    </div>
                </div>
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
            </div>
        <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Rent Poster name</th>
                                        <th>Lender Name</th>
                                        <th>Lending date</th>
                                        <th>Status</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lends as $key=>$lend)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $lend->lender->name}}</td>
                                            <td>
                                                {{ $lend->renter->name }}
                                            </td>
                                            <td>{{ $lend->lend_date }}</td>
                                            <td>
                                                @if ($lend->status === 0)
                                                    <a class="badge-info badge text-white" >On lending</a>
                                                @elseif ($lend->status === 1)
                                                    <a class="badge-success badge text-white" >Lending complete</a>
                                                @elseif ($lend->status === 2)
                                                    <a class="badge-danger badge text-white" >Stolen by lender</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary mr-3" href="#">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
{{--                                            <td>--}}
{{--                                                <a class="btn btn-sm btn-primary mr-3"--}}
{{--                                                   href="{{ route('game.edit', $game->id) }}"><i--}}
{{--                                                        class="far fa-edit"></i></a>--}}
{{--                                                <a href="{{ route('rentPost.show', $rent->id) }}" class="btn btn-primary btn-sm">--}}
{{--                                                    <i class="fa fa-eye" aria-hidden="true"></i></a>--}}
{{--                                                <button class="btn btn-danger btn-sm" type="button"--}}
{{--                                                        onclick="deletePost({{ $rent->id }})">--}}
{{--                                                    <i class="far fa-trash-alt"></i></button>--}}
{{--                                                <form id="delete-form-{{ $rent->id }}"--}}
{{--                                                      action="{{ route('rentPost.destroy', $rent->id) }}"--}}
{{--                                                      method="post" class="d-none">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('DELETE')--}}
{{--                                                </form>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
        function deletePost (id) {
            const swalWithBootstrapButtons = Swal.mixin ({
                customClass: {
                    confirmButton: 'btn btn-success ml-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire ({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then ((result) => {
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

