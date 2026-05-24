<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
        try {
            $sessionIdColumn = DB::raw('group_concat(sessions.id) AS id');
            $session_translations = DB::raw('group_concat(translations.title) AS title');

            $subquery = DB::table('session_translations')
                ->selectRaw('GROUP_CONCAT(session_translations.title) AS title, session_translations.session_id')
                ->where('locale', 'en')
                ->groupBy('session_translations.session_id');

            $sessions = DB::table('sessions')
                ->leftJoinSub($subquery, 'translations', function ($join) {
                    $join->on('sessions.id', '=', 'translations.session_id');
                })
                ->select($sessionIdColumn, $session_translations, 'sessions.date', 'sessions.from', 'sessions.to', 'sessions.track_id')
                ->where('sessions.is_active', true)
                ->groupBy('sessions.from', 'sessions.to', 'sessions.track_id', 'sessions.date')
                ->orderBy('sessions.from', 'asc')
                ->orderBy('sessions.date', 'desc')
                ->get();

            $transformedData = [];

            foreach ($sessions as $session) {
                $transformedData[] = ($session);
            }

            // Return the transformed data as the API response
            return response()->json($transformedData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving sessions: '.$e->getMessage()], 500);
        } catch (\Throwable $t) {
            return response()->json(['error' => 'An error occurred while retrieving sessions: '.$t->getMessage()], 500);
        }
    }
}
