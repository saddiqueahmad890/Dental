<!-- Calendar Modal -->
<style>
    .fc-toolbar {
        padding-block: 0px !important;
    }

    .fc-center h2 {
        font-size: 1rem !important;
    }

    .fc-day-grid-event .fc-content {
        white-space: normal !important;
    }
</style>
<div id="calendarModal" class="modal fade" role="dialog" style="max-height:645px; top:-20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size:1rem !important;">Calendar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Event Creation Modal -->
<div id="eventModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Event Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="eventForm" action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="eventId" name="id">
                    <div class="form-group">
                        <label for="eventTitle">Title:</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventStartDate">Start Date:</label>
                                <input type="date" class="form-control" id="eventStartDate" name="start_date"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventEndDate">End Date:</label>
                                <input type="date" class="form-control" id="eventEndDate" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventStartTime">Start Time:</label>
                                <input type="time" class="form-control" id="eventStartTime" name="start_time"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eventEndTime">End Time:</label>
                                <input type="time" class="form-control" id="eventEndTime" name="end_time" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="save" class="btn btn-primary">Save Event</button>
                    <button type="button" id="deleteEventButton" class="btn btn-danger" style="display: none;">Delete
                        Event</button>

                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#eventForm').parsley();

        function clearForm() {
            $('#eventForm')[0].reset();
            $('#eventId').val('');
            $('#deleteEventButton').hide();
        }


        $('#calendar').fullCalendar({
            selectable: true,
            selectHelper: true,
            select: function(start) {
                clearForm();
                var startDate = moment(start).format('YYYY-MM-DD');
                var startTime = moment(start).format('HH:mm');
                $('#eventStartDate').val(startDate);
                $('#eventStartTime').val(startTime);
                $('#eventEndDate').val(startDate);
                $('#eventEndTime').val(startTime);
                $('#eventModal').modal('toggle');
            },
            header: {
                left: 'month,agendaWeek,agendaDay,list',
                center: 'title',
                right: 'prev,today,next'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: '{{ route('events.load') }}',
                    method: 'GET',
                    data: {
                        start: start.format(),
                        end: end.format()
                    },

                     success: function(data) {
        var events = data.map(function(event) {
            return {
                id: event.id,
                title: event.title,
                start: event.start_date,
                end: event.end_date,
                type: event.eventtype // Ensure 'type' is included
            };
        });
        callback(events);
    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching events:', error);
                    }
                });
            },
            eventRender: function(event, element) {
                // Ensure only the event title is displayed
                element.find('.fc-title').html(event.title);

                // Set the background color based on the event type
                var color;
                switch (event.type) {
                    case 'appointment':
                        color = 'yellow';
                        break;
                    case 'task':
                        color = '#94ef94';
                        break;
                    default:
                        color = 'lightgray'; // Replace with your default color
                }

                // Apply the background color to the .fc-content class
                element.find('.fc-content').css('background-color', color);
            },
            eventClick: function(calEvent) {
                clearForm(); // Clear the form before populating it with event data
                // Fetch event details via AJAX
                $.ajax({
                    url: '{{ route('events.show', ':id') }}'.replace(':id', calEvent.id),
                    method: 'GET',
                    success: function(event) {
                        // Populate the modal with fetched event data
                        $('#eventId').val(event.id);
                        $('#eventTitle').val(event.title);
                        $('#description').val(event.description);
                        $('#eventStartDate').val(event.start_date);
                        $('#eventStartTime').val(event.start_time);
                        $('#eventEndDate').val(event.end_date);
                        $('#eventEndTime').val(event.end_time);

                        // Show the modal for event editing
                        $('#eventModal').modal();
                        // $('#deleteEventButton').show(); // Show the delete button when editing an existing event
                        switch (event.eventtype) {
                            case 'appointment':
                                $('#deleteEventButton')
                            .hide(); // Hide the button for 'appointment'
                                $('#save').hide(); // Hide the button for 'appointment'
                                break;
                            case 'task':
                                $('#deleteEventButton')
                            .hide(); // Show the button for 'task'
                                $('#save').hide(); // Show the button for 'task'
                                break;
                            default:
                                $('#deleteEventButton')
                            .show(); // Default action to hide the button
                                $('#save').show(); // Default action to hide the button
                                break;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching event details:', error);
                    }
                });
            }
        });

        // Show calendar modal and go to today's date
        $('#calendarModal').on('shown.bs.modal', function() {
            $('#calendar').fullCalendar('gotoDate', new Date());
        });

        // Add form submission handler
        $('#eventForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Custom validation for start date/time and end date/time
            var startDate = $('#eventStartDate').val();
            var startTime = $('#eventStartTime').val();
            var endDate = $('#eventEndDate').val();
            var endTime = $('#eventEndTime').val();

            var startDateTime = moment(startDate + ' ' + startTime);
            var endDateTime = moment(endDate + ' ' + endTime);

            if (startDateTime.isAfter(endDateTime)) {
                alert('Start date and time must be before end date and time.');
                return;
            }

            var formData = $(this).serialize(); // Serialize form data
            var url = $('#eventId').val() ? '{{ route('events.update', ':id') }}'.replace(':id', $(
                '#eventId').val()) : '{{ route('events.store') }}';
            var method = $('#eventId').val() ? 'PUT' : 'POST'; // Determine if it's PUT or POST

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    // Refresh calendar
                    $('#calendar').fullCalendar('refetchEvents');
                    // Clear form inputs
                    clearForm();
                    // Close modal
                    $('#eventModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error:', error);
                }
            });
        });

        // Add event deletion handler
        $('#deleteEventButton').click(function() {
            var eventId = $('#eventId').val();
            if (eventId) {
                if (confirm('Are you sure you want to delete this event?')) {
                    $.ajax({
                        url: '{{ route('events.destroy', ':id') }}'.replace(':id', eventId),
                        method: 'DELETE',
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            // Refresh calendar
                            $('#calendar').fullCalendar('refetchEvents');
                            // Clear form inputs
                            clearForm();
                            // Close modal
                            $('#eventModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error('Error:', error);
                        }
                    });
                }
            }
        });
    });
</script>


