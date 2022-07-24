@extends('layouts.app')
@section('content')
    <div class="row g-5">
        <div class="col-md-12 col-lg-12">
            @if (session('success'))
                <h3 class="mb-3">{{ session('success') }}</h3>
                <p>Minify url: <strong>{{ session('shortUrl') }}</strong></p>
            @endif


        </div>
        <div class="col-md-12 col-lg-12">
            <h4 class="mb-3">Complete Form</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="needs-validation
                @if ($errors->any())
                    was-invalidated
                @endif
                    " method="POST" action="{{ route('store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Url link to minify</label>
                        <input type="url" class="form-control
                        @error('original_url')
                                is-invalid
                        @enderror
                                " name="original_url" placeholder="Place Url link" value="{{ old('original_url') }}">
                        @error('original_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Limit redirects</label>
                        <div class="input-group has-validation">
                            <input type="number" class="form-control
                            @error('max_redirects')
                                    is-invalid
                            @enderror
                                    " name="max_redirects"
                                   placeholder="Limit transfers link from 0(unlimit) to 1000000"
                                   value="{{ old('max_redirects') }}">
                            @error('max_redirects')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Limit time</label>
                        <input type="number" class="form-control
                            @error('count_limit')
                                is-invalid
                            @enderror
                                " name="expired_limit"
                               placeholder="Time in minutes from 1 to 1440"
                               value="{{ old('expired_limit') }}">
                        @error('expired_limit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection