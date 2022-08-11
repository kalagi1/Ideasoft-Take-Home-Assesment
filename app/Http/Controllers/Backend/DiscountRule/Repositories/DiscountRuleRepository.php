<?php 

namespace App\Http\Controllers\Backend\DiscountRule\Repositories;

use App\Http\Controllers\Backend\DiscountRule\Contracts\DiscountRuleInterface;
use App\Models\DiscountRule;

class DiscountRuleRepository implements DiscountRuleInterface{

    private $discountRule;

    public function __construct(DiscountRule $discountRule)
    {
        $this->discountRule = $discountRule;
    }

    public function getDiscountRules(){
        return $this->discountRule->get();
    }

    public function createDiscountRule($request){
        return $this->discountRule->create($request);
    }

    public function getDiscountRuleById($id){
        return $this->discountRule->where('id',$id)->firstOrFail();
    }

    public function updateDiscountRule($id,$request){
        $discountRule = $this->getDiscountRuleById($id);
        return $discountRule->update($request);
    }

    public function deleteDiscountRuleById($id){
        $discountRule = $this->getDiscountRuleById($id);
        return $discountRule->delete();
    }

    public function getDiscountRulesNumberOfUsesIsGreaterThanZero(){
        return $this->discountRule->where('number_of_uses','>',0)->orWhere('number_of_uses','-1')->get();
    }

    public function getDiscountRuleByKey($key){
        return $this->discountRule->where('key',$key)->firstOrFail();
    }

    public function increaseDıscountRuleNumberOfUses($id){
        $discountRule = $this->getDiscountRuleById($id);
        if($discountRule->number_of_uses > 0){
            $discountRule->update([
                "number_of_uses" => $discountRule->number_of_uses - 1
            ]);

            return true;
        }else if($discountRule->number_of_uses == -1){
            return true;
        }else{
            return false;
        }
    }
}