<script type="text/php">

    if (isset($pdf)) {
            $pdf->page_script('
                if ($PAGE_NUM == $PAGE_COUNT ) {
                    $font = $fontMetrics->get_font("helvetica", "normal");
                    $size = 9;
                    $pageText = __("transcript.end_transcript");
                    $pdf->text(260, 810, $pageText, $font, $size);
                } else {
                    $font = $fontMetrics->get_font("helvetica", "normal");
                    $size = 9;
                    $pageText = __("transcript.continued", ["num" => $PAGE_NUM + 1]);
                    $pdf->text(20, 810, $pageText, $font, $size);
                }

                $font = $fontMetrics->get_font("helvetica", "normal");
                $size = 9;
                $pageText = __("transcript.page", ["p1" => $PAGE_NUM, "p2" => $PAGE_COUNT]);
                $pdf->text(520, 810, $pageText, $font, $size);
            ');
    }

    </script>
