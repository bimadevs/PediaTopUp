<?php

namespace App\Controllers;
use CodeIgniter\HTTP\URI;
$session = \Config\Services::session();

class Home extends BaseController
{
    public function index() {
        $getCategory = [];
        foreach (array_reverse($this->M_Base->all_data('category', 'status')) as $data_loop) {
            $getCategory[] = [
                'id'   => $data_loop['id'],
                'slug' => strtolower(str_replace(" ", "", $data_loop['name'])),
                'name' => $data_loop['name'],
				'img'  => $data_loop['icon']
            ];
        }
        
        $GetNotify = [];
        foreach (array_reverse($this->M_Base->all_data('notification', 'id')) as $data_loop) {
            $GetNotify[] = [
                'id'   => $data_loop['id'],
                'notify' => $data_loop['notify']
            ];
        }

        if(isset($_SESSION['phone']) || !empty($_SESSION['phone'])) {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);

            $data = array_merge($this->base_data, [
                'title' => $this->M_Base->u_get('web-title'),
                'description' => $this->M_Base->u_get('web-description'),
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'Home',
                'slide' => explode(",", $this->M_Base->u_get('slide')),
                'slide2' => explode(",", $this->M_Base->u_get('slide2')),
                'category' => $getCategory,
                'users' => $CheckUsers[0],
                'notify' => $GetNotify,
                'whatsapp' => $this->M_Base->u_get('phone')
            ]);
        } else {
            $data = array_merge($this->base_data, [
                'title' => $this->M_Base->u_get('web-title'),
                'description' => $this->M_Base->u_get('web-description'),
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'Home',
                'slide' => explode(",", $this->M_Base->u_get('slide')),
                'slide2' => explode(",", $this->M_Base->u_get('slide2')),
                'category' => $getCategory,
                'notify' => $GetNotify,
                'whatsapp' => $this->M_Base->u_get('phone')
            ]);
        }
               
