<?php

namespace App\Pattern\Input;

use App\Models\Attribute;
use App\Models\SubAttribute;
use App\Traits\ResponseJson;
use App\Models\AttributeBrand;
use Illuminate\Support\Facades\DB;

class Number implements InputInterface
{
    use ResponseJson;

    public function __construct(private array $validatedInput,private string $table){}

    public function store(): \Illuminate\Http\JsonResponse
    {
        try {

            $validated     = $this->validatedInput;
            $validated['input_label']           =  ['en' =>   $validated['input_label']  , 'ar' =>   $validated['input_label_ar'] ];
           // dd( $validated);
           if($this->table == 'attributes') {
               Attribute::create($validated);
           }

           if($this->table == 'sub_attributes') {
            SubAttribute::create($validated);
           }

            if($this->table == 'attribute_brands') {
                AttributeBrand::create($validated);
            }
           
           // DB::table($this->table)->insert($this->validatedInput);
            return $this->responseJson(['message' => 'attribute created successfully'], 201);
        } catch (\Exception $exception) {
            return $this->responseJson(['errors' => ['server error']], 500);
        }
    }
}
