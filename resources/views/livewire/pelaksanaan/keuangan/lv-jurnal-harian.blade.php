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
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.keuangan.index') }}">Divisi Keuangan</a></div>
            </div>
        </div>
        
        <div x-data="{ control_tabs: @entangle('control_tabs') }" class="section-body">
            <div class="row">
                <div class="col-12 mb-4">
                    <h2 class="section-title">Data Pusat</h2>
                    <hr>
                </div>
                @can($page_permission['add'])
                <div class="col-12 mb-4">
                    <button data-toggle="modal" data-target="#modalAddItem" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add</button>
                </div>
                @endcan
                @forelse ($items as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div wire:click="setItem({{$item->id}})" data-toggle="modal" data-target="#modalViewItem" class="card shadow-sm custom-card-folder card-link">
                        <article class="article article-style-b mb-0">
                            <div class="article-header">
                                <div class="article-image" style="background-image: url({{ route('files.image.stream', ['path'=>$item->sector_id.'/'.$item->base_path, 'name' => $item->image_name]) }});">
                                </div>
                                <div class="article-badge custom-article-badge w-100">
                                    <div class="article-badge-item text-black custom-bg-transparent-white">{{$item->image_real_name}}</div>
                                </div>
                            </div>
                        </article>
                    </div>
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
                <div class="col-12 mb-4">
                    <h2 class="section-title">Data Lokasi <div wire:loading wire:target="setSectorId" style="display: none"><i wire:loading.class="d-block" class="ml-2 text-primary fas fa-sync-alt fa-spin"></i></div></h2>
                    <hr>
                </div>
                <div x-show="control_tabs.sector_list" class="col-12">
                    <div class="row">
                        @foreach ($wilayah as $key => $sector)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div wire:click="setSectorId('{{$key}}')" class="card custom-card-folder card-link">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                                    </div>
                                    <div class="w-100 mt-2">
                                        <span class="text-uppercase font-weight-600 mb-0">{{$sector}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div :class="{ 'd-none': !control_tabs.sector_detail }" class="col-12 d-none">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <button x-on:click="control_tabs.sector_list = true;control_tabs.sector_detail = false;$wire.clearSector()" class="btn btn-warning">Back</button>
                        </div>
                        @forelse ($sector_items as $sector_item)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div id="container_sector_{{$sector_item['id']}}" wire:click="setItem({{$sector_item['id']}}, '{{$sector_item['sector_id']}}')" data-toggle="modal" data-target="#modalViewSectorItem" class="card shadow-sm custom-card-folder card-link">
                                <article class="article article-style-b mb-0">
                                    <div class="article-header">
                                        <div class="article-image" style="background-image: url({{ route('files.image.stream', ['path'=>$sector_item['sector_id'].'/'.$sector_item['base_path'], 'name' => $sector_item['image_name']]) }});">
                                        </div>
                                        <div class="article-badge custom-article-badge w-100">
                                            <div class="article-badge-item text-black custom-bg-transparent-white">{{$sector_item['image_real_name']}}</div>
                                        </div>
                                    </div>
                                </article>
                            </div>
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
                        <p>{{$selected_item['image_real_name'] ?? '-'}}</p>
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
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" role="dialog" id="modalViewSectorItem">
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
                        <p>{{$selected_item['image_real_name'] ?? '-'}}</p>
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
                        <img id="sector_img_id_{{$selected_item['id']}}" src="{{$selected_url}}" class="w-100 border shadow">
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <div class="mr-auto">
                        @if ($selected_item)
                        <button wire:click="downloadImage('{{$selected_item['sector_id']}}')" wire:target="downloadImage" wire:loading.class="disabled btn-progress" type="button" class="btn btn-primary"><i class="fas fa-download"></i></button>
                        <button wire:click="copyDataSector({{$selected_item['id']}},'{{$selected_item['sector_id']}}')" wire:target="copyDataSector" wire:loading.class="disabled btn-progress" type="button" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Accept</button>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
            text: "Once deleted, you will not be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            showLoaderOnConfirm: true,
            reverseButtons: true,
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
    document.addEventListener('console:log', function (event) {
        console.log(event.detail.value);
    })
    document.addEventListener('notification:show', function (event) {
        $('.modal').modal('hide');
        
        setTimeout(function() {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.title,
                text: event.detail.message,
            });
        }, 600);
    })
</script>
@endpush
