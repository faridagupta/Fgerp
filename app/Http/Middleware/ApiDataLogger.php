<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\File;

class ApiDataLogger
{
private $startTime;
/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request  $request
* @param  \Closure  $next
* @return mixed
*/
public function handle($request, Closure $next)
{
    $this->startTime = microtime(true);
    return $next($request);
}
public function terminate($request, $response)
{

 if ( env('API_DATALOGGER', true) ) {
   $endTime = microtime(true);
   //$filename = 'api_datalogger_' . date('d-m-y') . '.log';
   $filename   = 'api_log.log';
   $dataToLog  = 'Time: '   . gmdate("F j, Y, g:i a") . "\n";
   $dataToLog .= 'Duration: ' . number_format($endTime - LUMEN_START, 3) . "\n";
   $dataToLog .= 'IP Address: ' . $request->ip() . "\n";
   $dataToLog .= 'User: ' . auth()->user() . "\n";
   $dataToLog .= 'URL: '    . $request->fullUrl() . "\n";
   $dataToLog .= 'Method: ' . $request->method() . "\n";
   $dataToLog .= 'Input: '  . $request->getContent() . "\n";
   $dataToLog .= 'Output: ' . $response->getContent() . "\n";
   //echo $filename;
   File::append('/home/farida/Fgerp/storage/logs/api_log.log', $dataToLog . "\n" . str_repeat("=", 20) . "\n\n");//exit;
 //  File::append( storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $dataToLog . "\n" . str_repeat("=", 20) . "\n\n");
   }
 }
}