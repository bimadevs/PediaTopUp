<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Encryption;

use App\Models\M_Base;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $base_data;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form'];
    

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        
        date_default_timezone_set('Asia/Jakarta');

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $agent = $this->request->getUserAgent();
        if (preg_match("/webzip|httrack|wget|FlickBot|downloader|production
        bot|superbot|PersonaPilot|NPBot|WebCopier|vayala|imagefetch|
        Microsoft URL Control|mac finder|
        emailreaper|emailsiphon|emailwolf|emailmagnet|emailsweeper|
        Indy Library|FrontPage|cherry picker|WebCopier|netzip|
        Share Program|TurnitinBot|full web bot|zeus/i", $agent->getAgentString())) {
            die('- Sttt...');
        }

        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        $this->M_Base = new M_Base;

        $this->ip = $this->request->getIPAddress();
        $this->browser = $agent->getBrowser();
        $this->user_agent = $agent->getAgentString();

        if ($this->session->get('email')) {
            $data_users = $this->M_Base->data_where_array('users', [
                'email' => $this->session->get('email'),
                'status' => 'On',
            ]);

            if (count($data_users) === 1) {
                $users = $data_users[0];
            } else {
                $users = false;
            }
        } else {
            $users = false;
        }

        // Hitung jumlah penarikan pending untuk badge notifikasi
        $pending_withdrawals = 0;
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            foreach (array_reverse($this->M_Base->data_where('withdrawal', 'status', 'pending')) as $data_loop) {
                $pending_withdrawals++;
            }
        }

        $this->base_data = [
            'users' => $users,
            'web' => [
                'title' => $this->M_Base->u_get('web-title'),
                'icon' => $this->M_Base->u_get('web-icon'),
                'logo' => $this->M_Base->u_get('web-logo'),
                'author' => $this->M_Base->u_get('web-author'),
                'keywords' => $this->M_Base->u_get('web-keywords'),
                'description' => $this->M_Base->u_get('web-description'),
            ],
            'pending_withdrawals' => $pending_withdrawals
        ];
    }
    
    public function Encrypted($Password) {
        $config         = config(Encryption::class);
        $config->driver = 'OpenSSL';

        $encrypter = service('encrypter', $config);
        
        $ciphertext = $encrypter->encrypt($Password);
        return base64_encode($ciphertext);

        //default menggunakan MCRYPT_RIJNDAEL_256 

        // $hasil_dekripsi = $this->encrypt->decode($hasil_enkripsi, $Key); 
        

    }
    
    public function Decrypted($Password) {

        $config         = config(Encryption::class);
        $config->driver = 'OpenSSL';

        $encrypter = service('encrypter', $config);
        
        $ciphertext = $encrypter->decrypt(base64_decode($Password));
        return $ciphertext;
    }
    
    public function TelegramMsg($Msg) {
        $url = "https://api.telegram.org/bot" . $this->M_Base->u_get('bot_token') . "/sendMessage?chat_id=" . $this->M_Base->u_get('chat_id');
        $url = $url . "&text=" . urlencode($Msg) . "&parse_mode=html";
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function msg($nomor, $msg)
    {

        $apiKey = $this->M_Base->u_get('wa_apikey');
	    $apiUrl = $this->M_Base->u_get('wa_apiurl');
	    $sender = $this->M_Base->u_get('wa_sender');

        $data = [
            'api_key' => $apiKey,
            'sender'  => $sender,
            'number'  => $nomor,
            'message' => $msg
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl.'/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
