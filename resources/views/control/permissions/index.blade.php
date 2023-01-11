@extends('cabinet.layouts.app') @section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">Permissions</h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--Begin::Main Portlet-->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="m-portlet m-portlet--tabs  ">
                    <div class="table-responsive">
                        <form action="" method="post">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        @foreach($roles as $role)
                                        <th>{{$role->name}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission->name}}</td>
                                    @foreach($roles as $role)
                                    <th>
                                        <input type="checkbox" name="roles[{{$role->id}}][{{$permission->id}}]" 
                                        {{$role->hasPermission($permission->name) ? 'checked':''}}>
                                    </th>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                            <button class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection