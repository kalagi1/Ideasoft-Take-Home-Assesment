<?php

namespace App\Http\Controllers\Backend\DiscountRule\Contracts;

interface DiscountRuleInterface{
    public function getDiscountRules();

    public function createDiscountRule($request);

    public function getDiscountRuleById($id);

    public function updateDiscountRule($id,$request);

    public function deleteDiscountRuleById($id);

    public function getDiscountRulesNumberOfUsesIsGreaterThanZero();

    public function getDiscountRuleByKey($key);

    public function increaseDıscountRuleNumberOfUses($id);
}