@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
@endsection

@section('css')
<style>
    .small-row td {
        height: 30px !important;
    }
    .text-dot-sm {
        font-size: 5px;
    }
</style>
@endsection

<div>   
    <section class="section">
        <div class="section-header">
            <h1>{{$parent_code->code}} - {{$parent_code->nama}} | Sub Codes</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Master</a></div>
                <div class="breadcrumb-item"><a href="{{ route('master.code.index') }}">Code</a></div>
                <div class="breadcrumb-item">Sub Code</div>
            </div>
        </div>
        
        <div class="section-body">
            <h2 class="section-title">This is Example Page</h2>
            <p class="section-lead">This page is just an example for you to create your own page.</p>
            <div class="card">
                <div class="card-header">
                    <h4>Example Card</h4>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddCode">Add</button>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 25px;" scope="col">#</th>
                                <th class="text-left" style="width: 150px;" scope="col">Code</th>
                                <th class="text-left" scope="col">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sub_codes as $key => $sub_code)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$sub_code->code}}</td>
                                <td>{{$sub_code->nama}}</td>
                            </tr>
                            @foreach ($sub_code->nested_sub_code as $sub_key => $nested_sub_code)
                            <tr class="small-row">
                                <td></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-circle text-dot-sm"></i><small class="ml-2">{{$nested_sub_code->code}}</small></td>
                                    </div>
                                <td><small>{{$nested_sub_code->nama}}</small></td>
                            </tr>
                            @endforeach
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
    </section>
    
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalAddCode">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addSubCode">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" wire:model.defer="code" name="code" required autocomplete="off">
                        </div>
                        @error('code')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" wire:model.defer="name" name="name" required autocomplete="off">
                        </div>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>

@push('script')
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>

<script>
    
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
