<?php
class api extends BaseController {

	  private $BIND_HOME = '/etc/bind/';

	  public function index() {

	  	     throw new ApplicationException('Invalid Request');
	  }

	  public function update($host, $oldip, $newip) {

	  		 if(!filter_var($oldip, FILTER_VALIDATE_IP)) {

	  		 	if($oldip == 'null') $oldip = '([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})';
	  		 	else throw new ApplicationException('Invalid IP address');
	  		 }

	  		 $pieces = explode('.', $host);
	  		 $hostname = array_shift($pieces);
	  		 $zone = implode('.', $pieces);

	  		 $data = $this->load($zone);

	  	     $pattern = "/$hostname\s+IN\s+A\s+$oldip$/im";
	  		 $replacement = "$hostname\tIN\tA\t$newip";

	  		 $data = preg_replace($pattern, $replacement, $data);

	  	     if($data === null) throw new ApplicationException('Could not update zone file');

	  	     $this->write($zone, $data);
	  	     //$this->reload();

	  	     echo 'success';
	  }

	  private function load($zone) {

	  		 $file = $this->BIND_HOME . $zone;
			 $handle = fopen($file, 'r');
			 $data = fread($handle,filesize($file));
			 fclose($handle);

			 return $data;
	  }

	  public function write($zone, $data) {

	  		 $file = $this->BIND_HOME . $zone;
			 $handle = fopen($file, 'w');
			 fwrite($handle, $data);
			 fclose($handle);
	  }

	  public function reload() {

	  		 passthru('/usr/sbin/rndc reload', $result);
	  }
}
?>