@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Data Users</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{route('users.create')}}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Users</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-border table-striped custom-table datatable mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user as $item)
                    <tr>
                        {{-- <td><img width="28" height="28" src="assets/img/user.jpg" class="rounded-circle m-r-5" alt=""> Jennifer Robinson</td> --}}
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td><span class="custom-badge status-red">{{$item->roles}}</span></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('users.edit', $item->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <form action="{{route('users.destroy', $item->id)}}" method="POST">
                                        {!!method_field('delete') . csrf_field() !!}
                                        <button type="submit" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</button>
                                    </form>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delete_patient"></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border text-center p-5">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            {{$user->links()}}
        </div>
    </div>
</div>
@endsection