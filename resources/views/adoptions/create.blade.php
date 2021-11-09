@extends('master')

@section('content')
    <div class="container">
        <div class="rows">
            <div class="col-6 offset-3">
                <div class="card shadow-sm mt-5">
                    <h5 class="card-header">Create Listing</h5>
                    <div class="card-body">
                        <form method="post" action="{{ route('adoptions.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name of pet</label>
                                <input type="text" class="form-control pet-name" id="name" value="{{ old('name') }}" name="name">
                                @if($errors->has('name'))
                                    <div class="form-text text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control pet-description" id="description" rows="2" name="description">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <div class="form-text text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input class="form-control pet-image" type="file" id="formFile" name="image">
                                @if($errors->has('image'))
                                    <div class="form-text text-danger">{{ $errors->first('image') }}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary adoption-submit">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
