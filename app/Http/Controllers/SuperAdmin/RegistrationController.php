<?php

namespace App\Http\Controllers\SuperAdmin;

use App\superAdmin\organisation;
use App\superAdmin\body;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
//use ClassPreloader\Config;


use Illuminate\Routing\Route;
//use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RegistrationController extends Controller
{

    public function createSubDomain(Request $request){

        $organisationName=$request->get('org_name');

        $registrationType=$request->get('_registration_type'); //checks either registration for organisation or for body

        $pro_url= \Config::get('constants.PRODUCT_URL');

        $templateStr ='<VirtualHost 127.0.0.1:80>
				ServerAdmin webmaster@<usersubdomain>.'.$pro_url.
				'ServerName <usersubdomain>.'.$pro_url.'
				ServerAlias www.<usersubdomain>.'.$pro_url.'
				UseCanonicalName Off
				DirectoryIndex index.php
				DocumentRoot /var/www/html/'.$pro_url.'/public
				#ErrorLog /var/www/logsvhosts/'.$pro_url.'/users-error-log
				#LogLevel error
				#<IfModule mod_ssl.c> SSLEngine off </IfModule>
				<Directory /var/www/html/'.$pro_url.'/public >
					Options -Includes -ExecCGI
					Options Multiviews FollowSymLinks
				    MultiviewsMatch Any
				    AllowOverride All
				    Order allow,deny
				    Allow from all
				</Directory>
			</VirtualHost>';

        $case = 'create';//"create";

        $SubDomainName = $organisationName;

        $fullDomain=$SubDomainName.'.'.$pro_url;

        $file_check="/etc/apache2/sites-available/".$fullDomain.".conf";

        $string_Data = PHP_EOL.'127.0.0.1        '.$SubDomainName.'.'.$pro_url.PHP_EOL;

        if($case != '')
        {
            switch($case){
                case 'create':
                    if (!file_exists($file_check))
                    {

                        $domainStr2 = str_replace("<usersubdomain>",$SubDomainName,$templateStr);
                        $filename = "/etc/apache2/sites-available/".$fullDomain.".conf";
                        echo exec('sudo chmod -R 0777 /etc/apache2/sites-available/');
                        $fp = fopen($filename,"w") or die("go home");													  echo exec('sudo chmod -R 0777 '.$filename);
                        fwrite($fp,$domainStr2);					                         			  				  fclose($fp);

                        $str='sudo chmod -R 0777 '.$filename;
                        echo exec($str);
                        $file='/etc/hosts';
                        //$current=file_get_contents($file);

                        if(file_put_contents($file,$string_Data,FILE_APPEND))
                        {
                            $returnArray['FileWriteSuccess']= " $ success in writing hosts configuration file...";

                        }
                        else
                        {
                            echo " $ fail in writing \n";
                        }

                        echo exec('sudo service apache2 reload');

                        $SubDomainURL=$SubDomainName.".".$pro_url;

                        $returnArray['organisationName']=$organisationName;
                        $returnArray['SubDomainURL']=$SubDomainURL;
                        $returnArray['registrationType']=$registrationType;

                        //return $returnArray;exit;

                        RegistrationController::createDatabase($returnArray);

                    }else{
                        echo " $ oops this domain is already registered....\n";
                        exit;
                    }
                    break;

                case 'remove':

                default:

               }
         }

    }

    public function createSubDomainBody(Request $request){

        $bodyName=$request->get('body_name');

        $bodyType=$request->get('body_type');

        $bodyOrg=$request->get('orgName');

        $registrationType=$request->get('_registration_type');

        $pro_url= \Config::get('constants.PRODUCT_URL');

        $templateStr ='<VirtualHost 127.0.0.1:80>
				ServerAdmin webmaster@<usersubdomain>.'.$pro_url.
            'ServerName <usersubdomain>.'.$pro_url.'
				ServerAlias www.<usersubdomain>.'.$pro_url.'
				UseCanonicalName Off
				DirectoryIndex index.php
				DocumentRoot /var/www/html/'.$pro_url.'/public
				#ErrorLog /var/www/logsvhosts/'.$pro_url.'/users-error-log
				#LogLevel error
				#<IfModule mod_ssl.c> SSLEngine off </IfModule>
				<Directory /var/www/html/'.$pro_url.'/public >
					Options -Includes -ExecCGI
					Options Multiviews FollowSymLinks
				    MultiviewsMatch Any
				    AllowOverride All
				    Order allow,deny
				    Allow from all
				</Directory>
			</VirtualHost>';

        $case = 'create';//"create";

        $SubDomainName = $bodyName.'_'.$bodyOrg;

        $fullDomain=$SubDomainName.'.'.$pro_url;

        $file_check="/etc/apache2/sites-available/".$fullDomain.".conf";

        $string_Data = PHP_EOL.'127.0.0.1        '.$SubDomainName.'.'.$pro_url.PHP_EOL;

        if($case != '')
        {
            switch($case){
                case 'create':
                    if (!file_exists($file_check))
                    {

                        $domainStr2 = str_replace("<usersubdomain>",$SubDomainName,$templateStr);
                        $filename = "/etc/apache2/sites-available/".$fullDomain.".conf";
                        echo exec('sudo chmod -R 0777 /etc/apache2/sites-available/');
                        $fp = fopen($filename,"w") or die("go home");													  echo exec('sudo chmod -R 0777 '.$filename);
                        fwrite($fp,$domainStr2);					                         			  				  fclose($fp);

                        $str='sudo chmod -R 0777 '.$filename;
                        echo exec($str);
                        $file='/etc/hosts';
                        //$current=file_get_contents($file);

                        if(file_put_contents($file,$string_Data,FILE_APPEND))
                        {
                            $returnArray['FileWriteSuccess']= " $ success in writing hosts configuration file...";

                        }
                        else
                        {
                            echo " $ fail in writing \n";
                        }

                        echo exec('sudo service apache2 reload');

                        $SubDomainURL=$SubDomainName.".".$pro_url;

                        $returnArray['title']=$bodyName;
                        $returnArray['url']=$SubDomainURL;
                        $returnArray['org']=$bodyOrg;
                        $returnArray['body_type']=$bodyType;
                        $returnArray['db_name']=$bodyType.'_'.$bodyOrg;
                        $returnArray['registrationType']=$registrationType;

                        //return $returnArray;exit;

                        return RegistrationController::createBodyTypeDatabase($returnArray);

                    }else{
                        echo " $ oops this domain is already registered....\n";
                        exit;
                    }
                    break;

                case 'remove':

                default:

            }
        }

    }

    public function createDatabase($returnArray){

        $register=new organisation();
        $register->name=$returnArray['organisationName'];
        $register->url=$returnArray['SubDomainURL'];
        $register->slug=$returnArray['organisationName'];
        $register->save();

        echo "<a href='http://".$returnArray['SubDomainURL']."' target='_blank'>".$returnArray['SubDomainURL']."</a>";
        echo $register->id;

    }

    public function createBodyTypeDatabase($returnArray){

       // return $returnArray;

        $register=new body();
        $register->title=$returnArray['title'];
        $register->url=$returnArray['url'];
        $register->org=$returnArray['org'];
        $register->db_name=$returnArray['db_name'];
        $register->body_type=$returnArray['body_type'];
        $register->save();

        $query='create database IF NOT EXISTS `' . $register->db_name.'`';

        //echo $query;

       $result= \DB::statement($query);

      // echo $result;

        echo "<a href='http://".$returnArray['url']."' target='_blank'>".$returnArray['url']."</a>";

        echo $register->id;

    }

}
