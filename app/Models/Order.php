<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'shipping_id', 'card_holder', 'case_deal_price', 'pay_later', 'order_from', 'card_no', 'billing_id', 'wallet_paid', 'total_price', 'shipping_charges', 'card_type', 'discount', 'payment_method', 'transaction_id', 'status', 'current_status', 'offer_id', 'created_at', 'updated_at', 'deleted_at', 'amount_paid', 'wallet_amount', 'order_nr', 'expiration_month', 'card_security_code', 'expiration_year', 'order_from'
    ];

    //Validate
    public function validateOrder($inputs)
    {
        $rules = [
            'shipping_id' => 'required|numeric',
            'total_price' => 'required|numeric',
            'shipping_charges' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'payment_method' => 'required'
        ];
        return \Validator::make($inputs, $rules);
    }

    //Validate
    public function validateOrderStatus($inputs)
    {
        $rules = [
            'order_id' => 'required|numeric',
            'status' => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }

    public function recordvalidate($inputs)
    {
        $rules = [
            'from'  => 'required|date',
            'to'    => 'required|date|after:from',
        ];
        return \Validator::make($inputs, $rules);
    }
 
    public function validateReturnOrder($inputs)
    {
        $rules = [
            'user_id'  => 'required|numeric',
            'order_id'    => 'required|numeric',
            'amount'    => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }
    
    
    public function store($input, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($input);
        } else {
            return $this->create($input)->id;
        }
    }

  
    public function getOrder($search = null, $skip, $perPage, $user_type, $user_id )
     {
         $take = ((int)$perPage > 0) ? $perPage : 100;
         $filter = 1; // default filter if no search

         $fields = [
            'orders.id',
            'orders.user_id',
            'orders.order_nr',
            'orders.order_from',
            'orders.total_price',
            'orders.transaction_id',
            'orders.payment_method',
            'orders.case_deal_price',
            'orders.current_status as c_status',
            'orders.status',
            'orders.created_at',
            'order_statuses.type as current_status',
            'users.name as user_name',
            'order_addresses.name as address_name',
            'order_addresses.address as address',
            'order_addresses.mobile',
            'order_addresses.company_name',
            'order_addresses.state',
            'order_addresses.city',
            'order_addresses.pincode',
            'countries.country_name',
            
          ];

         $sortBy = [
             'order_nr' => 'order_nr',
         ];

         $orderEntity = 'id';
         $orderAction = 'desc';
         if (isset($search['sort_action']) && $search['sort_action'] != "") {
             $orderAction = ($search['sort_action'] == 1) ? 'desc' : 'asc';
         }

         if (isset($search['sort_entity']) && $search['sort_entity'] != "") {
             $orderEntity = (array_key_exists($search['sort_entity'], $sortBy)) ? $sortBy[$search['sort_entity']] : $orderEntity;
         }

         if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('order_nr', $search)) ? " AND (orders.order_nr = '" .
                addslashes($search['order_nr']) . "')" : "";
              

            $f2 = (array_key_exists('user_id', $search)) ? " AND (orders.user_id = '" .
                addslashes($search['user_id']) . "')" : "";

            $f3 = (array_key_exists('current_status', $search)) ? " AND (orders.current_status = '" .
                addslashes($search['current_status']) . "')" : "";
           

            $filter .= $f1 . $f2 . $f3;
        }

            return $this->join('order_statuses', 'order_statuses.id' ,'=', 'orders.current_status')
            ->join('users', 'users.id' ,'=', 'orders.user_id')
            ->join('order_addresses', 'order_addresses.order_id' ,'=', 'orders.id')
            ->join('countries', 'countries.id', '=', 'order_addresses.country')
                ->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)
                ->get($fields);

            
    }

 
    public function totalOrder($search = null, $user_type, $user_id)
     {
         $filter = 1; // if no search add where

         // when search
         if (is_array($search) && count($search) > 0) {
             $partyName = (array_key_exists('keyword', $search)) ? " AND name LIKE '%" .
                 addslashes(trim($search['keyword'])) . "%' " : "";
             $filter .= $partyName;
         }
       
         return $this->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
        
       
     }
    
    public function front_validate($inputs, $id = null) {
        $rules['address'] = 'required';
        $rules['card_no'] = 'required';
        $rules['card_holder'] = 'required';
        $rules['card_type'] = 'required';
        $rules['expiration_month'] = 'required';
        $rules['expiration_year'] = 'required';
        $rules['card_security_code'] = 'required';
        return \Validator::make($inputs, $rules);
    }
    
    public function front_validate_pay_later($inputs, $id = null) {
        $rules['address'] = 'required';
        return \Validator::make($inputs, $rules);
    }
    
    
     
      


}
