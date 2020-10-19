<?php

include_once 'PolicyInstallment.php';
include_once 'entity/PolicyEntity.php';

class Policy
{

	private int $value;
	private int $taxPersent;
	private int $partCount;
	private int $specHoursFrom = 15;
	private int $specHoursTo = 20;
	private int $specDay = 5;

	private int $basePricePersentCurrent;
	private int $basePricePersent = 11;
	private int $basePricePersentSpec = 13;
	
	public function __construct(InputEntity $inputEntity)
	{
		$this->value = $inputEntity->value;
		$this->taxPersent = $inputEntity->taxPersent;
		$this->partCount = $inputEntity->partCount;
	}

	public function getPolicy(int $clientHours, int $clientDay)
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

	public function getLastInstalmentSum(InstallmentEntity $totalPolicy, InstallmentEntity $partPolicy, int $count)
	{
		$installment = new InstallmentEntity();
		
		$installment->basePrice = $totalPolicy->basePrice - $partPolicy->basePrice*$count;
		$installment->commission = $totalPolicy->commission - $partPolicy->commission*$count;
		$installment->tax = $totalPolicy->tax - $partPolicy->tax*$count;
		$installment->total = $totalPolicy->total - $partPolicy->total*$count;

		return $installment;
	}

	private function setPriceBaseCurrent(int $clientHours, int $clientDay)
	{
		$this->basePricePersentCurrent = $this->basePricePersent;
		if (($clientDay == $this->specDay) 
				&& ($clientHours >= $this->specHoursFrom && $clientHours < $this->specHoursTo)
			) {
			$this->basePricePersentCurrent = $this->basePricePersentSpec;
		}
	}

}