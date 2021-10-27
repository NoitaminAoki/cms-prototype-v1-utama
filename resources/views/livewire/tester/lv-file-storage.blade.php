@section('css-libraries')
@endsection

@section('css')
@endsection

<div>
    <section class="section">
        <div class="section-header">
            <h1>Wilayah</h1>
            <div class="section-header-breadcrumb">
            </div>
        </div>
        
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                {{app_path();}}
                                <br>
                                {{public_path();}}
                                <br>
                                {{base_path('..\\avatar-1.png');}}
                                <br>
                                {{storage_path();}}
                            </p>
                            <img src="{{public_path().'/../../avatar-1.png'}}" class="w-100">
                            <button wire:click="createDir" class="btn btn-primary">Test</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@push('script')
@endpush
