@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/library/select2/css/select2.min.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endsection

@section('css')
<style>
    .custom-max-w-180 {
        max-width: 180px;
    }
</style>
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Jurnal Keuangan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keuangan</a></div>
                <div class="breadcrumb-item">Jurnal Keuangan</div>
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
                <div x-show="control_tabs.keuangan" class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Table Jurnal Keuangan</h4>
                        </div>
                        <div class="card-body">
                            <button wire:click="openTabKwitansi" wire:target="openTabKwitansi" wire:loading.class="disabled btn-progress" class="btn btn-primary">Kwitansi</button>
                            <button class="btn btn-primary">Kas Besar</button>
                        </div>
                    </div>
                </div>
                <div :class="{ 'd-block': control_tabs.kwitansi }" class="col-12" style="display: none;">
                    <div class="w-100 mb-4">
                        <button wire:click="openTabKeuangan" class="btn btn-warning">Back</button>
                    </div>
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
                                    <button wire:click="setListKwitansi" wire:loading.class="disabled btn-progress" wire:target="setListKwitansi" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <button wire:click="resetInput" class="btn btn-link ml-3">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Example Card</h4>
                        </div>
                        <div class="card-body">
                            <div class="w-100 mb-4">
                                <button wire:click="exportToExcel" wire:target="exportToExcel" wire:loading.class="disabled btn-progress" class="btn btn-primary">Export to Excel</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-left" style="width: 25px;" scope="col">#</th>
                                            <th class="text-left" scope="col">Deskripsi</th>
                                            <th class="text-left" scope="col">Satuan</th>
                                            <th class="text-left" scope="col">Jumlah</th>
                                            <th class="text-left" style="width: 180px" scope="col">Harga Satuan</th>
                                            <th class="text-center" style="width: 180px" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($list_kwitansi as $key => $kwitansi)
                                        @foreach ($kwitansi['realisasi_danas'] as $re_key => $realisasi_dana)
                                        @if ($realisasi_dana['pengajuan'])
                                        <tr>
                                            <td>{{$re_key+1}}</td>
                                            <td>{{$realisasi_dana['format_code']}}</td>
                                            <td colspan="4">{{$realisasi_dana['pengajuan']['item']['nama']}}</td>
                                        </tr>
                                        @foreach ($realisasi_dana['pengajuan']['material_pengajuans'] as $mat_key => $material_pengajuan)
                                        <tr>
                                            <td>{{$re_key+1}}.{{$mat_key+1}}</td>
                                            <td>{{$material_pengajuan['material']['nama_material']}}</td>
                                            <td>{{$material_pengajuan['material']['ms_satuan']['satuan']}}</td>
                                            <td>{{$material_pengajuan['jumlah']}}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{number_format($material_pengajuan['harga_satuan'], 0, ',', '.')}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{number_format($material_pengajuan['total_harga'], 0, ',', '.')}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Empty</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


@push('script')
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
        $("#datepicker").datepicker( {
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });
    })
    $('.select-paket').on('change', function() {
        value = $(this).val();
        Livewire.emit('evSetPaket', value);
    })

    $('#datepicker').on('change', function(event) {
        Livewire.emit('evSetTanggal', event.target.value);
    })

    document.addEventListener('select2:reset', function (event) {
        $(event.detail.selector).val("").trigger("change")
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
