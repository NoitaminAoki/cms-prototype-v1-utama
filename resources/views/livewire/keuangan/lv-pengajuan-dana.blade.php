@section('css-library')
<link rel="stylesheet" href="{{ asset('assets/library/sweetalert2/css/sweetalert2.min.css') }}">
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan Dana</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Keuangan</a></div>
                <div class="breadcrumb-item">Pengajuan Dana</div>
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
            <div class="card">
                <div class="card-header">
                    <h4>Table Pengajuan Dana</h4>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <a href="{{ route('keuangan.pengajuan_dana.create') }}" class="btn btn-primary">Buat Pengajuan</a>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Paket</th>
                                <th scope="col">Item</th>
                                <th style="width: 200px;" scope="col">Total Harga Material</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuan_danas as $key => $pengajuan_dana)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td> {{$pengajuan_dana->paket->code}} - {{$pengajuan_dana->paket->nama}} </td>
                                <td> {{$pengajuan_dana->item->nama}} </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span>{{number_format($pengajuan_dana->total_harga_material, 0, ',', '.')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
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
</div>


@push('script')
<script src="{{ asset('assets/library/sweetalert2/js/sweetalert2.min.js') }}"></script>

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