        return view('Home/index', $data);
    }

    public function LoginIndex() {
        $data = array_merge($this->base_data, [
            'HeaderTitle' => $this->M_Base->u_get('web-title'),
    		'title' => $this->M_Base->u_get('web-title'),
            'description' => $this->M_Base->u_get('web-description'),
            'web_name'  => $this->M_Base->u_get('web-title'),
            'logo'  => $this->M_Base->u_get('web-logo'),
            'icon'  => $this->M_Base->u_get('web-icon'),
            'uri_segment' => 'login'
    	]);

        return view('Auth/login', $data);
    }

    public function LoginCheck() {
        if(empty($this->request->getVar('csrf_test_name'))) {
            return redirect()->to('/login');
        } else {
            $data_post = [
                'phone' => $this->request->getPost('phone'),
                'password' => $this->request->getPost('password')
            ];

            $CheckUsers = $this->M_Base->data_where('users', 'phone', $data_post['phone']);

            if(count($CheckUsers) == 0) {
                $this->session->setFlashdata('error', 'No. Telepon atau Password salah!');
                return redirect()->to('/login');
            } else {
                if ($CheckUsers[0]['level'] === "Member") {
                    $GetPassword = $CheckUsers[0]['password'];

                    if(!password_verify($data_post['password'], $GetPassword)) {
                        $this->session->setFlashdata('error', 'No. Telepon atau Password salah!');
                        return redirect()->to('/login');
                    } else {
                        $this->session->set('phone', $CheckUsers[0]['phone']);
                        return redirect()->to('/');
                    }
                } else {
                    $this->session->setFlashdata('error', 'No. Telepon atau Password salah!');
                    return redirect()->to('/login');
                }
            }
        }
    }

    public function RegisterIndex() {
        $data = array_merge($this->base_data, [
            'HeaderTitle' => $this->M_Base->u_get('web-title'),
    		'title' => $this->M_Base->u_get('web-title'),
            'description' => $this->M_Base->u_get('web-description'),
            'web_name'  => $this->M_Base->u_get('web-title'),
            'logo'  => $this->M_Base->u_get('web-logo'),
            'icon'  => $this->M_Base->u_get('web-icon'),
            'uri_segment' => 'Daftar Akun'
    	]);

        return view('Auth/register', $data);
    }

    public function RegisterCheck() {
        if(empty($this->request->getVar('csrf_test_name'))) {
            return redirect()->to('/login');
        } else {
            $data_post = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'password' => $this->request->getPost('password')
            ];

            $CheckUsers = $this->M_Base->data_where('users', 'phone', $data_post['phone']);

            if(count($CheckUsers) == 1) {
                $this->session->setFlashdata('error', 'No. Telepon sudah digunakan, gunakan nomor yang lain');
                return redirect()->to('/login');
            } else {
                $dataInsert = [
                    'name'     => $data_post['nama'],
                    'email'    => $data_post['email'],
                    'phone'    => $data_post['phone'],
                    'password' => password_hash($data_post['password'], PASSWORD_BCRYPT)
                ];                
            
                if($this->M_Base->data_insert('users', $dataInsert)) {
                    $this->session->setFlashdata('success', 'Pendaftaran akun berhasil, silahkan login menggunakan akun anda');
                    return redirect()->to('/login');
                }
            }
        }
    }

    public function DepositIndex() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);

            $getBanks = [];
            foreach (array_reverse($this->M_Base->all_data('bank', 'id')) as $data_loop) {
                $getBanks[] = [
                    'id'   => $data_loop['id'],
                    'name' => $data_loop['name'],
                    'number' => $data_loop['number'],
                    'behalf' => $data_loop['behalf'],
                    'icon' => $data_loop['icon'],
                    'min' => $data_loop['minimum'],
                    'status' => $data_loop['status']
                ];
            }
            
            $getDepositAmount = [];
            foreach (array_reverse($this->M_Base->data_where('deposit_amount', 'status', '1')) as $data_loop) {
                $getDepositAmount[] = [
                    'id'     => $data_loop['id'],
                    'amount' => $data_loop['amount']
                ];
            }

            $data = array_merge($this->base_data, [
                'HeaderTitle' => 'Deposit',
                'title' => $this->M_Base->u_get('web-title'),
                'curr' =>$this->M_Base->u_get('currency'),
                'description' => $this->M_Base->u_get('web-description'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'Deposit',
                'bonus' => $this->M_Base->u_get('bonus-deposit'),
                'bank' => $getBanks,
                'deposit_amount' => $getDepositAmount,
                'users' => $CheckUsers[0]
            ]);
    
            return view('Home/deposit', $data);
        }
    }

    public function DepositCreate() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/login');
            } else {
                $data_post = [
                    'id' => $this->request->getPost('id'),
                    'bank' => $this->request->getPost('bank'),
                    'nom' => $this->request->getPost('nominal'),
                    'percent' => $this->request->getPost('percent'),
                    'total' => $this->request->getPost('total'),
                ];

                $GetUsers  = $this->M_Base->data_where('users', 'id', $data_post['id']);
                $GetBanks  = $this->M_Base->data_where('bank', 'id', $data_post['bank']);

                if(count($GetUsers) === 0 || count($GetBanks) === 0) {
                    $this->session->setFlashdata('error', 'Ada kesalahan, silahkan coba kembali.');
                    return redirect()->to('/deposit');
                } else {
                    
                    $DepositID  = 'D'.rand(1111111, 9999999);
                   // $GetUniq = rand(111, 299);
    
                    $Dated = date('Y-m-d H:i:s');
                    $ExpiredDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($Dated)));
                    
                    if($data_post['nom'] == $data_post['total']) {
                
                        $data_insert = [
                            'id' => $DepositID,
                            'id_user' => $GetUsers[0]['id'],
                            'id_bank' => $GetBanks[0]['id'],
                            'total' => $data_post['nom'],
                           // 'uniq' => $GetUniq,
                            'created_at' => $Dated,
                            'updated_at' => $ExpiredDate
                        ];
                        
                        $Bonus = $this->M_Base->u_get('currency') . "0";
                    } else {
                        $data_insert = [
                            'id' => $DepositID,
                            'id_user' => $GetUsers[0]['id'],
                            'id_bank' => $GetBanks[0]['id'],
                            'total' => $data_post['nom'],
                           // 'uniq' => $GetUniq,
                            'bonus' => $data_post['total'] - $data_post['nom'],
                            'created_at' => $Dated,
                            'updated_at' => $ExpiredDate
                        ];
                        
                        $Bonus = $this->M_Base->u_get('currency') . "" . number_format($data_post['total'] - $data_post['nom'], 0, ",", ".");
                    }
                    
                    $Nominal = $this->M_Base->u_get('currency') . "" . number_format($data_post['nom'], 0, ",", ".");
                    
                    $message =  '--[ Permintaan Deposit ]--' . PHP_EOL . PHP_EOL . '- Invoice: #' . $DepositID . PHP_EOL . '- Nama: ' . $GetUsers[0]['name'] . PHP_EOL . '- No.HP/WA: <code>' . $GetUsers[0]['phone'] . "</code>" . PHP_EOL . "- Nominal: " . $Nominal . PHP_EOL . "- Bonus Saldo: " . $Bonus . PHP_EOL . '- Tanggal: ' . $this->M_Base->tanggal_indo(date('Y-m-d', strtotime($Dated))) .  PHP_EOL . "- Status: Pending" . PHP_EOL . PHP_EOL . 'By PediaTopup';
                
                    if($this->M_Base->data_insert("deposit", $data_insert)) {
                        $this->TelegramMsg($message);
                        $this->session->setFlashdata('deposit_success', 'Permintaan deposit berhasil dibuat');
                        return redirect()->to('/deposit/detail/'.$DepositID);
                    }
                }
                
            }
            
        }
    }

    public function DepositDetail($id) {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $CheckDeposit = $this->M_Base->data_where('deposit', 'id', $id);

            if(count($CheckDeposit) === 0) {
                $this->session->setFlashdata('error', 'Transaksi #'.$id.' tidak ditemukan');
                return redirect()->to('/deposit');
            } else {
                $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
                $getBanks = $this->M_Base->data_where('bank', 'id', $CheckDeposit[0]['id_bank']);
                
                if(count($getBanks) === 0) {
                    $GetBanks = [];
                    $BankName = "-";
                    $BankNumb = "-";
                    $BankBeha = "-";
                    $BankIcon = "-";
                    $BankPayment = "-";
                } else {
                    $GetBanks = $getBanks[0];
                    $BankName = $getBanks[0]['name'];
                    $BankNumb = $getBanks[0]['number'];
                    $BankBeha = $getBanks[0]['behalf'];
                    $BankIcon = $getBanks[0]['icon'];
                    $BankPayment = $getBanks[0]['payment_code'];
                }

                $data = array_merge($this->base_data, [
                    'HeaderTitle' => 'PediaTopup',
                    'title' => $this->M_Base->u_get('web-title'),
                    'curr' =>$this->M_Base->u_get('currency'),
                    'description' => $this->M_Base->u_get('web-description'),
                    'web_name'  => $this->M_Base->u_get('web-title'),
                    'logo'  => $this->M_Base->u_get('web-logo'),
                    'icon'  => $this->M_Base->u_get('web-icon'),
                    'uri_segment' => 'Detail Deposit',
                    'bonus' => $this->M_Base->u_get('bonus-deposit'),
                    'bank' => $GetBanks,
                    'bank_name' => $BankName,
                    'bank_numb' => $BankNumb,
                    'bank_beha' => $BankBeha,
                    'bank_icon' => $BankIcon,
                    'bank_payment' => $BankPayment,
                    'deposits' => $CheckDeposit[0],
                    'users' => $CheckUsers[0],
                    'date' => $this->M_Base->tanggal_indo(date('Y-m-d', strtotime($CheckDeposit[0]['created_at']))),
                    'expiredDate' => $this->M_Base->tanggal_indo(date('Y-m-d', strtotime($CheckDeposit[0]['updated_at'])))
                ]);
        
                return view('Home/deposit-detail', $data);
            }

            
        }
    }

    public function HistoryIndex() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);

            $getTransaction = [];
            foreach (array_reverse($this->M_Base->data_where('transaction', 'user_id', $CheckUsers[0]['id'])) as $data_loop) {
                $getTransaction[] = [
                    'id'   => $data_loop['id'],
                    'product' => $data_loop['product'],
                    'price' => $data_loop['price'],
                    'status' => $data_loop['status'],
                    'date' => $data_loop['created_at']
                ];
            }
            
            $getDeposit = [];
            foreach (array_reverse($this->M_Base->data_where('deposit', 'id_user', $CheckUsers[0]['id'])) as $data_loop) {
                $GetBank = $this->M_Base->data_where('bank', 'id', $data_loop['id_bank']);
                
                if(count($GetBank) === 0) {
                    $BankIcon = "-";
                } else {
                    $BankIcon = $GetBank[0]['icon'];
                }
                
                $getDeposit[] = [
                    'id'   => $data_loop['id'],
                    'total' => $data_loop['total'],
                    'status' => $data_loop['status'],
                    'date' => $data_loop['created_at'],
                    'icon' => $BankIcon
                ];
            }
            
            $getWithdrawal = [];
            foreach (array_reverse($this->M_Base->data_where('withdrawal', 'id_user', $CheckUsers[0]['id'])) as $data_loop) {
                $GetBank = $this->M_Base->data_where('bank', 'id', $data_loop['id_bank']);
                
                if(count($GetBank) === 0) {
                    $BankIcon = "-";
                } else {
                    $BankIcon = $GetBank[0]['icon'];
                }
                
                $getWithdrawal[] = [
                    'id'   => $data_loop['id'],
                    'total' => $data_loop['total'],
                    'fee' => $data_loop['fee'],
                    'status' => $data_loop['status'],
                    'date' => $data_loop['created_at'],
                    'icon' => $BankIcon
                ];
            }

            $data = array_merge($this->base_data, [
                'HeaderTitle' => 'Riwayat',
                'title' => $this->M_Base->u_get('web-title'),
                'curr' =>$this->M_Base->u_get('currency'),
                'description' => $this->M_Base->u_get('web-description'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'history',
                'Transaction' => $getTransaction,
                'Deposits' => $getDeposit,
                'Withdrawals' => $getWithdrawal,
                'users' => $CheckUsers[0]
            ]);
    
            return view('Home/history', $data);
        }
    }

    public function CategoryDetail($id) {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
                
            $checkSlug = $this->M_Base->data_count('category', $id);
            if($checkSlug == 1) {
                $GetSlugDetail = $this->M_Base->data_where('category', 'slug', $id);

                $getProduct = [];
                foreach (array_reverse($this->M_Base->data_where('product', 'slug', $id)) as $data_loop) {
                    $getProduct[] = [
                        'id'   => $data_loop['id'],
                        'slug' => $data_loop['slug'],
                        'name' => $data_loop['name'],
                        'stock' => $data_loop['stock'],
                        'price'  => $data_loop['price']
                    ];
                }

                $data = array_merge($this->base_data, [
                    'title' => $this->M_Base->u_get('web-title'),
                    'HeaderTitle' => $this->M_Base->u_get('web-title'),
                    'description' => $this->M_Base->u_get('web-description'),
                    'curr' =>$this->M_Base->u_get('currency'),
                    'web_name'  => $this->M_Base->u_get('web-title'),
                    'logo'  => $this->M_Base->u_get('web-logo'),
                    'icon'  => $this->M_Base->u_get('web-icon'),
                    'fee' => (float)$this->M_Base->u_get('fee'),
                    'slug'  => $GetSlugDetail[0]['name'],
                    'uri_segment' => 'Top Up ' . $GetSlugDetail[0]['name'],
                    'icon_slug' => $GetSlugDetail[0]['icon'],
                    'product' => $getProduct,
                    'users' => $CheckUsers[0]
                ]);

                return view('Buy/index', $data);
            } else {
                $this->session->setFlashdata('error', 'Produk tidak ditemukan');
                return redirect()->to('/');
            }
        }
        
    }

    public function BuyProduct() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                return redirect()->to('/');
            } else {
                
                $data_post = [
                    'id_user' => $this->request->getPost('idUser'),
                    'phone'   => $this->request->getPost('orderPhone'),
                    'product' => $this->request->getPost('idProduct')
                ];
    
                $GetUsers   = $this->M_Base->data_where('users', 'id', $data_post['id_user']);
                $GetProduct = $this->M_Base->data_where('product', 'id', $data_post['product']);
    
                if (count($GetUsers) === 0 || count($GetProduct) === 0) {
                    $this->session->setFlashdata('error', 'Produk tidak ditemukan');
                    return redirect()->to('/');
                } elseif($GetUsers[0]['status'] == "Off") {
                    $this->session->setFlashdata('error', 'Naikan Level Akun Untuk Transaksi');
                    return redirect()->to('/');
                } else {
                    $Total = $GetProduct[0]['price'] + $this->M_Base->u_get('fee');
    
                    if($GetUsers[0]['balance'] < $Total) {
                        $this->session->setFlashdata('error', 'Saldo anda tidak cukup, silahkan lakukan deposit.');
                        return redirect()->to('/');
                    } else {
                        $OrderID    = 'P'.rand(1111111, 9999999);
    
                        $DataInsert = [
                            'id' => $OrderID,
                            'user_id' => $GetUsers[0]['id'],
                            'product_id' => $GetProduct[0]['id'],
                            'name' => $GetUsers[0]['name'],
                            'phone' => $data_post['phone'],
                            'product' => $GetProduct[0]['name'],
                            'price' => $GetProduct[0]['price'],
                            'fee' => $this->M_Base->u_get('fee'),
                            'total' => $Total,
                            'metode' => 'Saldo',
                            'status' => 'Processing',
                            'ip' => $_SERVER['REMOTE_ADDR']
                        ];
                        
                        $Price = $this->M_Base->u_get('currency') . number_format($GetProduct[0]['price'], 0, ",", ".");
                        
                        $Fee = $this->M_Base->u_get('currency') . number_format($this->M_Base->u_get('fee'), 0, ",", ".");
                        
                        $Total = $this->M_Base->u_get('currency') . number_format($Total, 0, ",", ".");
    
                        $message = '--[ Permintaan Transaksi ]--' . PHP_EOL . PHP_EOL . '- Invoice: #' . $OrderID . PHP_EOL . '- Nama: ' . $GetUsers[0]['name'] . PHP_EOL . '- Product: ' . $GetProduct[0]['name'] . PHP_EOL . '- Nomor: ' . $this->request->getPost('orderPhone') . PHP_EOL . '- Price: ' . $GetProduct[0]['price'] . PHP_EOL . '- Fee: ' . $this->M_Base->u_get('fee') . PHP_EOL . '- Total: ' . $Total . PHP_EOL . '- Tanggal: ' . $this->M_Base->tanggal_indo(date('Y-m-d')) . PHP_EOL . '- Status: Pending' . PHP_EOL . PHP_EOL . 'By PediaTopup';
                
                        if($this->M_Base->data_insert('transaction', $DataInsert)) {
                            $this->TelegramMsg($message);
                            // $UpdateBalance = [
                            //     'balance' => $GetUsers[0]['balance'] - $Total
                            // ];

                            // $UpdateStock = [
                            //     'stock' => $GetProduct[0]['stock'] - 1
                            // ];
    
                            // $this->M_Base->data_update('users', $UpdateBalance, $data_post['id_user']);
                            // $this->M_Base->data_update('product', $UpdateStock, $GetProduct[0]['id']);
                            return redirect()->to('/order/detail/'.$OrderID);
                        }
                    }
                    
                }
            }
        }
    }    
                        
    public function detailOrder($id) {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            $this->session->setFlashdata('error', 'Login untuk melanjutkan');
            return redirect()->to('/login');
        } else {
            $GetTransaction = $this->M_Base->data_where('transaction', 'id', $id);

            if(count($GetTransaction) === 1) {
                $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
    
                $data = array_merge($this->base_data, [
                    'title' => "PediaTopup",
                    'HeaderTitle' => 'PediaTopup',
                    'description' => $this->M_Base->u_get('web-description'),
                    'curr' =>$this->M_Base->u_get('currency'),
                    'web_name'  => $this->M_Base->u_get('web-title'),
                    'logo'  => $this->M_Base->u_get('web-logo'),
                    'icon'  => $this->M_Base->u_get('web-icon'),
                    'uri_segment' => 'Detail Pesanan',
                    'GetTransaction' => $GetTransaction,
                    'users' => $CheckUsers[0]
                ]);
    
                return view('Buy/detail', $data);
            } else {
                $this->session->setFlashdata('error', 'Transaksi tidak ditemukan');
                return redirect()->to('/');
            }
        }
        
    }

    public function Logout() {
        session()->destroy();
        return redirect()->to('/');
    }

    public function removeNotification() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda harus login terlebih dahulu']);
        }
        
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        
        if (empty($id) || empty($type)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter tidak lengkap']);
        }
        
        $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
        
        if (count($CheckUsers) === 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pengguna tidak ditemukan']);
        }
        
        // Menentukan tabel berdasarkan tipe notifikasi
        $table = '';
        switch ($type) {
            case 'transaction':
                $table = 'transaction';
                break;
            case 'deposit':
                $table = 'deposit';
                break;
            case 'withdrawal':
                $table = 'withdrawal';
                break;
            default:
                return $this->response->setJSON(['success' => false, 'message' => 'Tipe notifikasi tidak valid']);
        }
        
        // Memeriksa apakah notifikasi milik pengguna yang sedang login
        $notification = $this->M_Base->data_where($table, 'id', $id);
        
        if (count($notification) === 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notifikasi tidak ditemukan']);
        }
        
        // Memeriksa kepemilikan notifikasi
        $user_id_field = ($type === 'transaction') ? 'user_id' : 'id_user';
        
        if ($notification[0][$user_id_field] != $CheckUsers[0]['id']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda tidak memiliki akses ke notifikasi ini']);
        }
        
        // Menandai notifikasi sebagai dihapus (soft delete)
        // Kita bisa menambahkan kolom is_deleted atau mengubah status
        // Untuk sementara, kita akan menghapus notifikasi dari tampilan saja
        
        return $this->response->setJSON(['success' => true, 'message' => 'Notifikasi berhasil dihapus']);
    }

    public function WithdrawalIndex() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $data_users = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
            
            if (count($data_users) === 0) {
                return redirect()->to('/logout');
            }
            
            $data = array_merge($this->base_data, [
                'title' => 'Penarikan Saldo',
                'HeaderTitle' => 'Penarikan Saldo',
                'description' => 'Penarikan Saldo - ' . $this->M_Base->u_get('web-title'),
                'uri_segment' => 'withdrawal',
                'users' => $data_users[0],
                'curr' => $this->M_Base->u_get('currency'),
                'fee' => $this->M_Base->u_get('fee-withdrawal'),
                'bank' => $this->M_Base->data_where('bank_withdrawal', 'status', 'On'),
                'withdrawal_amount' => $this->M_Base->data_where('withdrawal_amount', 'status', '1'),
            ]);
            
            return view('Home/withdrawal', $data);
        }
    }
    
    public function WithdrawalCreate() {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
            
            $id_user = $CheckUsers[0]['id'];
            $id_bank = $this->request->getPost('bank');
            $bank_account = $this->request->getPost('bank_account');
            $account_name = $this->request->getPost('account_name');
            $nominal = $this->request->getPost('nominal');
            $total = $this->request->getPost('total');
            $fee = $nominal - $total;
            
            if (empty($nominal) || $nominal <= 0) {
                $this->session->setFlashdata('error', 'Nominal penarikan tidak valid');
                return redirect()->to('/withdrawal');
            }
            
            if ($nominal > $CheckUsers[0]['balance']) {
                $this->session->setFlashdata('error', 'Saldo kamu tidak cukup');
                return redirect()->to('/withdrawal');
            }
            
            // Generate ID
            $id = 'WD' . rand(100000, 999999);
            
            $data = [
                'id' => $id,
                'id_user' => $id_user,
                'id_bank' => $id_bank,
                'bank_account' => $bank_account,
                'account_name' => $account_name,
                'total' => $total,
                'fee' => $fee,
                'status' => 'pending',
            ];
            
            if ($this->M_Base->data_insert('withdrawal', $data)) {
                // Kurangi saldo user
                $new_balance = $CheckUsers[0]['balance'] - $nominal;
                $this->M_Base->data_update('users', [
                    'balance' => $new_balance
                ], $id_user);
                
                // Kirim notifikasi ke admin via Telegram jika ada
                $bank = $this->M_Base->data_where('bank_withdrawal', 'id', $id_bank);
                $bank_name = count($bank) > 0 ? $bank[0]['name'] : '-';
                
                $message = '--[ Permintaan Penarikan Saldo ]--' . PHP_EOL . PHP_EOL;
                $message .= '- Invoice: #' . $id . PHP_EOL;
                $message .= '- Nama: ' . $CheckUsers[0]['name'] . PHP_EOL;
                $message .= '- No.HP/WA: ' . $CheckUsers[0]['phone'] . PHP_EOL;
                $message .= '- Bank: ' . $bank_name . PHP_EOL;
                $message .= '- No. Rekening: ' . $bank_account . PHP_EOL;
                $message .= '- Nama Pemilik: ' . $account_name . PHP_EOL;
                $message .= '- Nominal: ' . $this->M_Base->u_get('currency') . '' . number_format($nominal, 0, ',', '.') . PHP_EOL;
                $message .= '- Biaya Admin: ' . $this->M_Base->u_get('currency') . '' . number_format($fee, 0, ',', '.') . PHP_EOL;
                $message .= '- Total Diterima: ' . $this->M_Base->u_get('currency') . '' . number_format($total, 0, ',', '.') . PHP_EOL;
                $message .= '- Tanggal: ' . $this->M_Base->tanggal_indo(date('Y-m-d')) . PHP_EOL;
                $message .= '- Status: Pending' . PHP_EOL . PHP_EOL;
                $message .= 'By ' . $this->M_Base->u_get('web-title');
                
                $this->TelegramMsg($message);
                
                $this->session->setFlashdata('success', 'Penarikan saldo berhasil diproses');
                return redirect()->to('/withdrawal/detail/' . $id);
            } else {
                $this->session->setFlashdata('error', 'Terjadi kesalahan, silakan coba lagi');
                return redirect()->to('/withdrawal');
            }
        }
    }
    
    public function WithdrawalDetail($id) {
        if(!isset($_SESSION['phone']) || empty($_SESSION['phone'])) {
            return redirect()->to('/login');
        } else {
            $data_users = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
            
            if (count($data_users) === 0) {
                return redirect()->to('/logout');
            }
            
            $withdrawal = $this->M_Base->data_where('withdrawal', 'id', $id);
            
            if (count($withdrawal) === 0) {
                return redirect()->to('/withdrawal');
            }
            
            if ($withdrawal[0]['id_user'] !== $data_users[0]['id']) {
                return redirect()->to('/withdrawal');
            }
            
            $bank = $this->M_Base->data_where('bank_withdrawal', 'id', $withdrawal[0]['id_bank']);
            $bank_name = count($bank) > 0 ? $bank[0]['name'] : '-';
            $bank_icon = count($bank) > 0 ? $bank[0]['icon'] : 'bank.jpg';
            
            $data = array_merge($this->base_data, [
                'title' => 'Detail Penarikan',
                'HeaderTitle' => 'Detail Penarikan',
                'description' => 'Detail Penarikan Saldo #' . $id . ' - ' . $this->M_Base->u_get('web-title'),
                'uri_segment' => 'withdrawal',
                'users' => $data_users[0],
                'curr' => $this->M_Base->u_get('currency'),
                'withdrawal' => $withdrawal[0],
                'bank_name' => $bank_name,
                'bank_icon' => $bank_icon,
                'date' => $this->M_Base->tanggal_indo(date('Y-m-d', strtotime($withdrawal[0]['created_at']))),
            ]);
            
            return view('Home/withdrawal-detail', $data);
        }
    }

}