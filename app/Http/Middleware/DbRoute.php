<?php

namespace App\Http\Middleware;

use App\Body;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class DbRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            $url = parse_url(URL::to(''));
            $host = explode('.',$url['host']);

            /*$hostDb = ucwords(str_replace('-','_',$host[0]));
            $checkIfDomainExists = Body::where('db_name',$hostDb)->get();*/
            $checkIfDomainExists = Body::where('db_name',$host[0])->get();
            if($checkIfDomainExists->count()==1){ //organization Found'
                $data = $checkIfDomainExists->first();
                Config::set('database.connections.mysql2.host', env('DB_HOST', 'localhost'));
                Config::set('database.connections.mysql2.username', env('DB_USERNAME', 'root'));
                Config::set('database.connections.mysql2.password', env('DB_PASSWORD', 'root'));
                Config::set('database.connections.mysql2.database', $data->db_name);
                //If you want to use query builder without having to specify the connection
                Config::set('database.default', 'mysql2');
                DB::reconnect('mysql2');
                /*echo "Driver: " . Config::get('database.connections.mysql.driver') . "<br/>\r\n";
                echo "Host: " . Config::get('database.connections.mysql.host') . "<br/>\r\n";
                echo "Database: " . Config::get('database.connections.mysql.database') . "<br/>\r\n";
                echo "Username: " . Config::get('database.connections.mysql.username') . "<br/>\r\n";
                echo "Password: " . Config::get('database.connections.mysql.password') . "<br/>\r\n";exit;*/
            }else{ ////organization Not Found
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                }else{
                    return view('errors.404');
                }
            }
        return $next($request);
    }
}
