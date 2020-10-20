<?php 
	
	if (count($_POST) == 0) {
		require_once 'index.html';
		die;
	} else {
		include_once 'app/entity/InputEntity.php';
		include_once 'app/Policy.php';
		include_once 'app/Helper.php';

		$inputEntity = new InputEntity();
		$inputEntity->value = (int) $_POST['value'];
		$inputEntity->taxPersent = (int) $_POST['tax_persent'];
		$inputEntity->partCount = (int) $_POST['part_count'];
		
		if (!Helper::isValidInput($inputEntity)) {
			header('Content-type: application/json');
			$response = [
				'error' => 'Validation error'
			];
			echo json_encode($response);
			die;
		}

		$policy = new Policy($inputEntity);
		$response = [
			'policy' => $policy->getPolicy((int) $_POST['client_hours'], (int) $_POST['client_day']),
			'tax_persent' => $inputEntity->taxPersent,
			'value' => $inputEntity->value
		];

		header('Content-type: application/json');
		echo json_encode($response);
	}
