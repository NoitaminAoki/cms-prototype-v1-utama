@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/library/chocolat/css/chocolat.css')}}">
@endsection

@section('css')
<style>
    .custom-address>strong {
        color: #191d21 !important;
    }
</style>
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Realisasi Dana</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keuangan</a></div>
                <div class="breadcrumb-item">Realisasi Dana</div>
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
            <div x-data="{ show_content: @entangle('show_modal') }" class="row">
                <div x-show="!show_content" class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Table Realisasi Dana</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Pembuat Pengajuan</th>
                                            <th scope="col">Paket</th>
                                            <th scope="col">Item</th>
                                            <th style="max-width: 100px;" scope="col">Total Harga Material</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pengajuan_danas as $key => $pengajuan_dana)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td> {{$pengajuan_dana->pembuat_pengajuan}}</td>
                                            <td> {{$pengajuan_dana->paket->code}} - {{$pengajuan_dana->paket->nama}} </td>
                                            <td> {{$pengajuan_dana->item->nama}} </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{number_format($pengajuan_dana->total_harga_material, 0, ',', '.')}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($pengajuan_dana->status_pengajuan == 'complete')
                                                <span class="badge badge-success">complete</span>
                                                @elseif ($pengajuan_dana->status_pengajuan == 'process')
                                                <span class="badge badge-info">Process</span>
                                                @else
                                                <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array($pengajuan_dana->status_pengajuan, ['process', 'complete']))
                                                <div class="d-flex">
                                                    <div>
                                                        <button wire:click="setRealisasiDana({{$pengajuan_dana->realisasi->id}})" wire:target="setRealisasiDana({{$pengajuan_dana->realisasi->id}})" wire:loading.class="disabled btn-progress" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </div>
                                                    @if ($pengajuan_dana->status_pengajuan == 'process')
                                                    <div class="ml-2" style="min-width: 110px">
                                                        <button wire:click="setRealisasiId({{$pengajuan_dana->realisasi->id}})" data-toggle="modal" data-target="#modalUploadFile" class="btn btn-sm btn-info"><i class="fas fa-file-alt"></i> Upload Bukti</button>
                                                    </div>
                                                    @endif
                                                </div>
                                                @else
                                                <a href="{{ route('keuangan.realisasi_dana.create', ['pengajuan_dana_id'=>$pengajuan_dana->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-sign-in-alt"></i> Detail</a>
                                                @endif
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
                        </div>
                    </div>
                </div>
                <div x-show="show_content" class="col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <button x-on:click="show_content = false" class="btn btn-warning">Back</button>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary border-left border-bottom border-right shadow-none">
                                <div class="card-header">
                                    <h4>Detail Pengajuan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <address class="custom-address">
                                                    <strong>Divisi</strong><br>
                                                    {{$selected_realisasi->divisi->nama ?? '-'}}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <address class="custom-address">
                                                    <strong>Paket</strong><br>
                                                    {{$selected_realisasi->pengajuan->paket->nama ?? '-'}}
                                                </address>
                                                <h6 class="text-dark"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <address class="custom-address">
                                                    <strong>Item</strong><br>
                                                    {{$selected_realisasi->pengajuan->item->nama ?? '-'}}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <address class="custom-address">
                                                    <strong>Pembuat Pengajuan</strong><br>
                                                    {{$selected_realisasi->pengajuan->pembuat_pengajuan ?? '-'}}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <address class="custom-address">
                                                    <strong>Keterangan</strong><br>
                                                    {{$selected_realisasi->pengajuan->keterangan ?? '-'}}
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary border-left border-bottom border-right shadow-none">
                                <div class="card-header">
                                    <h4>Detail Realisasi</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <address class="custom-address">
                                            <strong>Realisasi ID</strong><br>
                                            {{$selected_realisasi->format_code ?? '-'}}
                                        </address>
                                    </div>
                                    <div class="form-group">
                                        <address class="custom-address">
                                            <strong>Keterangan</strong><br>
                                            {{$selected_realisasi->keterangan ?? '-'}}
                                        </address>
                                    </div>
                                    @if ($selected_realisasi && $selected_realisasi->status == 'complete')
                                    <div class="form-group">
                                        <address class="custom-address">
                                            <strong>Bukti Transfer</strong><br>
                                            <button data-toggle="modal" data-target="#modalImage" class="btn btn-sm btn-link"><i class="fas fa-file-alt"></i> Open</button>
                                        </address>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary border-left border-bottom border-right shadow-none">
                        <div class="card-header">
                            <h4>Material Detail</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 25px;" scope="col">#</th>
                                        <th class="text-left" scope="col">Nama Material</th>
                                        <th class="text-left" style="width: 150px" scope="col">Satuan</th>
                                        <th class="text-left" style="width: 150px" scope="col">Jumlah</th>
                                        <th class="text-center" style="width: 150px" scope="col">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($material_pengajuan_dana as $material_key => $material_pengajuan)
                                    @php
                                    $total_harga_material += $material_pengajuan->total_harga;
                                    @endphp
                                    <tr>
                                        <td>{{$material_key+1}}</td>
                                        <td> {{$material_pengajuan->material->nama_material}} </td>
                                        <td> {{$material_pengajuan->material->ms_satuan->satuan}} </td>
                                        <td>
                                            <span>{{$material_pengajuan->jumlah}}/{{$material_pengajuan->jumlah+$material_pengajuan->material_realisasi->jumlah}}</span>
                                            @if ($material_pengajuan->material_realisasi->jumlah > 0)
                                            <div class="text-small text-muted">Ditolak : {{$material_pengajuan->material_realisasi->jumlah}}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($material_pengajuan->total_harga, 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($loop->last)
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-center">Total</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($total_harga_material, 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="5"><small>Empty</small></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalUploadFile">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Realisasi Dana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="uploadFileBukti" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Realisasi ID</label>
                            <p>{{$selected_realisasi->format_code ?? '-'}}</p>
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" wire:model="file_upload_bukti" accept="image/*" class="form-control" id="upload_{{$iteration}}" required>
                        </div>
                        @error('file_upload_bukti')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div x-show="isUploading">
                            <progress max="100" class="w-100" x-bind:value="progress"></progress>
                        </div>
                        <div class="w-100">
                            @if ($file_upload_bukti)
                            Image Preview:
                            <img src="{{ $file_upload_bukti->temporaryUrl() }}" class="w-100 border shadow">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button wire:target="setRealisasiId" wire:loading.class="disabled btn-progress" wire:loading.delay.longer type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" wire:loading.delay.longer class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="modalImage">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100">
                        @if ($selected_realisasi && $selected_realisasi->status == 'complete')
                        <img src="{{$selected_url}}" class="w-100 border shadow">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@push('script')
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/library/chocolat/js/jquery.chocolat.min.js')}}"></script>

@if (session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{session('success')}}",
    });
</script>
@endif
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
