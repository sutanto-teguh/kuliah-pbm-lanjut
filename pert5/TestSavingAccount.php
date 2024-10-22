<?php

require 'SavingAccount.php';

$account = new SavingAccount();
$account->deposit(100);
echo $account->getBalance();