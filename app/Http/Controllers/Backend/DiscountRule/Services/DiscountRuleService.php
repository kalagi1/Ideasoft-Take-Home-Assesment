<?php 

namespace App\Http\Controllers\Backend\DiscountRule\Services;

use App\Http\Controllers\Backend\DiscountRule\Contracts\DiscountRuleInterface;
use Illuminate\Support\Facades\DB;

class DiscountRuleService{

    private $repository;

    public function __construct(DiscountRuleInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        return $this->repository->getDiscountRules();
    }

    public function store($request){
        return DB::transaction(function () use($request) {
            return $this->repository->createDiscountRule($request);
        });
    }

    public function show($id){
        return $this->repository->getDiscountRuleById($id);
    }

    public function update($id,$request){
        return DB::transaction(function () use($id,$request) {
            return $this->repository->updateDiscountRule($id,$request);
        });
    }

    public function destroy($id){
        return $this->repository->deleteDiscountRuleById($id);
    }
}