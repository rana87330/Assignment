@extends('layouts.master-without-nav')
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                <div class="card-body px-5 py-5">
                    <h3 class="card-title text-left mb-3">Login</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username or Email *</label>
                            <input id="username" type="text" class="form-control p_input @error('username') is-invalid @enderror @error('email') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" placeholder="Please enter Username or Email" required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password *</label>
                            <input id="password" type="password" class="form-control p_input @error('password') is-invalid @enderror" 
                            name="password" placeholder="Please Enter Password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> <strong> Rana87330</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
    @section('script')
        <script src="{{ url('/assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ url('/assets/js/off-canvas.js') }}"></script>
        <script src="{{ url('/assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ url('/assets/js/misc.js') }}"></script>
        <script src="{{ url('/assets/js/settings.js') }}"></script>
        <script src="{{ url('/assets/js/todolist.js') }}"></script>
    @endsection
@endsection