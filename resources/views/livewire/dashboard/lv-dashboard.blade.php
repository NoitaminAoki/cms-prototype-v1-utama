@section('css-libraries')
@endsection

@section('css')
@endsection

<div>
  <section class="section">
    <div class="section-header">
      <h1>Top Navigation</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      </div>
    </div>
    
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
          <a class="text-decoration-none custom-color-inherit" href="{{ route('perencanaan.index') }}">
            <div class="card custom-card-folder">
              <div class="card-body">
                <div class="text-center">
                  <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                </div>
                <div class="w-100 mt-2">
                  <h6 class="text-uppercase mb-0">A. Perencanaan Proyek</h6>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
          <a class="text-decoration-none custom-color-inherit" href="{{ route('pelaksanaan.index') }}">
            <div class="card custom-card-folder">
              <div class="card-body">
                <div class="text-center">
                  <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                </div>
                <div class="w-100 mt-2">
                  <h6 class="text-uppercase mb-0">B. Pelaksanaan Proyek</h6>
                </div>
              </div>
            </div>
          </a>
        </div>
        @auth('admin')
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
          <a class="text-decoration-none custom-color-inherit" href="{{ route('master.index') }}">
            <div class="card custom-card-folder">
              <div class="card-body">
                <div class="text-center">
                  <i class="fas fa-folder custom-fa-10x custom-bg-folder"></i>
                </div>
                <div class="w-100 mt-2">
                  <h6 class="text-uppercase mb-0">Master Admin</h6>
                </div>
              </div>
            </div>
          </a>
        </div>
        @endauth
      </div>
    </div>
  </section>
</div>


@push('script')
@endpush
