@section('css-libraries')
@endsection

@section('css')
<style>
    .custom-table-folder td {
        height: 40px !important;
    }
</style>
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Divisi Keuangan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.index') }}">Pelaksanaan</a></div>
                <div class="breadcrumb-item">Divisi Keuangan</div>
            </div>
        </div>
        
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0 shadow-none border-bottom">
                        <div class="card-body py-3">
                            <h6 class="text-dark font-weight-normal mb-0">
                                Name
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table custom-table-folder mb-0">
                                <tbody>
                                    @can('pengajuan-dana add')
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.keuangan.pengajuan_dana.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    A. Pengajuan Anggaran Proyek
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    @endcan
                                    @can('realisasi-dana add')
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.keuangan.realisasi_dana.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    B. Realisasi Dana Masuk
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    @endcan
                                    @can('jurnal-harian add')
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.keuangan.jurnal_keuangan.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    C. Jurnal Keuangan Proyek
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    @endcan
                                    @can('progress-keuangan add')
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.keuangan.progress_keuangan.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    D. Posisi Keuangan dan Progres Pekerjaan Lapangan
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    @endcan
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@push('script')
@endpush
