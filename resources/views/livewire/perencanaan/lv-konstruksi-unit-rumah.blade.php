@section('css-libraries')
@endsection

@section('css')
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('perencanaan.index') }}">Perencanaan</a></div>
                <div class="breadcrumb-item">Konstruksi Unit Rumah</div>
            </div>
        </div>
        
        <div class="section-body">
            <div class="row">
                @forelse ($items as $key => $item)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <a class="text-decoration-none custom-color-inherit" href="{{ route($route_item_name, ['slug' => $item->slug_name]) }}">
                        <div class="card custom-card-folder">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                                </div>
                                <div class="w-100 mt-2">
                                    <h6 class="text-uppercase mb-0">{{ $converter_class::numberToRoman($key+1) }}. {{$item->name}}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                
                @endforelse
            </div>
        </div>
    </section>
</div>


@push('script')
@endpush
