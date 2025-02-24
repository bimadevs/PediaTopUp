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

        if(isset($_SESSION['phone']) || !empty($_SESSION['phone'])) {
            $CheckUsers = $this->M_Base->data_where('users', 'phone', $_SESSION['phone']);
            $_SESSION['name'] = $CheckUsers[0]['name']; // Add this line to set user's name in session

            $data = array_merge($this->base_data, [
                'title' => $this->M_Base->u_get('web-title'),
                'description' => $this->M_Base->u_get('web-description'),
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'Home',
                'slide' => explode(",", $this->M_Base->u_get('slide')),
                'category' => $getCategory,
                'users' => $CheckUsers[0]
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
                'category' => $getCategory
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
                $GetPassword = $CheckUsers[0]['password'];

                if(!password_verify($data_post['password'], $GetPassword)) {
                    $this->session->setFlashdata('error', 'No. Telepon atau Password salah!');
                    return redirect()->to('/login');
                } else {
                    $this->session->set('phone', $CheckUsers[0]['phone']);
                    $this->session->set('name', $CheckUsers[0]['name']); // Add this line
                    return redirect()->to('/');
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
                    'nom' => str_replace(".", "", $this->request->getPost('nominal')),
                ];

                $GetUsers  = $this->M_Base->data_where('users', 'id', $data_post['id']);
                $GetBanks  = $this->M_Base->data_where('bank', 'id', $data_post['bank']);

                if(count($GetUsers) === 0 || count($GetBanks) === 0) {
                    $this->session->setFlashdata('error', 'Ada kesalahan, silahkan coba kembali.');
                    return redirect()->to('/deposit');
                } else {
                    $DepositID  = 'D'.rand(1111111, 9999999);
                    $GetUniq = rand(111, 299);

                    $Dated = date('Y-m-d H:i:s');
                    $ExpiredDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($Dated)));

                    $data_insert = [
                        'id' => $DepositID,
                        'id_user' => $GetUsers[0]['id'],
                        'id_bank' => $GetBanks[0]['id'],
                        'total' => $data_post['nom'],
                        'uniq' => $GetUniq,
                        'created_at' => $Dated,
                        'updated_at' => $ExpiredDate
                    ];

                    if($this->M_Base->data_insert("deposit", $data_insert)) {
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
                    'bank' => $getBanks[0],
                    'deposits' => $CheckDeposit[0],
                    'users' => $CheckUsers[0]
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

            $getAllData = [];
            $getCategory = [];
            $Product = [];
            $GetDeposit = [];
            foreach (array_reverse($this->M_Base->data_join_where('users', 'transaction', 'transaction.id, transaction.product_id AS id_product, transaction.name, transaction.phone AS target, transaction.product, transaction.price, transaction.fee, transaction.total, transaction.metode, transaction.status, transaction.created_at, users.id AS id_user, users.email, users.phone', 'users.id = transaction.user_id', 'transaction.user_id', $CheckUsers[0]['id'])) as $data_loop) {
                $Product     = $this->M_Base->data_where('product', 'id', $data_loop['id_product']);
                $getCategory = $this->M_Base->data_where('category', 'id', $Product[0]['id_category']);
                $getAllData[] = [
                    'id'     => $data_loop['id'],
                    'name' => $data_loop['name'],
                    'product' => $Product[0],
                    'category' => $getCategory[0],
                    'date' => $data_loop['created_at']
                ];
            }

            foreach (array_reverse($this->M_Base->data_join_where('bank', 'deposit', 'deposit.id, deposit.total, deposit.uniq, deposit.status, deposit.created_at, bank.icon', 'bank.id = deposit.id_bank', 'deposit.id_user', $CheckUsers[0]['id'])) as $data_loop) {

                $GetDeposit[] = [
                    'id'     => $data_loop['id'],
                    'total' => $data_loop['total'],
                    'date'   => $data_loop['created_at'],
                    'icon' => $data_loop['icon'],
                    'category' => $getCategory[0],
                ];
            }


            $data = array_merge($this->base_data, [
                'HeaderTitle' => 'PediaTopup',
                'title' => $this->M_Base->u_get('web-title'),
                'curr' =>$this->M_Base->u_get('currency'),
                'description' => $this->M_Base->u_get('web-description'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'uri_segment' => 'Riwayat Transaksi',
                'bonus' => $this->M_Base->u_get('bonus-deposit'),
                'Transactions' => $getAllData,
                'Deposits' => $GetDeposit   
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
                    'fee' => $this->M_Base->u_get('fee'),
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
    
                if (count($GetUsers) === 0 && $GetProduct === 0) {
                    $this->session->setFlashdata('error', 'Produk tidak ditemukan');
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
                            'status' => 'Completed',
                            'ip' => $_SERVER['REMOTE_ADDR']
                        ];
    
                        if($this->M_Base->data_insert('transaction', $DataInsert)) {
                            $UpdateBalance = [
                                'balance' => $GetUsers[0]['balance'] - $Total
                            ];

                            $UpdateStock = [
                                'stock' => $GetProduct[0]['stock'] - 1
                            ];
    
                            $this->M_Base->data_update('users', $UpdateBalance, $data_post['id_user']);
                            $this->M_Base->data_update('product', $UpdateStock, $GetProduct[0]['id']);
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
        session_destroy();
        return redirect()->to('/');
    }

}
