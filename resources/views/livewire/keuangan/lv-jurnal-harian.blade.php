@section('css-library')
{{-- <link type="text/css" rel="stylesheet" href="{{ asset('assets/library/bootstrap_daterangepicker/daterangepicker.css') }}"> --}}
<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link type="text/css" rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('assets/library/select2/css/select2.min.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endsection

@section('css')
<style>
    .custom-w-180 {
        width: 180px;
    }
</style>
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Jurnal Harian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keuangan</a></div>
                <div class="breadcrumb-item">Jurnal Harian</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="w-100 row mb-4">
                            <div wire:ignore class="form-group col-md col-sm-12 mb-2">
                                <label for="select_paket_s">Paket</label>
                                <select id="select_paket_s" class="form-control select2 select-paket">
                                    <option></option>
                                    @foreach ($pakets as $paket)
                                    <option value="{{$paket['id']}}">{{$paket['nama']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md col-sm-12 mb-2">
                                <label>Tanggal</label>
                                <input wire:model="filter_tanggal" type="text" class="form-control" name="datepicker" id="datepicker" />
                            </div>
                            <div class="form-group col-md col-12 mb-2 d-flex align-items-end">
                                <button wire:click="setFilter" wire:loading.class="disabled btn-progress" wire:target="setFilter" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                <button wire:click="resetInput" class="btn btn-link ml-3">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jurnal Harian</h4>
                    </div>
                    <div class="card-body">
                        <div class="w-100 mb-4">
                            <button wire:click="exportToExcelAll" wire:target="exportToExcelAll" wire:loading.class="disabled btn-progress" class="btn btn-primary">Export to Excel</button>
                        </div>
                        @if ($previous_item)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th scope="col">Uraian</th>
                                    <th scope="col">Total Kas Masuk</th>
                                    <th scope="col">Total Kas Keluar</th>
                                    <th scope="col">Saldo</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pemindahan Dana Jurnal Bulan {{$previous_item['month']}}</td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($previous_item['total_in'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($previous_item['total_out'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($previous_item['saldo'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jurnal Kas Masuk</h4>
                    </div>
                    <div class="card-body">
                        <div class="w-100 mb-4">
                            @can('jurnal-harian add')
                            <button data-toggle="modal" data-target="#modalAddJurnalMasuk" class="btn btn-primary">Add Kas Masuk</button>
                            @endcan
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 25px;" scope="col">#</th>
                                        <th class="text-left" scope="col">Sumber</th>
                                        <th class="text-left" scope="col">Jumlah</th>
                                        <th class="text-center" scope="col">Total Akumulasi</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($item_jurnal_masuks as $key => $item_jurnal_masuk)
                                    @php
                                    $total_kas_masuk += $item_jurnal_masuk['jumlah'];
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item_jurnal_masuk->sumber}}</td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($item_jurnal_masuk['jumlah'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($total_kas_masuk, 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-center">
                                                @can('jurnal-harian update')
                                                <div>
                                                    <button wire:click="setJurnalMasuk({{$item_jurnal_masuk['id']}})" wire:target="setJurnalMasuk({{$item_jurnal_masuk['id']}})" data-toggle="modal" data-target="#modalEditJurnalMasuk" wire:loading.class="disabled btn-progress" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                </div>
                                                @endcan
                                                @can('jurnal-harian delete')
                                                <div class="ml-2">
                                                    <button data-id="{{$item_jurnal_masuk['id']}}" data-target="jurnal_masuk" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                                </div>
                                                @endcan
                                            </div>
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
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Jurnal Kas Keluar</h4>
                    </div>
                    <div class="card-body">
                        <div class="w-100 mb-4">
                            @can('jurnal-harian add')
                            <button data-toggle="modal" data-target="#modalAddJurnalKeluar" class="btn btn-primary">Add Jurnal Keluar</button>
                            @endcan
                            <button wire:click="exportToExcel" wire:target="exportToExcel" wire:loading.class="disabled btn-progress" class="btn btn-primary float-right">Export to Excel</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width: 25px;" scope="col">#</th>
                                        <th class="text-left" scope="col">Paket</th>
                                        <th class="text-left" scope="col">Nama</th>
                                        <th class="text-left" scope="col">Jumlah</th>
                                        <th class="text-center" scope="col">Harga Satuan</th>
                                        <th class="text-center" scope="col">Total</th>
                                        <th class="text-center" scope="col">Total Akumulasi</th>
                                        <th class="text-center" style="max-width: 80px" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($item_jurnals as $key => $item_jurnal)
                                    @php
                                    $total_kas_keluar += $item_jurnal['total_harga'];
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item_jurnal->paket->code}} - {{$item_jurnal->paket->nama}}</td>
                                        <td>{{$item_jurnal->nama}}</td>
                                        <td class="custom-w-180">{{$item_jurnal->jumlah}}</td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($item_jurnal['harga_satuan'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($item_jurnal['total_harga'], 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td class="custom-w-180">
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span>
                                                <span>{{number_format($total_kas_keluar, 0, ',', '.')}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @can('jurnal-harian update')
                                                <div>
                                                    <button wire:click="setUraian({{$item_jurnal['id']}})" wire:target="setUraian({{$item_jurnal['id']}})" data-toggle="modal" data-target="#modalEditUraian" wire:loading.class="disabled btn-progress" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                </div>
                                                @endcan
                                                @can('jurnal-harian delete')
                                                <div class="ml-2">
                                                    <button data-id="{{$item_jurnal['id']}}" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                                </div>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Empty</td>
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
    
    <div wire:ignore.self class="modal fade" role="dialog" id="modalAddJurnalMasuk">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jurnal Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addJurnalMasuk">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="input_sumber_material">Sumber</label>
                            <input wire:model.defer="jurnal_masuk_sumber" type="text" class="form-control" id="input_sumber_material" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_jumlah">Jumlah</label>
                            <input wire:model.defer="jurnal_masuk_jumlah" type="text" class="form-control" id="input_jumlah" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_masuk_date">Tanggal</label>
                            <input wire:model="input_tanggal" type="text" class="form-control form-date" name="input_masuk_date" id="input_date" />
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
    <div wire:ignore.self class="modal fade" role="dialog" id="modalAddJurnalKeluar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jurnal Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addItemJurnal">
                    <div class="modal-body">
                        <div wire:ignore class="form-group mb-3">
                            <label for="select_paket">Paket  <small class="text-danger">*</small></label>
                            <select id="select_paket" class="form-control select2 select-paket" required>
                                <option></option>
                                @foreach ($pakets as $paket)
                                <option value="{{$paket->id}}">{{$paket->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_nama_material">Nama</label>
                            <input wire:model.defer="item_nama" type="text" class="form-control" id="input_nama_material" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_volume">Jumlah</label>
                            <input wire:model.defer="item_jumlah" type="text" class="form-control" id="input_volume" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_harga_satuan">Harga Satuan</label>
                            <input wire:model.defer="item_harga_satuan" type="text" class="form-control" id="input_harga_satuan" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_date">Tanggal</label>
                            <input wire:model="input_tanggal" type="text" class="form-control form-date" name="input_date" id="input_date" />
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
    <div wire:ignore.self class="modal fade" role="dialog" id="modalEditUraian">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Uraian Jurnal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="updateUraian">
                    <div class="modal-body">
                        <div wire:ignore class="form-group mb-3">
                            <label for="select_paket_ed">Paket  <small class="text-danger">*</small></label>
                            <select id="select_paket_ed" class="form-control select2 select-paket" required>
                                <option></option>
                                @foreach ($pakets as $paket)
                                <option value="{{$paket->id}}">{{$paket->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_nama_material">Nama</label>
                            <input wire:model.defer="item_nama" type="text" class="form-control" id="input_nama_material" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_volume">Jumlah</label>
                            <input wire:model.defer="item_jumlah" type="text" class="form-control" id="input_volume" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_harga_satuan">Harga Satuan</label>
                            <input wire:model.defer="item_harga_satuan" type="text" class="form-control" id="input_harga_satuan" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" role="dialog" id="modalEditJurnalMasuk">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jurnal Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="updateJurnalMasuk">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="input_sumber_material">Sumber</label>
                            <input wire:model.defer="jurnal_masuk_sumber" type="text" class="form-control" id="input_sumber_material" required autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label for="input_jumlah">Jumlah</label>
                            <input wire:model.defer="jurnal_masuk_jumlah" type="text" class="form-control" id="input_jumlah" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:loading.class="disabled btn-progress" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('script')
{{-- <script src="{{ asset('assets/library/bootstrap_daterangepicker/daterangepicker.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/library/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

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
    
    $(document).ready(function() {
        $('.select-paket').select2({
            placeholder: 'Pilih Paket',
            width: '100%',
        })
        $("#datepicker").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });
        $('.form-date').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
        });
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
                if (target == 'jurnal_masuk') {
                    var data = await @this.deleteJurnalMasuk(id)
                } else {
                    var data = await @this.delete(id)
                }
                return data
            },
            allowOutsideClick: () => !Swal.fire.isLoading()
        }).then(async (result) => {
            if (result.value && result.value.status_code == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.value.message,
                });
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
    $('.select-paket').on('change', function() {
        value = $(this).val();
        Livewire.emit('evSetPaket', value);
    })
    
    $('#datepicker').on('change', function(event) {
        Livewire.emit('evSetTanggal', event.target.value);
    })
    
    $('.form-date').on('change', function(event) {
        Livewire.emit('evSetInputTanggal', event.target.value);
    })
    
    document.addEventListener('select2:reset', function (event) {
        $(event.detail.selector).val("").trigger("change")
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
