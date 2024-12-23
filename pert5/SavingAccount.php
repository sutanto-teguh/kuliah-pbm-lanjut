<?php
require 'BankAccount.php';
class SavingAccount extends BankAccount
{
private $interestRate;

    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
    }
	 public function addInterest()
    {
        // calculate interest
        $interest = $this->interestRate * $this->getBalance();
        // deposit interest to the balance
        $this->deposit($interest);
    }
}
$account = new SavingAccount();
$account->deposit(100);
// set interest rate
$account->setInterestRate(0.05);
$account->addInterest();
echo $account->getBalance();