<div style="margin-top: 20px;">

    @if ($student['partner_code'] != 'SBS' && $student['partner_campus_location'])
    <div class="mb-3">
        @if($student['partner_code'] == 'HKMA')
        @lang('transcript.hkma_institute')
        @else
        @lang('transcript.campus_attended') {{$student['campus_attended']}}
        @endif
    </div>
    @endif

    <div style="display: block; width: 72%; float:left">
        <p class="mb-0">
            <strong>
                @if ($program['graduate'] == 0)

                @lang('transcript.not_obtained_text')

                @else

                @lang('transcript.degree_date') {{$program['graduation_date']}}

                @endif
            </strong>
        </p>

        <p>@lang('transcript.document_issued_text') {{$student['partner_campus_location']}},
            {{$student['country']}}</p>

        @if($program['program_code'] != 'DBA')
        <p>
            <strong>@lang('transcript.introduced')</strong>
        </p>
        @endif
    </div>

    <div style="display: block; width: 25%; text-align: center; float:right">
        <p><strong>@lang('transcript.registrar')</strong></p>
        <p>&nbsp;</p>
        <p><strong>{{$registrar}}</strong></p>
    </div>
</div>
