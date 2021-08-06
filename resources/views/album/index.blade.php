@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Albums</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-4" href="{{ route('album.create') }}" title="Create a project">
                    New Album
                    </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Artist</th>
            <th>Album Name</th>
            <th>Year</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($album as $i=>$albums)
            <tr>
                <td>{{ $albums->artist}}</td>
                <td>{{ $albums->name}}</td>
                <td>{{ $albums->year}}</td>
                <td>
                    <form action="{{ route('album.destroy', $albums->id) }}" method="POST">
                        <a class="btn btn-success" href="{{ route('album.show', $albums->id) }}" title="show">
                            show
                        </a>
                        <a class="btn btn-primary" href="{{ route('album.edit', $albums->id) }}">
                            edit<i class="fas fa-edit fa-lg"></i>
                        </a>
                        @can('album-delete')
                            @csrf
                            @method('DELETE')
                            <button  class="btn btn-danger" type="submit" title="delete">
                                Delete
                            </button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{-- {!! $album->render() !!} --}}

@endsection
