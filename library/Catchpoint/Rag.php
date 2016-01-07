<?php
class Catchpoint_Rag
{
    public function Perf ($perf){
        if ($perf == '-') {
            $button = '<button type="button" class="btn btn-xs btn-default"> - </button>';
        }
        if ($perf > 0 && $perf <= 2000) {
            $button = '<button type="button" class="btn btn-xs btn-success">' . number_format($perf) . ' ms</button>';
        }

        if ($perf >2000 && $perf <=8000 ) {
            $button = '<button type="button" class="btn btn-xs btn-warning">' . number_format($perf) . ' ms</button>';
        }

        if ($perf >10000) {
            $button = '<button type="button" class="btn btn-xs btn-danger">' . number_format($perf) . ' ms</button>';
        }
        return $button;
    }

    public function Avail ($avail){
        if ($avail == 100) {
            $button = '<button type="button" class="btn btn-xs btn-success">' . $avail . '%</button>';
        }

        if ($avail <100 && $avail >= 99 ) {
            $button = '<button type="button" class="btn btn-xs btn-warning">' . $avail . ' %</button>';
        }

        if ($avail < 99) {
            $button = '<button type="button" class="btn btn-xs btn-danger">' . $avail . ' %</button>';
        }
        return $button;

    }
}
