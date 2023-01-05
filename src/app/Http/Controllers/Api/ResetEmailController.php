<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetEmailPostRequest;
use App\Http\Services\ResetEmailService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Responses\RegisterResponse;

class ResetEmailController extends Controller
{
    private ResetEmailService $resetEmailService;

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    public function __construct(StatefulGuard $guard, ResetEmailService $resetEmailService)
    {
        $this->guard = $guard;
        $this->resetEmailService = $resetEmailService;
    }


    /**
     * emailの再発行
     *
     * @param ResetEmailPostRequest $resetEmailPostRequest
     * @return JsonResponse
     */
    public function store(ResetEmailPostRequest $resetEmailPostRequest): JsonResponse
    {
        $user = $this->resetEmailService->getUser($resetEmailPostRequest->toUser());

        if ($this->resetEmailService->isPassword($user, $resetEmailPostRequest['password'])) {
            return response()->json(['パスワードが違います。'], 422);
        }

        $this->resetEmailService->updateEmail($user, $resetEmailPostRequest['email']);

        // 新規登録と同じ処理、仮登録メール→ボタン押下→登録完了
        event(new Registered($user));
        $this->guard->login($user);
        return app(RegisterResponse::class);
    }
}
