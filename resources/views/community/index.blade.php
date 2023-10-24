@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- Left column to show all the links in the DB --}}
        <div class="col-md-8">
            @if (count($links))

            @include('partials.column-link')

            @else

            <h3>No approved contributions yet</h3>

            @endif
        </div>
        {{-- Right column to show the form to upload a link --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Contribute a link</h3>
                </div>
                <div class="card-body">
                    @include('partials.add-link')
                </div>
            </div>

        </div>
    </div>
    {{ $links->links() }}
</div>
@stop