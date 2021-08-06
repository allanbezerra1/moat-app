@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Update Album</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('album.index') }}" title="Go back"> Back</a>
            </div>
        </div>
    </div>
    <x-alert></x-alert>
    <form action="{{ route('album.update', $album->id) }}" method="POST" >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Artist:</strong>
                    <select class="form form-control" id="" name="artist" value={{ $album->artist }}>
                        @foreach ($newArtist as $artists )
                            <option value="{{ $artists->name }}">{{ $artists->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Album name:</strong>
                    <input type="text" name="name" class="form-control" value="{{ $album->name }}" placeholder="Album name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Year:</strong>
                    <input type="number" name="year" class="form-control" value="{{ $album->year }}" placeholder="Year">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
