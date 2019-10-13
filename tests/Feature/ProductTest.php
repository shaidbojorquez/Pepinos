<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase; 
use App\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /*
     * CREATE-1
     */
    
    public function test_client_can_create_a_product()
    {

        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/product', $productData); 


        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);
        
        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' =>$body['id'],
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );

        return $body;
    }
    /*
     *CREATE-2
     */
    public function test_name_is_not_sent(){
        // Given
        $productData = [
            //'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/product', $productData); 


        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            "errors"=>[
                ["code"=> "ERROR-1",
                "title" => "Unprocessable Entity"]
            ]
        ]);
        
    }
    /*
     *CREATE-3
     */
     public function test_price_is_not_sent(){
        // Given
        $productData = [
            'name' => 'Super Product',
            //'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/product', $productData); 


        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            "errors"=>[
                ["code"=> "ERROR-1",
                "title" => "Unprocessable Entity"]
            ]
        ]);
        
    }
    /*
     *CREATE-4
     */
     public function test_price_is_not_number(){
        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => 'Culo'
        ];

        // When
        $response = $this->json('POST', '/api/product', $productData); 


        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            "errors"=>[
                ["code"=> "ERROR-1",
                "title" => "Unprocessable Entity"]
            ]
        ]);
        
    }
    /*
     *CREATE-5
     */
     public function test_price_is_negative(){
        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => '-20'
        ];

        // When
        $response = $this->json('POST', '/api/product', $productData); 


        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            "errors"=>[
                ["code"=> "ERROR-1",
                "title" => "Unprocessable Entity"]
            ]
        ]);
    }  
    /*
     * LIST-1
     */
    public function test_client_can_list_all_products()
    {
        $createdProduct = factory(Product::class, 2) -> create();


        // Given
        // When
        $response = $this->json('GET', '/api/product'); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert the response has the correct structure
        $response->assertJsonStructure([
          '*' => ['id',
            'name',
            'price']
        ]);
        // Assert the product was created
        // with the correct data
        // Assert product is on the database
    }
    /*
     * LIST-2
     */
    public function product_list_empty()
    {
        //$createdProduct = factory(Product::class, 2) -> create();


        // Given
        // When
        $response = $this->json('GET', '/api/product'); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert the response has the correct structure
        $response->assertJsonStructure([
          '*' => ['id',
            'name',
            'price']
        ]);
        // Assert the product was created
        // with the correct data
        // Assert product is on the database
    }

    /**
     * UPDATE-1
     */
    public function test_client_can_update_a_product()
    {

        $createdProduct = factory(Product::class, 1) -> create(

        )->each(function($product){
            $id = $product->id;
               // Given
            $productData = [
                'name' => 'Super Produc',
                'price' => '23.30'
            ];

            // When
            $response = $this->json('PUT', '/api/product/'.$id.'/update', $productData); 

            // Then
            // Assert it sends the correct HTTP Status
            $response->assertStatus(200);
            
            // Assert the response has the correct structure
            $response->assertJsonStructure([
                'id',
                'name',
                'price'
            ]);
            // Assert the product was created
            // with the correct data
            $response->assertJsonFragment([
                'name' => 'Super Produc',
                'price' => '23.30'
            ]);
            
            $body = $response->decodeResponseJson();

            // Assert product is on the database
            $this->assertDatabaseHas(
                'products',
                [
                    'id' =>$body['id'],
                    'name' => 'Super Produc',
                    'price' => '23.30'
                ]
            );

        });
        //$createdProduct = $this-> test_client_can_create_a_product();
    }
    /**
     * UPDATE-2
     */
    public function test_update_price_is_not_number()
    {
 
         $createdProduct = factory(Product::class, 1) -> create(
 
         )->each(function($product){
             $id = $product->id;
                // Given
             $productData = [
                 'name' => 'Super Produc',
                 'price' => 'culo'
             ];
 
             // When
             $response = $this->json('PUT', '/api/product/'.$id.'/update', $productData); 
 
             // Then
             // Assert it sends the correct HTTP Status
             $response->assertStatus(422);
             
             $response->assertJsonStructure([
                "errors"
            ]);
    
            // Assert the product was created
            // with the correct data
            $response->assertJsonFragment([
                "errors"=>[
                    ["code"=> "ERROR-1",
                    "title" => "Unprocessable Entity"]
                ]
            ]);
 
         });
         //$createdProduct = $this-> test_client_can_create_a_product();
    }
    /**
     * UPDATE-3
     */
    public function test_update_price_is_not_negative()
    {
  
          $createdProduct = factory(Product::class, 1) -> create(
  
          )->each(function($product){
              $id = $product->id;
                 // Given
              $productData = [
                  'name' => 'Super Produc',
                  'price' => '-20'
              ];
  
              // When
              $response = $this->json('PUT', '/api/product/'.$id.'/update', $productData); 
  
              // Then
              // Assert it sends the correct HTTP Status
              $response->assertStatus(422);
              
              $response->assertJsonStructure([
                 "errors"
             ]);
     
             // Assert the product was created
             // with the correct data
             $response->assertJsonFragment([
                 "errors"=>[
                     ["code"=> "ERROR-1",
                     "title" => "Unprocessable Entity"]
                 ]
             ]);
  
          });
          //$createdProduct = $this-> test_client_can_create_a_product();
    }
    /**
     * UPDATE-4
     */
    public function test_update_product_id_nonexistent()
    {
   
           $createdProduct = factory(Product::class, 1) -> create(
   
           )->each(function($product){
               $id = $product->id+4;
                  // Given
               $productData = [
                   'name' => 'Super Produc',
                   'price' => '20.45'
               ];
   
               // When
               $response = $this->json('PUT', '/api/product/'.$id.'/update', $productData); 
   
               // Then
               // Assert it sends the correct HTTP Status
               $response->assertStatus(404);
               
               $response->assertJsonStructure([
                  "errors"
              ]);
      
              // Assert the product was created
              // with the correct data
              $response->assertJsonFragment([
                  "errors"=>[
                      ["code"=> "ERROR-2",
                      "title" => "Not Found"]
                  ]
              ]);
   
           });
           //$createdProduct = $this-> test_client_can_create_a_product();
    }

    /**
     * DELETE-1
     */
    public function test_client_can_delete_a_product()
    {
        $createdProduct = factory(Product::class, 1) -> create(

            )->each(function($product){
                $id = $product->id;
                $name = $product ->name;
                $price = $product ->price;
                // When
            $response = $this->json('DELETE', '/api/product/'.$id.'/delete'); 

            // Then
            // Assert it sends the correct HTTP Status
            $response->assertStatus(204);
            });
        //$createdProduct = $this-> test_client_can_create_a_product();  
        // Assert the response has the correct structure
        

        // Assert the product was created
        // with the correct data
    }
    /**
     * DELETE-2
     */
    public function test_client_cant_delete_an_nonexistproduct()
    {
        $createdProduct = factory(Product::class, 1) -> create(

            )->each(function($product){
                $id = $product->id+4;
                $name = $product ->name;
                $price = $product ->price;
                // When
            $response = $this->json('DELETE', '/api/product/'.$id.'/delete'); 

            // Then
            // Assert it sends the correct HTTP Status
            $response->assertStatus(404);

            $response->assertJsonStructure([
                "errors"
            ]);

            $response->assertJsonFragment([
                "errors"=>[
                    ["code"=> "ERROR-2",
                    "title" => "Not Found"]
                ]
            ]);

            });
        //$createdProduct = $this-> test_client_can_create_a_product();  
        // Assert the response has the correct structure
        

        // Assert the product was created
        // with the correct data
    }





 /**
  * SHOW-1
  */
 public function test_client_can_show_a_product()
 {

    $createdProduct = factory(Product::class, 1) -> create(

        )->each(function($product){
            $id = $product->id;
            $name = $product ->name;
            $price = $product ->price;
            $response = $this->json('GET', '/api/product/'.$id);
            // Then
            // Assert it sends the correct HTTP Status
            $response->assertStatus(200);

             // Assert the response has the correct structure
            $response->assertJsonStructure([
                'id',
                'name',
                'price'
            ]);

            // Assert the product was created
            // with the correct data
            $response->assertJsonFragment([
                'name' => $name,
                'price' => number_format("{$price}", 2,'.','')
            ]);
        });

    //$createdProduct = $this-> test_client_can_create_a_product();

     // When
    // $response = $this->json('GET', '/api/product/'.$createdProduct["id"]); 

     // Then
     // Assert it sends the correct HTTP Status
    // $response->assertStatus(200);
     
     // Assert the response has the correct structure
    /* $response->assertJsonStructure([
         'id',
         'name',
         'price'
     ]);*/

     // Assert the product was created
     // with the correct data
     /*$response->assertJsonFragment([
         'name' => 'Super Product',
         'price' => '23.30'
     ]);*/
     // Assert product is on the database
 }
 /**
  * SHOW-2
  */
  public function test_client_cant_show_a_product_nonexist()
  {
 
     $createdProduct = factory(Product::class, 1) -> create(
 
         )->each(function($product){
             $id = $product->id+4;
             $name = $product ->name;
             $price = $product ->price;
             $response = $this->json('GET', '/api/product/'.$id);
             // Then
             // Assert it sends the correct HTTP Status
             $response->assertStatus(404);
 
              // Assert the response has the correct structure
              $response->assertJsonStructure([
                "errors"
            ]);
            /* $response->assertJsonStructure([
                 'id',
                 'name',
                 'price'
             ]);*/
 
             // Assert the product was created
             // with the correct data
             $response->assertJsonFragment([
                "errors"=>[
                    ["code"=> "ERROR-2",
                    "title" => "Not Found"]
                ]
            ]);
            /* $response->assertJsonFragment([
                 'name' => $name,
                 'price' => "{$price}"
             ]);*/
         });
 
     //$createdProduct = $this-> test_client_can_create_a_product();
 
      // When
     // $response = $this->json('GET', '/api/product/'.$createdProduct["id"]); 
 
      // Then
      // Assert it sends the correct HTTP Status
     // $response->assertStatus(200);
      
      // Assert the response has the correct structure
     /* $response->assertJsonStructure([
          'id',
          'name',
          'price'
      ]);*/
 
      // Assert the product was created
      // with the correct data
      /*$response->assertJsonFragment([
          'name' => 'Super Product',
          'price' => '23.30'
      ]);*/
      // Assert product is on the database
  }
    
}
