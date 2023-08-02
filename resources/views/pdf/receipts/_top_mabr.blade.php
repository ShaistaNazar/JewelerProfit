<div class="text-center" style="margin-top: 110px">
    <h2 class="text-uppercase font-weight-bold mb-0">
    @if($program['graduate'] == 0)
        @lang('transcript.provisional_transcript')
    @else
        &nbsp;
    @endif
    </h2>
    <p><small class="font-weight-bold">@lang('transcript.valid_seal')</small></p>
    <p class="mb-0"><strong>{{$program['code']}}</strong></p>  
    <p class="mb-0">Master of Applied Business Research</p>   
    <p class="mb-0">@lang('transcript.major') Applied Business Research</p>

    <p class="mb-0 font-weight-bold"><small class="font-weight-normal">@lang('transcript.academic_year')</small><br>
        {{$academic_year}}</p>
</div>

<table id="student-detials-table" style="margin-bottom: 10px;">
    <tr>
        <td>@lang('transcript.student_name')</td>
        <th>{{$student['name']}}</th>
    </tr>
    <tr>
        <td>@lang('transcript.student_number')</td>
        <th>{{$student['student_number']}}</th>
    </tr>
    <tr>
        <td>@lang('transcript.birth_date')</td>
        <th>{{$student['birth_date']}}</th>
    </tr>
    <tr style="white-space: nowrap;">
        <td>@lang('transcript.birth_place')</td>
        <th>{{$student['birth_place']}}</th>
    </tr>
    <tr>
        <td>@lang('transcript.report_date')</td>
        <th>{{$report_date}}</th>
    </tr>
</table>
