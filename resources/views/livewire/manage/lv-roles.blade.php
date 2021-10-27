@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
@endsection

<div>   
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Manage</a></div>
                <div class="breadcrumb-item">Roles</div>
            </div>
        </div>
        
        <div class="section-body">
            @if (session()->has('success'))
            <div class="alert alert-primary alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{session('success')}}
                </div>
            </div>
            @endif
            <div x-data="{ control_tabs: @entangle('control_tabs') }" class="row">
                <div x-show="control_tabs.view" class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Example Card</h4>
                        </div>
                        <div class="card-body">
                            <div class="w-100 mb-4">
                                <button wire:click="showAddRole" wire:target="showAddRole" wire:loading.class="disabled btn-progress" class="btn btn-primary">Add</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 25px;" scope="col">#</th>
                                        <th class="text-left" scope="col">Roles</th>
                                        <th class="text-left" scope="col">Total Permisson(s)</th>
                                        <th class="text-left" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $key => $role)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$role->name}}</td>
                                        <td style="width: 200px;">{{ count($role->permissions) }}</td>
                                        <td style="width: 150px;">-</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Empty</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div :class="{ 'd-block': control_tabs.add }" class="col-12" style="display: none;">
                    <form wire:submit.prevent="addRole">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <button x-on:click="() => {control_tabs.view = true; control_tabs.add = false;}" type="button" class="btn btn-warning">Back</button>
                            </div>
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4>Roles</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="inputRole">Role Name <small class="text-danger">*</small></label>
                                            <input wire:model.lazy="role.name" class="form-control" id="inputRole" name="input_role" type="text" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Permissions</h4>
                                        <div class="card-header-action">
                                            <button type="button" data-toggle="modal" data-target="#modalListPermission" class="btn btn-primary">Add Permission</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-left" style="width: 25px;" scope="col">#</th>
                                                    <th class="text-left" scope="col">Permission</th>
                                                    <th class="text-center" scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($list_items as $key => $item)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$item['name']}}</td>
                                                    <td class="text-center" style="width: 150px;">
                                                        <button wire:click="deletePermission({{$item['id']}})" wire:target="deletePermission({{$item['id']}})" id="btn_delete_{{$item['id']}}" wire:loading.class="disabled btn-progress" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Empty</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button wire:loading.class="disabled btn-progress" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalListPermission">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.debounce.600ms="permission_search" name="permission_search" required autocomplete="off">
                                <button wire:click="$set('permission_search', '')" class="btn btn-link btn-sm ml-3">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 25px;" scope="col">#</th>
                                    <th class="text-left" scope="col">Permission</th>
                                    <th class="text-ceneter" style="width:50px;" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $key => $permission)
                                <tr>
                                    <td>{{$offset_permission+($key+1)}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input wire:model.defer="permission_ids" value="{{$permission->id}}" type="checkbox" class="custom-control-input" name="input_radio[]" id="check_box_{{$permission->id}}">
                                            <label class="custom-control-label" for="check_box_{{$permission->id}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Empty</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="w-100 mt-4">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                @if ($permission_page == 1)
                                <li class="page-item disabled">
                                    <button class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>
                                </li>
                                @else
                                <li class="page-item">
                                    <button id="btn-prev-page" wire:click="goToPage({{$permission_page-1}})" onclick="console.log('clicked')" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>
                                </li>
                                @endif
                                @for ($i = 1; $i <= $total_permission_page; $i++)
                                <li class="page-item {{($i == $permission_page)? 'active' : ''}}"><button id="btn_{{$i}}" class="page-link" wire:click="goToPage({{$i}})">{{$i}}</button></li>
                                @endfor
                                @if ($permission_page == $total_permission_page)
                                <li class="page-item disabled">
                                    <button class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </button>
                                </li>
                                @else
                                <li class="page-item">
                                    <button id="btn-next-page" wire:click="goToPage({{$permission_page+1}})" onclick="console.log('clicked')"  class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </button>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button wire:click="addPermissionToList" wire:loading.class="disabled btn-progress" type="button" class="btn btn-primary">Add Permission(s)</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>

<script>
    
    document.addEventListener('modal:close', function (event) {
        $('.modal').modal('hide');
    })
    
    document.addEventListener('notification:success', function (event) {
        $('.modal').modal('hide');
        
        setTimeout(function() {
            Swal.fire({
                icon: 'success',
                title: event.detail.title,
                text: event.detail.message,
            });
        }, 600);
    })
</script>
@endpush
