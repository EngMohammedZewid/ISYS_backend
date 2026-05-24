<?php

namespace App\Http\Controllers\API;

use App\Common\Enums\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSessionRequest;
use App\Http\Resources\SessionCollection;
use App\Http\Resources\SessionDetailsResource;
use App\Models\Session;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::active()
            ->orderBy('date', 'desc')
            ->orderBy('from', 'asc')
            ->paginate(Pagination::SESSION);

        return response()->json([
            'status' => 'success',
            'data' => new SessionCollection($sessions),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        return response()->json([
            'status' => 'success',
            'data' => (new SessionDetailsResource($session)),
        ]);
    }

    public function userSessions(Request $request)
    {
        $user = $request->user();

        $sessions = $user->sessions()
            ->active()
            ->orderBy('date', 'desc')
            ->orderBy('from', 'asc')
            ->paginate(Pagination::SESSION);

        return response()->json([
            'status' => 'success',
            'data' => new SessionCollection($sessions),
        ]);
    }

    public function enroll(UserSessionRequest $request)
    {
        try {
            $session = Session::find($request->validated('session_id'));

            $user = $request->user();

            if (!$session) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Session not found',
                ], 404);
            }

            if ($user->sessions->contains($session->id)) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'User already enrolled to this session',
                ]);
            }

            $user->sessions()->attach($session->id);

            return response()->json([
                'status' => 'success',
                'message' => 'User successfully enrolled to the session',
            ]);
        } catch (Exception $exception) {
            report($exception); // Log the exception for debugging
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function customListSession()
    {
        try {
            $sessionIdColumn = DB::raw('group_concat(sessions.id) AS id');
            $sessionTranslationsColumn = DB::raw('group_concat(translations.title) AS title');

            $subquery = DB::table('session_translations')
                ->selectRaw('GROUP_CONCAT(session_translations.title) AS title, session_translations.session_id')
                ->where('locale', 'en')
                ->groupBy('session_translations.session_id');

            $sessions = DB::table('sessions')
                ->leftJoinSub($subquery, 'translations', function ($join) {
                    $join->on('sessions.id', '=', 'translations.session_id');
                })
                ->select($sessionIdColumn, $sessionTranslationsColumn, 'sessions.date', 'sessions.from', 'sessions.to', 'sessions.track_id')
                ->where('sessions.is_active', true)
                ->groupBy('sessions.from', 'sessions.to', 'sessions.track_id', 'sessions.date')
                ->orderBy('sessions.from', 'asc')
                ->orderBy('sessions.date', 'desc')
                ->paginate(Pagination::SESSION);

            return response()->json([
                'status' => 'success',
                'data' => new SessionCollection($sessions),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving sessions: ' . $e->getMessage()], 500);
        } catch (\Throwable $t) {
            return response()->json(['error' => 'An error occurred while retrieving sessions: ' . $t->getMessage()], 500);
        }
    }
}
