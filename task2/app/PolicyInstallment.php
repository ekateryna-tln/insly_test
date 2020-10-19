<?php

include_once 'entity/InstallmentEntity.php';

class PolicyInstallment
{

	private $commissionPersent = 17;
	private $taxPersent;

	public function __construct(int $taxPersent)
	{
		$this->taxPersent = $taxPersent;
	}

	public function getInstallment($basePrice)
	{
		$installmentEntity = new InstallmentEntity();
		$installmentEntity->basePrice = $basePrice;

		$installmentEntity->commission =
			Helper::calculatePercent($installmentEntity->basePrice, $this->commissionPersent);
		$installmentEntity->tax = Helper::calculatePercent($installmentEntity->basePrice, $this->taxPersent);
		$installmentEntity->total =
			$installmentEntity->basePrice +
			$installmentEntity->commission +
			$installmentEntity->tax;
			
		$installmentEntity->total = ceil($installmentEntity->total*100)/100;

		return $installmentEntity;
	}

}