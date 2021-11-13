@extends('master')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Adopt me
                    </div>

                    <div class="card-body">
                        <h5 class="card-title pet-name">{{ $adoption->name }}</h5>
                        <p class="card-text pet-description">{{ $adoption->description }}</p>
                        <p>Listed by: <b>{{ $adoption->listedBy->name }}</b></p>
                        <!-- Task 5 User, step 4: this form should not appear if the logged user is giving for adoption this pet -->
                        <!-- Task 6 User, step 4: this form should not appear if the pet was already adopted -->

                        @auth()
                        @if($adoption->listedBy->id != auth()->id())
                            <form method="post" action="{{ route('adoptions.adopt', [$adoption->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success pet-adopt">Adopt Now
                                </button>
                            </form>
                        @endif
                        @endauth

                        @if($adoption->adopted_by != null)
                            @if($adoption->adopted_by == auth()->id())
                                <p class="text-success">This pet has been adopted by you :)</p>
                            @else
                                <p class="text-danger">This pet has already been adopted.</p>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="ratio ratio-1x1 ">
                    <img src="{{ asset($adoption->image_path) }}"
                         class="card-img-top border border-2 border-dark rounded-3"
                         style="object-fit: cover" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
