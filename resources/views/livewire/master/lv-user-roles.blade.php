@section('css-libraries')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/library/select2/css/select2.min.css') }}">
@endsection

<div>   
    <section class="section">
        <div class="section-header">
          <h1>User Roles</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('master.index') }}">Master</a></div>
            <div class="breadcrumb-item">User</div>
          </div>
        </div>
        
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 25px;" scope="col">#</th>
                                <th class="text-left" scope="col">User Name</th>
                                <th class="text-left" scope="col">Email</th>
                                <th class="text-left" style="width: 150px;" scope="col">Role</th>
                                <th class="text-left" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->getRoleNames()[0] ?? '-'}}</td>
                                <td>
                                    <button wire:click="setUser({{$user->id}})" wire:target="setUser({{$user->id}})" data-toggle="modal" data-target="#modalEditUserRole" wire:loading.class="disabled btn-progress" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Empty</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalEditUserRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="updateUserRole">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="read_user_name">User Name</label>
                            <input type="text" class="form-control" wire:model.defer="user.name" name="read_user_name" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="read_email">Email</label>
                            <input type="text" class="form-control" wire:model.defer="user.email" name="read_email" disabled>
                        </div>
                        <div wire:ignore class="form-group mb-3">
                            <label for="code">Role</label>
                            <select id="select_role" class="form-control select2" required>
                                <option></option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>

@push('script-libraries')
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/library/select2/js/select2.full.min.js') }}"></script>
@endpush
@push('script')
<script>
    $(document).ready(function() {
        $('#select_role').select2({
            placeholder: 'Pilih Role',
            width: '100%'
        })
    })
    
    $('#select_role').on('change', function() {
        value = $(this).val();
        Livewire.emit('evSetRole', value);
    })
    
    document.addEventListener('select2:set', function (event) {
        $(event.detail.selector).val(event.detail.value).trigger("change")
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
