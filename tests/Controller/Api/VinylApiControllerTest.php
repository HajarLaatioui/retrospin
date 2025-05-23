<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VinylApiControllerTest extends WebTestCase
{
    public function testGetVinyls(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/vinyls', [], [], [
            'HTTP_Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDc5MzU3ODQsImV4cCI6MTc0NzkzOTM4NCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlckByZXRyb3NwaW4uY29tIn0.ap4xNgIAaMAafGiD5abnhNVyeUuTQhYbUCuANjZjwgY9fw2qA9hWJyZ3Tkb0Cwrm2Ma8FXNNmSbL58zEZwqvxEeWCtnN1vBGrqIMnWQBqt5N0VbnaDDcK8UljVkYyNsOFuFSmUYGit_mSf_OVjBLj1I5yd8lpv8ZKg2--WXgT9qBQFz2qxICpMXwCRSqVUNjiqRrWPHVMWmMf6WcPIMutvv16yVBBsjQkBP3ITLBVn-ZGy5rAdFyLdH0ne57eCYbX6t86n5lkUjPeUaZZQXcQkabCSjb2PWrlejcZDDRoPZarjtMxYoatifnieiuoF4SjQWsU9rkuXA1eKfQTi-rsjTUtory_8RQW6dFjVQ0qUtwYC4TLAs2eUIUTBo1e7bMlavYurMOgfL3yCABOItIj3ZI0YflwnEBMFsk21NEc_uwD4ANgEs9G4Vso7YsMz8cq6v9AHVzQeXJKIGQ2DEC1-1deU44VlbApPMHBm97Hx8t3gNwjOwDzinBjABYf8IS4Fq2ijvDLWPqsqlqFqdbwEJktfnbRxJz3b4Op3__bv64Z0mzvluHGUgXMjs4Git9unMyGUuHP5s5t30LbS3xyJMiuVrUAOw1anfaGeBsWiw7fY-X8Y30HQ2FPlFVbU6BH0v-s52y0Us21o4Y0d2XYScBS1dCqRf8OWGVYs6gvc0' 
        ]);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }
}