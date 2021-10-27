@section('css-libraries')
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
@endsection

@section('css')
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>{{$page_attribute['title']}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.index') }}">Pelaksanaan</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.konstruksi.index') }}">Divisi Konstruksi</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.konstruksi.progress_kemajuan.index') }}">Progress Kemajuan</a></div>
            </div>
        </div>
        
        <div x-data="{ control_tabs: @entangle('control_tabs') }" class="section-body">
            <div x-show="control_tabs.list" class="row">
                @can($page_permission['add'])
                <div class="col-12 mb-4">
                    <button data-toggle="modal" data-target="#modalAddItem" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add</button>
                </div>
                @endcan
                @forelse ($items as $item)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <a class="text-decoration-none custom-color-inherit" wire:click="setGroupName('{{$item['name']}}')" href="#">
                        <div class="card custom-card-folder">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                                </div>
                                <div class="w-100 mt-2">
                                    <h6 class="text-uppercase mb-0">{{$item['name']}}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <span>Empty</span>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <div :class="{ 'd-block': control_tabs.detail }" class="row" style="display: none;">
                <div class="col-12 mb-4">
                    <button x-on:click="control_tabs.list = true;control_tabs.detail = false;" class="btn btn-warning">Back</button>
                </div>
                @forelse($selected_item_group as $item_group)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#" wire:click="setItem({{$item_group['id']}})" data-toggle="modal" data-target="#modalViewItem">
                        <div class="card shadow-sm custom-card-folder">
                            <article class="article article-style-b mb-0">
                                <div class="article-header">
                                    <div class="article-image" style="background-image: url({{ route($route_image_item, ['id'=>$item_group['id']]) }});">
                                    </div>
                                    <div class="article-badge custom-article-badge w-100">
                                        <div class="article-badge-item text-black custom-bg-transparent-white">{{$item_group['image_name']}}</div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <span>Empty</span>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    
    <div wire:ignore.self class="modal fade" role="dialog" id="modalAddItem">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$page_attribute['title']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addItem" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="input_date">Tanggal</label>
                            <input wire:model="input_tanggal" type="text" class="form-control form-date" name="input_date" id="input_date" />
                        </div>
                        @error('input_tanggal')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" wire:model="file_image" accept="image/*" class="form-control" id="upload_image_{{$iteration}}" required>
                        </div>
                        @error('file_image')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div x-show="isUploading">
                            <progress max="100" class="w-100" x-bind:value="progress"></progress>
                        </div>
                        <div class="w-100">
                            @if ($file_image)
                            Image Preview:
                            <img src="{{ $file_image->temporaryUrl() }}" class="w-100 border shadow">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" role="dialog" id="modalViewItem">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$page_attribute['title']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100">
                        <div class="common-section-title">Image Name</div>
                        <p>{{$selected_item['image_name'] ?? '-'}}</p>
                    </div>
                    <div class="w-100 mb-4">
                        <div class="common-section-title">Date</div>
                        @if ($selected_item)
                        <p>{{date('d F Y', strtotime($selected_item['tanggal']))}}</p>
                        @else
                        <p>-</p>
                        @endif
                    </div>
                    <div class="w-100">
                        @if ($selected_item)
                        <img id="img_id_{{$selected_item['id']}}" src="{{$selected_url}}" class="w-100 border shadow">
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <div class="mr-auto">
                        @if ($selected_item)
                        @can($page_permission['delete'])
                        <button wire:target="delete" wire:loading.class="disabled btn-progress" data-id="{{$selected_item['id']}}" type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                        @endcan
                        <button wire:click="downloadImage" wire:target="downloadImage" wire:loading.class="disabled btn-progress" type="button" class="btn btn-primary"><i class="fas fa-download"></i></button>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


@push('script')
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.form-date').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
        });
    })
    
    $('.form-date').on('change', function(event) {
        Livewire.emit('evSetInputTanggal', event.target.value);
    })
    
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).attr('data-id');
        var target = $(this).attr('data-target');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                var data = await @this.delete(id)
                return data
            },
            allowOutsideClick: () => !Swal.fire.isLoading()
        }).then(async (result) => {
            if (result.value && result.value.status_code == 200) {
                $('.modal').modal('hide');
                
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: result.value.message,
                    });
                }, 600);
            }
            else if (result.value && result.value.status_code == 403) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: result.value.message,
                });
            }
        })
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
