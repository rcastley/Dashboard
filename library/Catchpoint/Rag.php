<?php
class Catchpoint_Rag
{
    public function Perf ($perf){
        if ($perf == '-') {
            $button = '<button type="button" class="btn btn-xs btn-default"> - </button>';
        }
        if ($perf > 0 && $perf <= 2) {
            $button = '<button type="button" class="btn btn-xs btn-success">' . $perf . ' s</button>';
        }
        
        if ($perf >2 && $perf <=4 ) {
            $button = '<button type="button" class="btn btn-xs btn-warning">' . $perf . ' s</button>';
        }
        
        if ($perf >4) {
            $button = '<button type="button" class="btn btn-xs btn-danger">' . $perf . ' s</button>';
        }
        return $button;
    }
    
    public function Avail ($avail){
        if ($avail == 100) {
            $button = '<button type="button" class="btn btn-xs btn-success">' . $avail . '%</button>';
        }
        
        if ($avail <100 && $avail >= 98 ) {
            $button = '<button type="button" class="btn btn-xs btn-warning">' . $avail . ' s</button>';
        }
        
        if ($avail < 98) {
            $button = '<button type="button" class="btn btn-xs btn-danger">' . $avail . ' s</button>';
        }
        return $button;
        
    }
}