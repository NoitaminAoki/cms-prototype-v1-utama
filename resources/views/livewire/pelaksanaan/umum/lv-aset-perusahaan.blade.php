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
            <h1>Aset Perusahaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.index') }}">Pelaksanaan</a></div>
                <div class="breadcrumb-item"><a href="{{ route('pelaksanaan.umum.index') }}">Divisi Umum</a></div>
                <div class="breadcrumb-item">Aset Perusahaan</div>
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
                                    @forelse ($items as $key => $item)
                                    <tr class="border-bottom">
                                        <td>
                                            <a class="text-decoration-none custom-color-inherit" href="{{ route($route_item_name, ['slug' => $item->slug_name]) }}">
                                                <h6 class="text-uppercase mb-0">
                                                    <i class="fas fa-folder custom-fa-1x-2 custom-bg-folder ml-0 mr-2"></i>
                                                    {{ $converter_class::numberToRoman($key+1) }}. {{$item->name}}
                                                </h6>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center text-muted">
                                            Empty    
                                        </td> 
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
</div>


@push('script')
@endpush
