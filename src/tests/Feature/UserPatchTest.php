<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPatchTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
    }

    /**
     * ユーザーを更新する
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $request = [
            'name' => 'sirotan',
            'email' => 'sirotan@gmail.com',
            'company' => 'MG'
        ];
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->patch(
            '/api/v1/user/' . $this->user->id,
            $request
        );
        $response->assertStatus(204);
        $this->assertDatabaseHas(
            User::class,
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'company' => $request['company']
            ]
        );
    }

    /**
     * リクエストしたユーザーと認可されているユーザーが異なる場合、403
     *
     * @return void
     */
    public function testNotUser()
    {
        $otherUser = User::factory()->create();
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->patch(
            '/api/v1/user/' . $otherUser->id,
            [
                'name' => $this->user->name,
                'email' => 'sirotan@gmail.com',
                'company' => $this->user->company
            ]
        );
        $response->assertStatus(403);
        $this->assertSame(
            ['message' => 'ユーザーとリクエストが一致しません。'],
            $response->json()
        );
    }

    /**
     * リクエストエラー
     *
     * @dataProvider dataProviderParam
     * @return void
     */
    public function testRequest422(array $param)
    {
        $baseParam = [
            'name' => $this->user->name,
            'email' => $this->user->id,
            'company' => $this->user->company
        ];
        $requestParam = array_replace($baseParam, $param);
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->json(
            'PATCH',
            '/api/v1/user/' . $this->user->id,
            $requestParam
        );
        $response->assertStatus(422);
    }

    /**
     * @return iterable
     */
    public function dataProviderParam(): iterable
    {
        yield 'データが無い' => [
            [
                'name' => '',
                'email' => '',
                'company' => ''
            ]
        ];
        yield 'nameが151文字以上' => [
            [
                'name' => str_repeat('a', 151)
            ]
        ];
        yield 'nameが51文字以上(日本語)' => [
            [
                'name' => str_repeat('あ', 51)
            ]
        ];
        yield 'nameがbool' => [
            [
                'name' => false
            ]
        ];
        yield 'nameがnull' => [
            [
                'name' => null
            ]
        ];
        yield 'emailで日本語が使用されている' => [
            [
                'email' => 'test@example.comあいうえお'
            ]
        ];
        yield 'emailに無効なドット' => [
            [
                'email' => '.test..@gmail.com'
            ]
        ];
        yield 'emailがnull' => [
            [
                'email' => null
            ]
        ];
        yield 'companyが10文字以上' => [
            [
                'company' => str_repeat('a', 11)
            ]
        ];
        yield 'companyがbool' => [
            [
                'company' => false
            ]
        ];
        yield 'companyがnull' => [
            [
                'company' => null
            ]
        ];
    }
}
