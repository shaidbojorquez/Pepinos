<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    
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

    public function test_client_can_list_all_products()
    {
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

    public function test_client_can_update_a_product()
    {

      
        $createdProduct = $this-> test_client_can_create_a_product();



        // Given
        $productData = [
            'name' => 'Super Produc',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('PUT', '/api/product/'.$createdProduct["id"].'/update', $productData); 

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
    }

 //Delete product
 public function test_client_can_delete_a_product()
    {
        $createdProduct = $this-> test_client_can_create_a_product();
        

        // When
        $response = $this->json('DELETE', '/api/product/'.$createdProduct["id"].'/delete'); 

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);
        
        // Assert the response has the correct structure
        

        // Assert the product was created
        // with the correct data
      
    
    }

 //Show product
 public function test_client_can_show_a_product()
 {
    $createdProduct = $this-> test_client_can_create_a_product();

     // When
     $response = $this->json('GET', '/api/product/'.$createdProduct["id"]); 

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
         'name' => 'Super Product',
         'price' => '23.30'
     ]);
     
    

     // Assert product is on the database
    

 }
    
    
}
