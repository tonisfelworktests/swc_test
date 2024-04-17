<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use MakesHttpRequests, RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
    }

    protected function tearDown(): void {
        parent::tearDown();
    }

    public function test_authentication(): void
    {
        $response = $this->get('/api/token', [
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);
        $accessToken = $response->json('result');

        // Проверка успешности аутентификации
        $this->assertEquals(200, $response->status());

        // Отправка запроса к защищенному ресурсу с использованием полученного токена доступа
        $response = Http::withHeaders([
                                          'Authorization' => 'Bearer '.$accessToken,
                                      ])->get('http://localhost/api/login');

        // Проверка успешности запроса к защищенному ресурсу
        $this->assertEquals(200, $response->status());
    }
}
