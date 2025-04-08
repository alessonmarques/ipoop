<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DeployController extends Controller
{
    public function __invoke(Request $request)
    {
        $secret = env('GITHUB_WEBHOOK_SECRET');

        $signature = $request->header('X-Hub-Signature-256') ?? $request->header('X-Hub-Signature');

        if (!$signature) {
            abort(401, 'Missing signature.');
        }

        $hashAlgo = str_contains($signature, 'sha256=') ? 'sha256' : 'sha1';
        $payload = $request->getContent();
        $expected = hash_hmac($hashAlgo, $payload, $secret);
        $provided = explode('=', $signature, 2)[1] ?? '';

        if (!hash_equals($expected, $provided)) {
            abort(401, 'Invalid signature.');
        }

        if (Cache::has('deploy_trigger')) {
            Log::info('Deploy: already triggered.');
            return response()->json(['message' => 'Deploy already triggered.'], 200);
        }
        Cache::put('deploy_trigger', true, now()->addMinutes(2));

        Log::info('Deploy: successfully completed.');
        return response()->json(['message' => 'Deploy authorized.'], 200);
    }

}
