<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
// use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
// use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class SharedFunctionsHelpers
{
    /**
     * Enviar una respuesta de éxito en formato JSON.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendResponse($data, $message = '', $code = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * Enviar una respuesta de error en formato JSON.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendError($error, $errorMessages = [], $code = Response::HTTP_BAD_REQUEST)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages))
            $response['data'] = $errorMessages;

        return response()->json($response, $code);
    }

    public static function getUserStatus()
    {
        $user = User::where('uuid', Auth::user()->uuid)->firstOrFail();

        if (isset($user) && !$user->is_active) {
            Auth::logout();
            Session::flush();
            return redirect()
                ->route('login')
                ->with('error', 'Tu cuenta se encuentra suspendida, comunicate con soporte para mas detalles.');
        }

        return null;
    }

    public static function getIpAddress()
    {
        $headers = [
            'HTTP_CLIENT_IP', 
            'HTTP_X_FORWARDED_FOR', 
            'HTTP_X_FORWARDED', 
            'HTTP_FORWARDED_FOR', 
            'HTTP_FORWARDED'
        ];

        foreach ($headers as $header) {
            if ($ip = $_SERVER[$header] ?? false) {
                return trim(explode(',', $ip)[0]);
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public static function logs()
    {
        // $agent = new Agent();

        /*if (!$agent->isRobot()) {
            $plataforma = $agent->platform();
            $navegador = $agent->browser();
            $logs_visitante = new Log();
            $logs_visitante->uuid = Str::uuid();
            $logs_visitante->dispositivo = $agent->device();
            $logs_visitante->plataforma = $plataforma;
            $logs_visitante->plataforma_version = $agent->version($plataforma) ?? 'unknown';
            $logs_visitante->equipo = $agent->isPhone() ? 1 : 0;
            $logs_visitante->navegador = $navegador;
            $logs_visitante->navegador_version = $agent->version($navegador) ?? 'unknown';
            $logs_visitante->direccion_ip = self::getIpAddress();
            $logs_visitante->hostname = gethostname();
            $logs_visitante->save();
        }*/
    }

    public static function clearString($texto, $lower = false)
    {
        $texto = Str::ascii($texto);
        $texto = trim($texto);
        $texto = $lower == true ? strtoupper($texto) : strtolower($texto);

        return $texto;
    }

    public static function pathDocuments()
    {
        return 'documents/';
    }
}