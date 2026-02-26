@extends('layouts.superadmin_app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card title="All Users" tab1="<a href='{{ route('users.create') }}' class='btn btn-primary '>Add New User</a>"
                classes="border border-info">
                <x-display-errors />

                <x-display-form-errors />
                
                <div class="table-responsive">

                    <x-fancy-table>
                        <x-fancy-table-head>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Since</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </x-fancy-table-head>

                        <x-fancy-table-body>
                            @php
                                $i = isset($_GET['page']) ? intval($_GET['page']) : 0;
                                $i++;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center text-muted">#{{ $i }}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="{{ $user->profileImageUrl() }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <a href="{{ route('users.edit', $user->id) }}">
                                                    <div class="widget-heading">{{ $user->name }}</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="badge badge-warning">{{ $user->role->role_name }}</div>
                                    </td>

                                    <td class="text-center">{{ $user->email }}</td>

                                    <td class="text-center">
                                        {{ $user->phone }}
                                    </td>
                                    <td class="text-center">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            View / Edit
                                        </a>

                                        @if ($user->role_id != 1)
                                            <button type="button" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </x-fancy-table-body>
                    </x-fancy-table>
                </div>

                <div class="mt-3 px-md-5">
                    {{ $users->links() }}
                </div>
            </x-card>
        </div>
    </div>
@endsection
