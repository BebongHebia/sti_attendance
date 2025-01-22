<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    @php
        $event = App\Models\Event::find($event_id);
        $section = App\Models\SySection::find($section_id);
    @endphp

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-sm-12">
                <h4 class="text-center">STI Malaybalay</h4>
                <h5 class="text-center"><span style="color:red">{{ $event->event }}</span></h5>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <p class="text-start">Section : <b><span style="color:red">{{ $section->section_name }}</span></b></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <th>No.#</th>
                        <th>Student</th>

                        @php
                            $get_event_attendance = App\Models\Attendance::where('event_id', $event_id)->get();
                        @endphp

                        @foreach ($get_event_attendance as $item_get_event_attendance)
                            <th>{{ $item_get_event_attendance->att_type }}</th>
                        @endforeach
                    </thead>
                    <tbody>
                        @php
                            $get_section_member = App\Models\SchoolYearSectionDetails::where('sys_id', $section_id)->get();
                        @endphp

                        @foreach ($get_section_member as $item_get_section_member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item_get_section_member->get_student->complete_name }}</td>

                                @foreach ($get_event_attendance as $item_get_event_attendance)

                                    @php
                                        $get_attendance = App\Models\AttendanceDetail::where('sys_d_id', $item_get_section_member->id)->where('attendance_id', $item_get_event_attendance->id)->count();
                                        $get_attendance_info = App\Models\AttendanceDetail::where('sys_d_id', $item_get_section_member->id)->where('attendance_id', $item_get_event_attendance->id)->latest()->first();

                                    @endphp

                                    @if ($get_attendance == 0)
                                        <td style="color:red"><b>Absent</b></td>
                                    @else
                                        <td style="color:green">
                                            <b>Present</b>
                                            {{ $get_attendance_info->created_at->format('m/d/Y h:i A') }}
                                        </td>

                                    @endif

                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>
</html>
