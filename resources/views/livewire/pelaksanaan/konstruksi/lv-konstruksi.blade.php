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
            <h1>Divisi Konstruksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.index') }}">Pelaksanaan</a></div>
                <div class="breadcrumb-item">Divisi Konstruksi</div>
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
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.laporan_harian.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    A. Laporan Kegiatan Harian Proyek
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.progress_kemajuan.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    B. Progress Kemajuan Proyek
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.photo_kegiatan.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    C. Photo Kegiatan Lapangan
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.control_stock.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    D. Control Stock Material
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.resume_kegiatan.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    E. Resume Kegiatan Bulanan Proyek
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.konstruksi.perjanjian_kontrak.index') }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    F. Perjanjian Kontrak Pekerjaan Konstruksi
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
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
