@extends('slots.layout')
 
@section('content')
<h2 style="margin-top: 12px;" class="text-center">Edit Slot</a></h2>
<br>
 
<form action="{{ route('slots.update', $slot_info->id) }}" method="POST" name="update_slot">
    {{ csrf_field() }}
    @method('PATCH')
     
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <strong>Date</strong>
                <input type="text" name="date" class="form-control datepicker" placeholder="Select Date" value="{{ $slot_info->date }}">
                <span class="text-danger">{{ $errors->first('date') }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <strong>Start Time</strong>
                <input type="text" name="start" class="form-control timepicker" placeholder="Select Start Time" value="{{ $slot_info->start }}">
                <span class="text-danger">{{ $errors->first('start') }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <strong>End Time</strong>
                <input type="text" name="end" class="form-control timepicker" placeholder="Select End Time" value="{{ $slot_info->end }}">
                <span class="text-danger">{{ $errors->first('end') }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
 
</form>

<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
    });
    $('.timepicker').timepicker();
</script>

@endsection