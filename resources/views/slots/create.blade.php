@extends('slots.layout')
 
@section('content')
<h2 style="margin-top: 12px;" class="text-center">Add Slot</a></h2>
<br>
 
<form action="{{ route('slots.store') }}" method="POST" id="add_slot">
    {{ csrf_field() }}
 
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <strong>Date</strong>
                <input type="text" name="date" class="form-control datepicker" placeholder="Select Date" autocomplete="off">
                <span class="text-danger">{{ $errors->first('date') }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <strong>Start Time</strong>
                <input type="text" name="start" class="form-control timepicker" placeholder="Select Start Time" autocomplete="off">
                <span class="text-danger">{{ $errors->first('start') }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <strong>End Time</strong>
                <input type="text" name="end" class="form-control timepicker" placeholder="Select End Time" autocomplete="off">
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

    $("#add_slot")
    // .submit(function(e) {
    //     e.preventDefault();
    // })
    .validate({
        rules:{
            date:{
                required: true
            },  
            start:{
                required: true
            },   
            end:{
                required: true
            }, 
        },
        messages:{           
            date:{
                required: 'Please select date.'
            },
            start: {
                required: 'Please enter start time.'
            }, 
            end: {
                required: 'Please enter end time.'
            },
        },
        errorElement:"span",
        errorClass:"text-danger",
        submitHandler: function(form) {
            var form_data = $('#add_slot').serialize();
            var url = "{{ route('checkSlot') }}";
            $.ajax({
                type: 'GET',
                url: url,
                data: form_data,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(!response) {
                        form.submit();
                    } else {
                        $.growl.error({title: "Oops!", message: 'Slot not available for selected date and time.' });
                    }
                }
            });
            return false;
        }
    });
</script>

@endsection