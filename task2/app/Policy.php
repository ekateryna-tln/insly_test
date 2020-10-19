<?php

include_once 'PolicyInstallment.php';
include_once 'entity/PolicyEntity.php';

class Policy
{

	private $value;
	private $taxPersent;
	private $partCount;
	private $specHoursFrom = 15;
	private $specHoursTo = 20;
	private $specDay = 5;

	private $basePricePersentCurrent;
	private $basePricePersent = 11;
	private $basePricePersentSpec = 13;
	
	public function __construct(InputEntity $inputEntity)
	{
		$this->value = $inputEntity->value;
		$this->taxPersent = $inputEntity->taxPersent;
		$this->partCount = $inputEntity->partCount;
	}

	public function getPolicy($clientHours, $clientDay)
	{
		$this->setPriceBaseCurrent($clientHours, $clientDay);
		$basePrice = Helper::calculatePercent($this->value, $this->basePricePersentCurrent);
		$policyInstallment = new PolicyInstallment($this->taxPersent);
		$totalPolicy = $policyInstallment->getInstallment($basePrice);
		$instalmentList = [];
		if ($this->partCount == 1) {
			$instalmentList[] = $totalPolicy;
		} else {
			$instalment = $policyInstallment->getInstallment(ceil($basePrice / $this->partCount*100)/100);
			$lastElementId = $this->partCount-1;
			for ($i = 0; $i < $lastElementId; $i++) {
				$instalmentList[] = clone $instalment;
			}

			$instalmentList[$lastElementId] = $this->getLastInstalmentSum($totalPolicy, $instalmentList[0], $lastElementId);
		}

		$policyEntity = new PolicyEntity();
		$policyEntity->totalPolicy = $totalPolicy;
		$policyEntity->instalmentList = $instalmentList;
		$policyEntity->basePricePersent = $this->basePricePersentCurrent;
		
		return $policyEntity;
	}

	public function getLastInstalmentSum($totalPolicy, $partPolicy, $count)
	{
		$installment = new InstallmentEntity();
		
		$installment->basePrice = $totalPolicy->basePrice - $partPolicy->basePrice*$count;
		$installment->commission = $totalPolicy->commission - $partPolicy->commission*$count;
		$installment->tax = $totalPolicy->tax - $partPolicy->tax*$count;
		$installment->total = $totalPolicy->total - $partPolicy->total*$count;

		return $installment;
	}

	private function setPriceBaseCurrent($clientHours, $clientDay)
	{
		$this->basePricePersentCurrent = $this->basePricePersent;
		if (($clientDay == $this->specDay) 
				&& ($clientHours >= $this->specHoursFrom && $clientHours < $this->specHoursTo)
			) {
			$this->basePricePersentCurrent = $this->basePricePersentSpec;
		}
	}

}