@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach (['danger', 'warning', 'success', 'info'] as $key)
                @if(Session::has($key))
                    <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                @endif
            @endforeach
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Hi {{ ucfirst(\Auth::user()->name) }}, {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    @if(\Auth::user()->role == 'admin' || \Auth::user()->role == 'principal' || \Auth::user()->role == 'registrar')
        <div class="row text-center">
            <div class="col-12 p-4"></div>
            <div class="col-12">
                <table class="table table-responseive">
                    <thead>
                        <tr>
                            <td>User Id</td>
                            <td>Name</td>
                            <td>Role</td>
                            <td>Unique Token</td>
                            <td>Status</td>
                            <td>Registered On</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if(!empty($user->token))
                                {{ substr($user->token, 0, 10) }}...
                                @endif
                            </td>
                            <td>{{ $user->status }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'principal')
                                    @if(!empty($user->token))
                                        @if (empty($user->status) || $user->status == 'deactive')
                                            <a href="/user/{{ $user->id }}/update-status/active" class="btn btn-primary">Approve</a>
                                        @else
                                            <a href="/user/{{ $user->id }}/update-status/deactive" class="btn btn-danger">Deactivate</a>
                                        @endif
                                    @endif
                                @endif
                                @if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'registrar')
                                    @if (empty($user->token))
                                        <a href="/user/{{ $user->id }}/generate-token" class="btn btn-primary">Generate Token</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 p-2"></div>
        </div>
        <div class="row justify-content-center">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
