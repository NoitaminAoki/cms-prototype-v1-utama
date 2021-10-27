@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
@endsection

@section('css')
<style>
    .box-input-radio {
        min-width: 100px;
        padding-right: 10px;
    }
    .box-input-radio label, .box-input-radio input {
        cursor: pointer;
    }

    button.disabled, button:disabled, button[disabled] {
        cursor: not-allowed;
    }
</style>
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Kas Besar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keuangan</a></div>
                <div class="breadcrumb-item">Kas Besar</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddKasBesar">Add</button>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 25px;" scope="col">#</th>
                                <th class="text-left" scope="col">Tipe Transaksi</th>
                                <th class="text-left" scope="col">Kode Transaksi Bank</th>
                                <th class="text-left" scope="col">Sumber</th>
                                <th class="text-left" scope="col">Jumlah</th>
                                <th class="text-left" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kas_besars as $key => $kas_besar)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$kas_besar->tipe_transaksi}}</td>
                                <td>{{$kas_besar->kode_transaksi_bank}}</td>
                                <td>{{$kas_besar->sumber}}</td>
                                <td>{{number_format($kas_besar->jumlah, 0, ',', '.')}}</td>
                                <td>
                                    <button wire:click="setKasBesar({{$kas_besar->id}})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalUpdateKasBesar"><i class="fas fa-edit"></i></button>
                                    <button data-id="{{$kas_besar->id}}" class="btn btn-sm btn-danger btn-delete" {{($kas_besar->kode_transaksi_bank)? 'disabled' : ''}}><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
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
    </section>

    <div wire:ignore.self class="modal fade" role="dialog" id="modalAddKasBesar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kas Besar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addKasBesar">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Tipe Transaksi<small class="text-danger">*</small></label>
                            <div class="d-flex justify-content-start">
                                <div class="box-input-radio">
                                    <div class="form-check">
                                        <input wire:model.defer="input_tipe_transaksi" class="form-check-input" type="radio" name="radioTypeTransaction" id="radioTypeTransaction1" value="debit" checked="">
                                        <label class="form-check-label" for="radioTypeTransaction1">
                                            Debit
                                        </label>
                                    </div>
                                </div>
                                <div class="box-input-radio">
                                    <div class="form-check">
                                        <input wire:model.defer="input_tipe_transaksi" class="form-check-input" type="radio" name="radioTypeTransaction" id="radioTypeTransaction2" value="kredit">
                                        <label class="form-check-label" for="radioTypeTransaction2">
                                            Kredit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('input_tipe_transaksi')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="inputSumber">Sumber<small class="text-danger">*</small></label>
                            <input wire:model.defer="input_sumber" type="text" class="form-control" id="inputSumber" required autocomplete="off">
                        </div>
                        @error('input_sumber')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="inputJumlah">Jumlah<small class="text-danger">*</small></label>
                            <input wire:model.defer="input_jumlah" type="text" class="form-control" id="inputJumlah" required autocomplete="off">
                        </div>
                        @error('input_jumlah')
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
    <div wire:ignore.self class="modal fade" role="dialog" id="modalUpdateKasBesar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kas Besar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="updateKasBesar">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Tipe Transaksi<small class="text-danger">*</small></label>
                            <div class="d-flex justify-content-start">
                                <div class="box-input-radio">
                                    <div class="form-check">
                                        <input wire:model.defer="input_tipe_transaksi" class="form-check-input" type="radio" name="radioTypeTransaction" id="radioTypeTransaction1" value="debit" checked="">
                                        <label class="form-check-label" for="radioTypeTransaction1">
                                            Debit
                                        </label>
                                    </div>
                                </div>
                                <div class="box-input-radio">
                                    <div class="form-check">
                                        <input wire:model.defer="input_tipe_transaksi" class="form-check-input" type="radio" name="radioTypeTransaction" id="radioTypeTransaction2" value="kredit">
                                        <label class="form-check-label" for="radioTypeTransaction2">
                                            Kredit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('input_tipe_transaksi')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="inputKodeBank">Kode Transaksi Bank</label>
                            <input wire:model.defer="input_kode_transaksi_bank" type="text" class="form-control" id="inputKodeBank" autocomplete="off">
                        </div>
                        @error('input_kode_transaksi_bank')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="inputSumber">Sumber<small class="text-danger">*</small></label>
                            <input wire:model.defer="input_sumber" type="text" class="form-control" id="inputSumber" required autocomplete="off">
                        </div>
                        @error('input_sumber')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="inputJumlah">Jumlah<small class="text-danger">*</small></label>
                            <input wire:model.defer="input_jumlah" type="text" class="form-control" id="inputJumlah" required autocomplete="off">
                        </div>
                        @error('input_jumlah')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>

<script>
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).attr('data-id');
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
