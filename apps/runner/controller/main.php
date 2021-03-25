<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;
	
	private $model;

	function checkphone($var)
	{
		$returnVal = $var;
    	$replacement = '+380';
    	$pattern = '/^(0|80|380|\+80|\+0)/';
    	$returnVal = preg_replace($pattern, $replacement, $returnVal, -1);
    	return $returnVal;
	}

	public function exec():?array {
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);

		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) 
				{
					$details = $methods[$path[2]];
					$request = [];
					foreach ($details['params'] as $param) {
						$file = ROOT . 'model/config/' . 'patterns' . '.php';
    					include $file;
						$var = $this->getVar($param['name'], $param['source']);

						if(!$var)
						{
							if($param['required'])
								throw new \Exception("REQUEST_INCOMPLETE", 1);
							else
							$request[$param['name']] = 'student';
						}

						else {
           					if($patterns[$param['pattern']] != '') {            
         		 				if (preg_match($patterns[$param['pattern']], $var))
              						$request[$param['name']] = $var;
        						else
              						throw new \Exception("REQUEST_INCORRECT", 1);     

        					} else {
								$request[$param['name']] = $var;
							}
				
							if(method_exists($this, 'check' . $param['name'])) {
								$method = [$this, 'check' . $param['name']];
								$request[$param['name']] = $method($var);
							}
						}
					}		
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];
						$result = $method($request);
					}

				}

			}
		}
		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this->getVar('HTTP_ORIGIN', 'e');
		$front = $this->getVar('FRONT', 'e');
		foreach ( [$front] as $domen )
			if ( $origin == "https://$domen") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}