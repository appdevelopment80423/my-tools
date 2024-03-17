@extends('admin.layout.main')
@section('title', 'Edit Role')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <h5 class="card-header">Edit Role</h5>
        <form id="user-form" class="card-body" method="POST" action="{{ route('admin.roles.update') }}">
            @csrf
            <input type="hidden" name="id" value="{{$role->id}}" required>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="name">Role<span>*</span></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{$role->name}}" placeholder="Enter user name">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row mb-4">
                                    <label for="name">Assign Permission<span>*</span></label>
                                    @foreach($permissions as $key => $permission)
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="item_checkbox{{$key}}" name="permissions[]" value="{{$key}}"
                                                @if(in_array($key, $role_permission))
                                                                   checked
                                                            @endif
                                                >
                                                <label class="form-check-label" for="item_checkbox{{$key}}"> {{$permission}} </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('permissions')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="pt-4">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">Update</button>
                                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
