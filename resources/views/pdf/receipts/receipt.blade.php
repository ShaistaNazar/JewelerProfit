@extends('layouts.pdf')

@section('style')
<style>
@page {
    margin-top: 440px;
}
.header-full {
    margin-bottom: 0px !important;
    background: #fff !important;
}

.receipt-body{
    position:relative !important;
    padding-top:0px !important;
    margin-bottom: 0px !important;
    margin-top: 0 !important;
}
.table-responsive{
    margin-top: 0px !important;
    padding-top: 0px !important;
    margin-bottom: 0px !important;

}
.card-body,.card, #course-grades{
    margin-top: 0px !important;
    padding-top: 0px !important;
    margin-bottom: 0px !important;

}
.receipt-body > *{
    margin-top: 0px !important;
    padding-top: 0px !important;

}
.student-detials-table{
    margin-bottom: 0px !important;
}

</style>

@endsection

@section('content')

<header class="receipt-header header-full" >
    @include('pdf/receipts/_top'])
</header>

<main class="receipt-body">

    <div class="card" style="max-width: 795px;">

        <div class="card-body py-0">
            @if ($program['program_code'] == 'AAE')
            <div class="mb-3">
                <strong>@lang('receipt.aae_remarks_term')</strong>
            </div>
            @endif

            <div class="table-responsive">
                <table style="width:100%; mt-0" id="course-grades">
                    <thead>
                        <tr>
                            <th style="padding-left:15px; width: 70px">@lang('receipt.code')</th>
                            <th>@lang('receipt.course')</th>
                            <th class="text-center" style="width: 100px">@lang('receipt.percentage')</th>
                            <th class="text-center" style="width: 100px;">@lang('receipt.grade')</th>

                            @if ($program['program_code'] == 'DBA')
                            <th style="padding-right:15px; width: 100px" class="text-center">
                                @lang('receipt.sbs_credits')
                            </th>
                            @else
                            <th style="padding-right:15px; width: 100px" class="text-center">
                                @lang('receipt.ects_credits')
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $c)

                        <tr>
                            <td style="padding-left:15px">{{$c['course_code']}}</td>
                            <td>{{$c['course_title']}}</td>
                            <td class="text-center">{{$c['percentage']}}</td>
                            <td class="text-left" style="padding-left: 45px;">{{$c['descriptive_grade']}}</td>
                            @if ($program['program_code'] == 'DBA')
                            <td style="padding-right:15px" class="text-center">{{$c['sbs_credits']}}</td>
                            @else
                            <td style="padding-right:15px" class="text-center">{{$c['ects_credits']}}</td>
                            @endif
                        </tr>

                        @endforeach
                    </tbody>

                    <tfoot>

                        @if (count($secondary_courses))

                        <tr>
                            <th colspan="3"></th>
                            @if ($program['program_code'] == 'DBA')
                            <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">@lang('receipt.total')
                                <span class="font-weight-normal">{{$sbs_credits}}</span>
                            </th>
                            @else
                            <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">@lang('receipt.total')
                                <span class="font-weight-normal">{{$ects_credits}}</span>
                            </th>
                            @endif
                        </tr>

                        @endif

                        @if (!count($secondary_courses))

                        <tr>
                            <th colspan="3" style="padding-left:15px">@lang('receipt.grade_point_average', ['gpa'
                                => $gpa])</th>
                            @if ($program['program_code'] == 'DBA')
                            <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">
                                @lang('receipt.total')
                                <span class="font-weight-normal">{{$total_sbs_credits}}</span>
                            </th>
                            @else
                            <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">
                                @lang('receipt.total')
                                <span class="font-weight-normal">{{$total_ects_credits}}</span>
                            </th>
                            @endif
                        </tr>

                        @if ($program['program_code'] == 'AAE')
                        <tr>
							<th colspan="5" style="text-align: right; padding-right:49px">
                                @lang('receipt.aae_remarks_credit')<span class="font-weight-normal">120</span>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right; padding-right:49px">
                                @lang('receipt.total_ects')<span class="font-weight-normal">{{$total_ects_credits + 120}}</span>
                            </th>
                        </tr>
                        @endif

                        @endif
                    </tfoot>
                </table>
            </div>

            @include('pdf/receipts/_bottom')
        </div>
    </div>

</main>

@if (count($secondary_courses))
<div class="page-break"></div>

@endif

@endsection


@section('secondary-content')

@if (count($secondary_courses))

@php
$program = $secondary_program;
@endphp

<header class="receipt-header header-full" >
    @include('pdf/receipts/_top', ['academic_year' => $program['academic_year']])
</header>

<div class="card" style="max-width: 795px;">
    <div class="card-body py-0" style="position: relative;">

        @if (count($secondary_program) > 0 && $secondary_program['program_code'] == 'AAE')
        <div class="mb-3">
            <strong>@lang('receipt.aae_remarks_term')</strong>
        </div>
        @endif

        <div class="table-responsive">
            <table style="width:100%;" id="course-grades">
                <thead>
                    <tr>
                        <th style="padding-left:15px; width: 70px">@lang('receipt.code')</th>
                        <th>@lang('receipt.course')</th>
                        <th class="text-center" style="width: 100px">@lang('receipt.percentage')</th>
                        <th class="text-center" style="width: 100px;">@lang('receipt.grade')</th>
                        <th style="padding-right:15px; width: 100px" class="text-center">
                            @if ($program['program_code'] == 'DBA') @lang('receipt.sbs_credits') @else @lang('receipt.ects_credits') @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($secondary_courses as $c)
                    <tr>
                        <td style="padding-left:15px">{{$c['course_code']}}</td>
                        <td>{{$c['course_title']}}</td>
                        <td class="text-center">{{$c['percentage']}}</td>
                        <td class="text-left" style="padding-left: 45px;">{{$c['descriptive_grade']}}</td>
                        <td style="padding-right:15px" class="text-center">@if ($program['program_code'] == 'DBA'){{$c['sbs_credits']}}@else {{$c['ects_credits']}}  @endif</td>

                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3"></th>
                        @if ($program['program_code'] == 'DBA')
                        <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">@lang('receipt.total')
                            <span class="font-weight-normal">{{$secondary_sbs_credits}}</span>
                        </th>
                        @else
                        <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px">@lang('receipt.total')
                            <span class="font-weight-normal">{{$secondary_ects_credits}}</span>
                        </th>
                        @endif
                    </tr>
                    @if (count($secondary_program) && $secondary_program['program_code'] == 'AAE')
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="3" style="min-width: 100px; text-align: right; padding-right:55px">
                            @lang('receipt.aae_remarks_credit')<span class="font-weight-normal">120</span>
                        </th>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" style="padding-left:15px">@lang('receipt.grade_point_average',
                            ['gpa' => $gpa])</th>

                        <th colspan="2" style="min-width: 100px; text-align: right; padding-right:55px"> @if (count($secondary_program) && $secondary_program['program_code'] == 'DBA') @lang('receipt.total_sbs')
                            <span class="font-weight-normal">{{$total_sbs_credits}}</span>
                            @else @lang('receipt.total_ects')
                            <span class="font-weight-normal">{{$total_ects_credits}}</span>
                            @endif
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <p class="mt-3">
            <strong>@lang('receipt.page1')</strong>
        </p>

        @include('pdf/receipts/_bottom')
    </div>
</div>
@endif

@endsection


@section('page-number')
@if ($program['graduate'] == -1)
@include('pdf/receipts/_pages_with_legal_note')
@else
@include('pdf/receipts/_pages')
@endif
@endsection
