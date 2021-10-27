@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/library/select2/css/select2.min.css') }}">
@endsection

<div>   
    <section class="section">
        <div class="section-header">
            <h1>Codes</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Master</a></div>
                <div class="breadcrumb-item">Code</div>
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
                                <th class="text-left" scope="col">Divisi</th>
                                <th class="text-left" style="width: 150px;" scope="col">Code</th>
                                <th class="text-left" scope="col">Name</th>
                                <th class="text-left" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($codes as $key => $code)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$code->divisi->nama}}</td>
                                <td>{{$code->code}}</td>
                                <td>{{$code->nama}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('master.code.sub_code', ['parent_code_id'=>$code->id]) }}"><i class="fas fa-search"></i> View</a>
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
    </section>
    
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalAddCode">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addCode">
                    <div class="modal-body">
                        <div wire:ignore class="form-group mb-3">
                            <label for="code">Divisi</label>
                            <select id="select_divisi" class="form-control select2" required>
                                <option></option>
                                @foreach ($divisis as $divisi)
                                <option value="{{$divisi->id}}">{{$divisi->nama}}</option>
                                @endforeach
                            </select>
                        </div>
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
<script src="{{ asset('assets/library/select2/js/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#select_divisi').select2({
            placeholder: 'Pilih Divisi',
            width: '100%'
        })
    })
    
    $('#select_divisi').on('change', function() {
        value = $(this).val();
        Livewire.emit('evSetDivisi', value);
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
