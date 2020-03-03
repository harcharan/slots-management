@extends('slots.layout')

@section('content')

    @if ( Session::has('success') )
        <div class="alert-success">
            {{ Session::get('success') }}
        </div>      
    @endif

    @if ( Session::has('error') )
        <div class="alert-danger">
            {{ Session::get('error') }}
        </div>      
    @endif

  <a href="{{ route('slots.create') }}" class="btn btn-success mb-2">Add</a> 
  <br>
   <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="laravel_crud">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Created at</th>
                        <td colspan="2">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                    <tr>
                        <td>{{ $slot->id }}</td>
                        <td>{{ date('m/d/Y', strtotime($slot->date)) }}</td>
                        <td>{{ date('h:i A', strtotime($slot->start)) }}</td>
                        <td>{{ date('h:i A', strtotime($slot->end)) }}</td>
                        <td>{{ date('Y-m-d', strtotime($slot->created_at)) }}</td>
                        <!-- <td><a href="{{ route('slots.edit', $slot->id)}}" class="btn btn-primary">Edit</a></td> -->
                        <td>
                            <form action="{{ route('slots.destroy', $slot->id)}}" method="post">
                                {{ csrf_field() }}
                                @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $slots->links() !!}
        </div> 
    </div>
@endsection