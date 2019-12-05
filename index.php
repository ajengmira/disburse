<?php 
	include_once("controllers/Controller.php");
	
	$controller = new Controller();

	if(!isset($_GET['flip']))
	{
		$controller->list_data();
	}
	else
	{
		switch($_GET['flip'])
		{
			case 'create' : 
				$controller->create();
				break;
			
			case 'update' :
				$controller->update();
				break;

			case 'list' :
				$controller->list_data();
				break;

			default : 
				$controller->list_data();
				break;
		}
	}

?>