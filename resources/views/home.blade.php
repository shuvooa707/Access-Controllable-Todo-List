@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card todo-container">
                <div class="overlay hide"></div>
                <table class="table">
                    <thead>
                        <tr class="" style="border-bottom: 1px solid black;">
                            <td colspan="4">
                                <div class="form-group">
                                    <input type="text" class="form-control" oninput="search(this)" placeholder="search...">
                                </div>
                            </td>
                            {{-- <td class="hide">
                                <div class="form-group">
                                    <select name="" id="" class="form-control">
                                        <option value="-1">All</option>
                                        <option value="1">Public</option>
                                        <option value="2">Only me</option>
                                        <option value="3">Custom</option>
                                    </select>
                                </div>
                            </td> --}}
                            <td colspan="2" class="text-right">
                                <button class="btn btn-success" onclick="$('#addTaskModal').modal('show')">
                                    <i class="fas fa-plus"></i>
                                    Add Task
                                </button>
                            </td>
                        </tr>
                        <tr class="bg-dark text-light">
                            <th class="text-center px-1 task-number">#</th>
                            <th class="text-center px-1 task-status">
                                <i class="fas fa-"></i>
                                Done
                            </th>
                            <th class="text-center task-name" colspan="2">Task</th>
                            <th class="text-center task-action">Action</th>
                            <th class="text-center task-visibility px-1">
                                Visibility
                            </th>
                            {{-- <th class="text-center task-author">Author</th> --}}
                        </tr>
                    </thead>
                    <tbody class="task-container">
                        @foreach ($todos as $todo)
                        <tr class="text-center" id="task-{{$todo->id}}" data-status="{{$todo->status}}" data-visibility="{{$todo->visibility}}">
                            <td class="px-1">
                                <span class="task-number">{{ $loop->index+1 }}</span>
                            </td>
                            <td class="text-center px-1">
                                <div class="form-check text-center">
                                    <input onchange="taskChange({{$todo->id}})" class="form-check-input status-checkbox mt-2" type="checkbox" value="" id="flexCheckDefault" {{ $todo->status ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td colspan="2" class="task-name {{ $todo->status ? 'done' : '' }}">{{ $todo->name }}</td>
                            <td class="">
                                @can( "modify", $todo )
                                <i class="fas fa-pen mr-2 cursor-pointer" onclick="editTask({{$todo->id}})"></i>
                                <i class="fas fa-trash-alt text-danger cursor-pointer" onclick="deleteTask({{$todo->id}})"></i>
                                @else
                                <i class="fas fa-lock"></i>
                                @endcan
                            </td>
                            <td class="visibility-tag">
                                <span
                                class=" badge border border-{{ $todo->visibility == 1 ? 'success' : ''  }}  border-{{ $todo->visibility == 2 ? 'danger' : ''  }}  border-{{ $todo->visibility == 3 ? 'primary' : ''  }} p-1">
                                    {{ $todo->visibilitytag() }}
                                    @if ( $todo->visibility == 1 )
                                        <i class="fas fa-users ml-1"></i>
                                    @endif
                                    @if ( $todo->visibility == 2 )
                                        <i class="fas fa-lock"></i>
                                    @endif
                                    @if ( $todo->visibility == 3 )
                                        <i class="fas fa-cog" data-permitted-user="{{ $todo->permittedUsers->pluck('id') }}"></i>
                                    @endif
                                </span>
                            </td>
                            {{-- <td>
                                {{ $todo->user->name }}
                            </td> --}}
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- modal inclusion --}}
@include("modal")
{{-- /modal inclusion --}}

@endsection
