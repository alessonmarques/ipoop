<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function __invoke(Request $request)
    {
        $providedSecret = $request->header(key: 'X-Hub-Signature-256') ?? '';
        $expectedSecret = env('GITHUB_WEBHOOK_SECRET');

        if (!$expectedSecret || !$this->isValidSignature($request->getContent(), $providedSecret, $expectedSecret)) {
            Log::warning('Deploy: Assinatura inválida ou não fornecida.');
            return response('Unauthorized', 401);
        }

        // Log de início
        Log::info('Deploy: Webhook recebido, iniciando deploy...');

        // Rodar o deploy script
        $process = Process::fromShellCommandline(base_path('deploy.sh'));
        $process->run();

        if (! $process->isSuccessful()) {
            Log::error('Deploy: erro ao executar script', ['output' => $process->getErrorOutput()]);
            return response('Erro ao executar deploy', 500);
        }

        Log::info('Deploy: concluído com sucesso.');
        return response('Deploy executado com sucesso');
    }

    private function isValidSignature($payload, $provided, $secret)
    {
        $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);
        return hash_equals($hash, $provided);
    }
}
