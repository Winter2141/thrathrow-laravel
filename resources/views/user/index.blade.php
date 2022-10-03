@extends('layouts.app')

@section('content')
<div class="content-header row">
        <div class="content-header-right text-md-right col-md-12 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn btn-primary ag-grid-export-btn" data-toggle="modal" data-target="#userCreate">
                    Add User
                </button>
                @include('user.create')
            </div>
        </div>
    </div>
</div>

<section id="basic-datatable">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table table-striped dataex-html5-selectors">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $key => $users)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $users->first_name }}</td>
                                        <td>{{ $users->last_name }}</td>
                                        <td>{{ $users->email }}</td>
                                        <td>
                                            @if($users->parent_id == 1)
                                                <span class="badge badge-success">Normal User</span>
                                            @else
                                                <span class="badge badge-success">Normal User</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($users->parent_id == 1)
                                                <div class="d-flex">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#userEdit{{ $users->id }}">
                                                        <i class="feather icon-edit text-success"></i>
                                                    </a>
                                                    @include('user.edit')
                                                </div>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#userEdit{{ $users->id }}">
                                                        <i class="feather icon-trash text-danger"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="d-flex">
                                                    <a href="{{ route('admin_user_details', Illuminate\Support\Facades\Crypt::encrypt($users->id)) }}">
                                                        <i class="feather icon-eye text-primary"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
