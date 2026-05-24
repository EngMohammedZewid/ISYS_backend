<?php

use App\Common\Enums\RouteName;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\PasswordController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\VerifyEmailController;
use App\Http\Controllers\API\ChatbotController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\KnowledgeCategoryController;
use App\Http\Controllers\API\KnowledgeItemController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\SponsorController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('json')->group(function () {

    Route::withoutMiddleware('/')->group(function () {
        Route::post('register', [RegisterController::class, 'register'])->name(RouteName::REGISTER);
        Route::post('login', [LoginController::class, 'login'])->name(RouteName::LOGIN);
        Route::post('/email/verify', [VerifyEmailController::class, 'verify'])->middleware(['throttle:6,1'])
            ->name('verification.verify');
        Route::post('password/forget', [PasswordController::class, 'forget'])->name(RouteName::FORGET_PASSWORD);
        Route::post('password/reset', [PasswordController::class, 'reset'])->name(RouteName::RESET_PASSWORD);
        // test route to return 422 error
        Route::get('new-test', function () {
            $response = response()->json(['error' => 'Test at ' . now()], 422);
            Log::debug("Actual Status: " . $response->getStatusCode());
            return $response;
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('check-events', function(){
            return response()->json([
                'enabled' => config('events.status'),
            ]);
        });
        Route::get('homepage_data', function(){
            return response()->json([
                'image' => asset('storage/homepage/homepage.jpg'),
                'title' => config('app.name'),
                'description' => 'description will be here',
                'item_id' => 1,
                'to_agenda' => false,
            ]);
        });
        Route::post('contact_us', [ContactUsController::class, 'create'])->name(RouteName::CONTACTUS);
        Route::delete('users', [UserController::class, 'destroy']);
        Route::get('users', [UserController::class, 'show']);
        Route::put('users', [UserController::class, 'update']);

        Route::apiResource('users', UserController::class)->only(['show', 'update', 'destroy']);
        Route::apiResource('services', ServiceController::class)->only(['index', 'show']);
        Route::apiResource('news', NewsController::class)->only(['index', 'show']);
        Route::apiResource('partner', PartnerController::class)->only(['index']);
        Route::apiResource('sponsor', SponsorController::class)->only(['index']);
        Route::apiResource('menu', MenuController::class)->only(['index']);
        Route::apiResource('sessions', SessionController::class)
            ->only(['index', 'show']);
        Route::get('my-sessions', [SessionController::class, 'userSessions'])
            ->name(RouteName::CUSTOM_LIST_SESSIONS);
        Route::post('enroll', [SessionController::class, 'enroll'])
            ->name(RouteName::ATTACH_USER_SESSION);

        // Route::get('enrole/attach_user/{session}', [SessionController::class, 'attachUserToSession'])->name(RouteName::ATTACH_USER_SESSION);
        // Route::get('custom_list_sessions', [SessionController::class, 'customListSession'])
        //     ->name(RouteName::SESSION_USER);
        Route::get('knowledge_categories', [KnowledgeCategoryController::class, 'index'])
            ->name(RouteName::KNOWLEDGE_CATEGORIES_INDEX);
        Route::get('knowledge_categories/{knowledgeCategory}', [KnowledgeCategoryController::class, 'show'])
            ->name(RouteName::KNOWLEDGE_CATEGORIES_SHOW);
        Route::post('knowledge_items/{KnowledgeItem}', [KnowledgeItemController::class, 'interest']);

        Route::post('chatbot', [ChatbotController::class, 'chat']);

        // Route::get('tracks/{trackId}/sessions', [SessionController::class, 'index']);
    });
});
