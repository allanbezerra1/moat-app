@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success mb-4" href="{{ route('user.create') }}" title="Create a project">
                    New
                    </a>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>Full Name</th>
            <th>Name</th>
            <th>Role</th>
            <th>Date Created</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($user as $i=>$users)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $users->full_name }}</td>
                <td>{{ $users->name}}</td>
                <td>
                    @if(!empty($users->getRoleNames()))
                        @foreach($users->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td>{{ date_format($users->created_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('user.destroy', $users->id) }}" method="POST">

                        <a class="btn btn-success" href="{{ route('user.show', $users->id) }}" title="show">
                            show
                        </a>

                        <a class="btn btn-primary" href="{{ route('user.edit', $users->id) }}">
                            edit<i class="fas fa-edit fa-lg"></i>

                        </a>

                        @csrf
                        @method('DELETE')

                        <button  class="btn btn-danger" type="submit" title="delete">
                            Delete

                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{-- {!! $user->render() !!} --}}

@endsection
