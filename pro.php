<?php

class Profiler {

    private $probe_points = [];
    private $probe_lines = [];
    private $log_file = '/tmp/profiler.log';

    public function probe($bt = null)
    {
        if(is_null($bt)){
          $bt = debug_backtrace();
        }
        $this->probe_lines[]  = $bt[0]['line'];
        $this->probe_points[] = microtime(true);
    }

    public function probe_end()
    {
        $this->probe(debug_backtrace());

        $str = $_SERVER['REQUEST_URI']."\t";
        $str .= $_SERVER['REQUEST_METHOD']."\t";
        for($i=0; $i<count($this->probe_points) ; $i++){
          $str .= $this->probe_lines[$i]."\t";
          if($i < (count($this->probe_points) -1)){
            $str .= sprintf("%f\t", $this->probe_points[$i+1] - $this->probe_points[$i]); 
          }
        }
        $this->write_log($str);
    }

    private function write_log($str)
    {
        $fp = fopen($this->log_file, 'a');
        fwrite($fp, $str."\n");
        fclose($fp);
    }
}



