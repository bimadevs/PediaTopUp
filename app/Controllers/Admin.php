<?php 

namespace App\Controllers;
use CodeIgniter\HTTP\URI;
use CodeIgniter\Files\File;
$session = \Config\Services::session();

class Admin extends BaseController
{

    protected $helpers = ['form'];

    public function index() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $Total = 0;
            foreach (array_reverse($this->M_Base->data_where('deposit', 'status', 'approved')) as $data_loop) {
                $Total += $data_loop['total'];
            }
            
            // Hitung jumlah penarikan pending
            $pendingWithdrawals = 0;
            foreach (array_reverse($this->M_Base->data_where('withdrawal', 'status', 'pending')) as $data_loop) {
                $pendingWithdrawals++;
            }
            
            $data = array_merge($this->base_data, [
                'title' => 'Dashboard',
                'uri_segment' => 'admin',
                'users' => $data_email[0],
'curr' =>$this->M_Base->u_get('currency'),
'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
'icon'  => $this->M_Base->u_get('web-icon'),
                'total' => [
                    'users'   => $this->M_Base->data_count('users'),
                    'deposit' => $Total,
                    'order'   => $this->M_Base->data_count('transaction'),
                    'pending_withdrawals' => $pendingWithdrawals
                ],
            ]);
    
            return view('Admin/index', $data);
        }
    }

    public function AuthIndex() {
        $data = array_merge($this->base_data, [
            'title' => 'Login Admin',
            'uri_segment' => 'login',
            'logo' => $this->M_Base->u_get('web-logo')
        ]);

        return view('Admin/auth', $data);
    }

    public function checkAccount() {
        if(empty($this->request->getVar('csrf_test_name'))) {
            $this->session->setFlashdata('auth_error', 'Email/password salah');
            return redirect()->to('/');
        } else {
            $data_post = [
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];

            if(empty($data_post['email']) OR empty($data_post['password'])) {
                $this->session->setFlashdata('auth_error', 'Lengkapi semua data');
                return redirect()->to('/admin/auth');
            } else {
                $data_email = $this->M_Base->data_where('users', 'email', $data_post['email']);
                
                if (count($data_email) === 1) {
                    if ($data_email[0]['level'] === "Admin") {
                        if (password_verify($data_post['password'], $data_email[0]['password'])) {
                            $this->session->sess_expiration = '31540000'; // expired in 365 Days
                            $this->session->set('email', $data_email[0]['email']);
                                
                            return redirect()->to('/admin');
                        } else {
                            $this->session->setFlashdata('auth_error', 'Login Gagal! Email / password salah.');
                            return redirect()->to('/admin/auth');
                        }
                    } else {
                        $this->session->setFlashdata('auth_error', 'Login Gagal! Email / password salah.');
                        return redirect()->to('/admin/auth');
                    }
                } else {
                    $this->session->setFlashdata('auth_error', 'Login Gagal! Email / password salah.');
                    return redirect()->to('/admin/auth');
                }
            }
        }
    }

    public function UsersIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getAllUsers = [];
            foreach (array_reverse($this->M_Base->data_where('users', 'level', 'Member', 'created_at')) as $data_loop) {
                $getAllUsers[] = [
                    'id'     => $data_loop['id'],
                    'name'   => $data_loop['name'],
                    'phone'   => $data_loop['phone'],
                    'email'   => $data_loop['email'],
                    'balance' => $data_loop['balance'],
                    'status'  => $data_loop['status'],
                    'tanggal' => $data_loop['created_at']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Pengguna',
                'uri_segment' => 'users',
                'users' => $data_email[0],
'curr' =>$this->M_Base->u_get('currency'),
'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
'icon'  => $this->M_Base->u_get('web-icon'),
                'all_users' => $getAllUsers
            ]);
    
            return view('Admin/users', $data);
        }
    }

    public function UsersAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/users');
            } else {
                $data_post = [
                    'nama'     => $this->request->getPost('fullname'),
                    'phone'    => $this->request->getPost('phone'),
                    'email'    => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'balance'  => $this->request->getPost('balance'),
                    'status'   => $this->request->getPost('status')
                ];

                $checkUsers = $this->M_Base->data_where('users', 'phone', $data_post['phone']);

                if (count($checkUsers) === 1) {
                    $this->session->setFlashdata('errors', 'Gagal! No.Telepon sudah digunakan');
                    return redirect()->to('/admin/users');
                } else {
                    $dataInsert = [
                        'name'     => $data_post['nama'],
                        'phone'    => $data_post['phone'],
                        'password' => password_hash($data_post['password'], PASSWORD_BCRYPT),
                        'email'    => $data_post['email'],
                        'balance'  => $data_post['balance'],
                        'status'   => $data_post['status']
                    ];

                    if($this->M_Base->data_insert('users', $dataInsert)) {
                        $this->session->setFlashdata('success', 'Horee! Pengguna baru berhasil ditambahkan');
                        return redirect()->to('/admin/users');
                    }
                }
            }
        }

    }

    public function UsersEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/users');
            } else {
                $data_post = [
                    'id'       => $this->request->getPost('id'),
                    'nama'     => $this->request->getPost('fullname'),
                    'phone'    => $this->request->getPost('phone'),
                    'email'    => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'balance'  => $this->request->getPost('balance'),
                    'status'   => $this->request->getPost('status')
                ];

                $checkUsers = $this->M_Base->data_where('users', 'phone', $data_post['phone']);

                if (count($checkUsers) === 1 && $checkUsers[0]['id'] != $data_post['id']) {
                    $this->session->setFlashdata('errors', 'Gagal! No.Telepon sudah digunakan');
                    return redirect()->to('/admin/users');
                } else {

                    if(empty($data_post['password'])) {
                        $dataUpdate = [
                            'name'     => $data_post['nama'],
                            'phone'    => $data_post['phone'],
                            'email'    => $data_post['email'],
                            'balance'  => $data_post['balance'],
                            'status'   => $data_post['status']
                        ];
                    } else {
                        $dataUpdate = [
                            'name'     => $data_post['nama'],
                            'phone'    => $data_post['phone'],
                            'password' => password_hash($data_post['password'], PASSWORD_BCRYPT),
                            'email'    => $data_post['email'],
                            'balance'  => $data_post['balance'],
                            'status'   => $data_post['status']
                        ];
                    }

                    
                    if($this->M_Base->data_update('users', $dataUpdate, $data_post['id'])) {
                        $this->session->setFlashdata('success', 'Horee! Pengguna berhasil diupdate');
                        return redirect()->to('/admin/users');
                    }
                }
            }
        }

    }

    public function deleteUser($id) {
        $getData = $this->M_Base->data_where('users', 'id', $id);

        if (count($getData) === 0) {
            $this->session->setFlashdata('error', 'Gagal! Pengguna tidak ditemukan');
            return redirect()->to('/admin/users');
        } else {
            $this->M_Base->data_delete("users", $id);
            $this->session->setFlashdata('success', 'Horee! Pengguna berhasil dihapus');
            return redirect()->to('/admin/users');
        }
    }

    public function ProductIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getCategory = [];
            foreach (array_reverse($this->M_Base->all_data('category', 'id')) as $data_loop) {
                $getCategory[] = [
                    'id'   => $data_loop['id'],
                    'name' => $data_loop['name']
                ];
            }

            $getAllData = [];
            foreach (array_reverse($this->M_Base->data_join('product', 'category', 'category.id AS idcat, category.slug, category.name AS catname, product.id, product.name, product.price, product.stock, product.status, product.created_at', 'category.id = product.id_category', 'slug')) as $data_loop) {
                $getAllData[] = [
                    'id'     => $data_loop['id'],
                    'idcat' => $data_loop['idcat'],
                    'slug'   => $data_loop['slug'],
                    'category' => $data_loop['catname'],
                    'product'  => $data_loop['name'],
                    'price' => $data_loop['price'],
                    'stock'  => $data_loop['stock'],
                    'status' => $data_loop['status']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Produk',
                'uri_segment' => 'product',
                'users' => $data_email[0],
'curr' =>$this->M_Base->u_get('currency'),
'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
'icon'  => $this->M_Base->u_get('web-icon'),
                'allProduct' => $getAllData,
                'allCategory' => $getCategory
            ]);
    
            return view('Admin/Product/list', $data);
        }
    }

    public function ProductAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/product');
            } else {
                $data_post = [
                    'name'     => $this->request->getPost('name'),
                    'category' => $this->request->getPost('category'),
                    'price'    => $this->request->getPost('price'),
                    'stock'    => $this->request->getPost('stock')
                ];

                $dataCategory = $this->M_Base->data_where('category', 'id', $data_post['category']);

                $dataInsert = [
                    'id_category' => $data_post['category'],
                    'slug'        => $dataCategory[0]['slug'],
                    'name'        => $data_post['name'],
                    'price'       => $data_post['price'],
                    'stock'       => $data_post['stock']
                ];

                if($this->M_Base->data_insert('product', $dataInsert)) {
                    $this->session->setFlashdata('success', 'Horee! Produk baru berhasil ditambahkan');
                    return redirect()->to('/admin/product');
                }
            }
        }
    }

    public function ProductEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/product');
            } else {
                $data_post = [
                    'id'       => $this->request->getPost('id'),
                    'name'     => $this->request->getPost('name'),
                    'category' => $this->request->getPost('category'),
                    'price'    => $this->request->getPost('price'),
                    'stock'    => $this->request->getPost('stock')
                ];

                $dataCategory = $this->M_Base->data_where('category', 'id', $data_post['category']);

                $dataUpdate = [
                    'id_category' => $data_post['category'],
                    'slug'        => $dataCategory[0]['slug'],
                    'name'        => $data_post['name'],
                    'price'       => $data_post['price'],
                    'stock'       => $data_post['stock']
                ];

                if($this->M_Base->data_update('product', $dataUpdate, $data_post['id'])) {
                    $this->session->setFlashdata('success', 'Horee! Produk berhasil diupdate');
                    return redirect()->to('/admin/product');
                }
            }
        }
    }

    public function ProductDelete($id) {
        $getData = $this->M_Base->data_where('product', 'id', $id);

        if (count($getData) === 0) {
            $this->session->setFlashdata('error', 'Gagal! Produk tidak ditemukan');
            return redirect()->to('/admin/product');
        } else {
            $this->M_Base->data_delete("product", $id);
            $this->session->setFlashdata('success', 'Horee! Produk berhasil dihapus');
            return redirect()->to('/admin/product');
        }
    }

    public function CategoryIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getCategory = [];
            foreach (array_reverse($this->M_Base->all_data('category', 'id')) as $data_loop) {
                $getCategory[] = [
                    'id'   => $data_loop['id'],
                    'name' => $data_loop['name'],
                    'slug' => $data_loop['slug'],
                    'icon' => $data_loop['icon'],
                    'status' => $data_loop['status']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Category',
                'uri_segment' => 'product',
                'users' => $data_email[0],
                'curr' => $this->M_Base->u_get('currency'),
                'web_name' => $this->M_Base->u_get('web-title'),
                'logo' => $this->M_Base->u_get('web-logo'),
                'icon' => $this->M_Base->u_get('web-icon'),
                'allCategory' => $getCategory
            ]);
    
            return view('Admin/Product/category', $data);
        }
    }

    function CategoryAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/auth');
            } else {
                $data_post = [
                    'name' => $this->request->getPost('name'),
                    'slug' => $this->request->getPost('slug'),
                    'icon' => $this->request->getPost('icon'),
                    'status' => $this->request->getPost('status')
                ];

                if($getTamp = $this->request->getFile('icon')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 
                    }
                }

                $newDir = "home/img/product/";

                if($getTamp->move($newDir, $newName)){
                    $dataInsert = [
                        'name' => $data_post['name'],
                        'slug' => $data_post['slug'],
                        'icon' => $newName,
                        'status' => $data_post['status']
                    ];

                    if($this->M_Base->data_insert('category', $dataInsert)) {
                        $this->session->setFlashdata('success', 'Horee! Kategori baru berhasil di buat');
                        return redirect()->to('/admin/product/category');
                    }
                }
            }
        }
    }

    function CategoryEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/auth');
            } else {
                $data_post = [
                    'id'   => $this->request->getPost('id'),
                    'name' => $this->request->getPost('name'),
                    'slug' => $this->request->getPost('slug'),
                    'status' => $this->request->getPost('status')
                ];

                if($getTamp = $this->request->getFile('icon')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 

                        $GetCategory = $this->M_Base->data_where('category', 'id', $data_post['id']);
                        $OldImage = "home/img/product/".$GetCategory[0]['icon'];

                        if(unlink($OldImage)) {
                            $newDir = "home/img/product/";
                            if($getTamp->move($newDir, $newName)){
                                $dataUpdate = [
                                    'name' => $data_post['name'],
                                    'slug' => $data_post['slug'],
                                    'icon' => $newName,
                                    'status' => $data_post['status']
                                ];
                            }
                        }
                    } else {
                        $dataUpdate = [
                            'name' => $data_post['name'],
                            'slug' => $data_post['slug'],
                            'status' => $data_post['status']
                        ];
                    }
                }

                if($this->M_Base->data_update('category', $dataUpdate, $data_post['id'])) {
                    $this->session->setFlashdata('success', 'Horee! Kategori berhasil diupdate');
                    return redirect()->to('/admin/product/category');
                }
            }
        }
    }

    public function CategoryDelete($id) {
        $getData = $this->M_Base->data_where('category', 'id', $id);

        if (count($getData) === 0) {
            $this->session->setFlashdata('error', 'Gagal! Kategori tidak ditemukan');
            return redirect()->to('/admin/product/category');
        } else {
            $OldImage = "home/img/product/".$getData[0]['icon'];

            if(unlink($OldImage)) {
                $this->M_Base->data_delete("category", $id);
                $this->session->setFlashdata('success', 'Horee! Kategori berhasil dihapus');
                return redirect()->to('/admin/product/category');
            }
            
        }
    }

    public function BankIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getBanks = [];
            foreach (array_reverse($this->M_Base->all_data('bank', 'id')) as $data_loop) {
                $getBanks[] = [
                    'id'   => $data_loop['id'],
                    'name' => $data_loop['name'],
                    'number' => $data_loop['number'],
                    'behalf' => $data_loop['behalf'],
                    'icon' => $data_loop['icon'],
                    'payment_code' => $data_loop['payment_code'],
                    'min' => $data_loop['minimum'],
                    'status' => $data_loop['status']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Bank Admin',
                'uri_segment' => 'bank',
                'users' => $data_email[0],
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'allBanks' => $getBanks
            ]);
    
            return view('Admin/bank', $data);
        }
    }

    function BankAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/auth');
            } else {
                $data_post = [
                    'name' => $this->request->getPost('name'),
                    'number' => $this->request->getPost('number'),
                    'behalf' => $this->request->getPost('behalf'),
                    'min'    => $this->request->getPost('min'),
                    'status' => $this->request->getPost('status')
                ];
                
                $newDir = "home/img/bank/";

                if($getTamp = $this->request->getFile('icon')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 
                    }
                }


                if($getTamp2 = $this->request->getFile('pay_code')) {
                    if ($getTamp2->isValid() && ! $getTamp2->hasMoved()) {
                        $newName2 = $getTamp2->getRandomName(); 
                        $getTamp2->move($newDir, $newName2);
                    } else {
                        $newName2 = NULL;
                    }
                } else {
                    $newName2 = NULL;
                }
                
                if($getTamp->move($newDir, $newName)){
                    $dataInsert = [
                        'name' => $data_post['name'],
                        'number' => $data_post['number'],
                        'behalf' => $data_post['behalf'],
                        'icon' => $newName,
                        'payment_code' => $newName2,
                        'minimum' => $data_post['min'],
                        'status' => $data_post['status']
                    ];

                    if($this->M_Base->data_insert('bank', $dataInsert)) {
                        $this->session->setFlashdata('success', 'Horee! Bank baru berhasil di buat');
                        return redirect()->to('/admin/bank');
                    }
                }
            }
        }
    }

    function BankEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/auth');
            } else {
                $data_post = [
                    'id'     => $this->request->getPost('id'),
                    'name'   => $this->request->getPost('name'),
                    'number' => $this->request->getPost('number'),
                    'behalf' => $this->request->getPost('behalf'),
                    'min'    => $this->request->getPost('min'),
                    'status' => $this->request->getPost('status')
                ];
                
                if($getTamp2 = $this->request->getFile('pay_code')) {
                    $GetCategory2 = $this->M_Base->data_where('bank', 'id', $data_post['id']);
                    $OldImage2 = "home/img/bank/".$GetCategory2[0]['payment_code'];
                        
                    if ($getTamp2->isValid() && ! $getTamp2->hasMoved()) {
                        $newName2 = $getTamp2->getRandomName(); 

                        if(unlink($OldImage2)) {
                            $newDir2 = "home/img/bank/";
                            $getTamp2->move($newDir2, $newName2);
                        }
                    } else {
                        $newName2 = $GetCategory2[0]['payment_code'];
                    }
                }

                if($getTamp = $this->request->getFile('icon')) {
                    $GetCategory = $this->M_Base->data_where('bank', 'id', $data_post['id']);
                    $OldImage = "home/img/bank/".$GetCategory[0]['icon'];
                        
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 

                        if(unlink($OldImage)) {
                            $newDir = "home/img/bank/";
                            $getTamp->move($newDir, $newName);
                        }
                    } else {
                        $newName = $GetCategory[0]['icon'];
                        // $dataUpdate = [
                        //     'name' => $data_post['name'],
                        //     'number' => $data_post['number'],
                        //     'behalf' => $data_post['behalf'],
                        //     'minimum' => $data_post['min'],
                        //     'status' => $data_post['status']
                        // ];
                    }
                }
                
                $dataUpdate = [
                    'name' => $data_post['name'],
                    'number' => $data_post['number'],
                    'behalf' => $data_post['behalf'],
                    'icon' => $newName,
                    'payment_code' => $newName2,
                    'minimum' => $data_post['min'],
                    'status' => $data_post['status']
                ];

                if($this->M_Base->data_update('bank', $dataUpdate, $data_post['id'])) {
                    $this->session->setFlashdata('success', 'Horee! Bank berhasil diupdate');
                    return redirect()->to('/admin/bank');
                }
            }
        }
    }

    public function BankDelete($id) {
        $getData = $this->M_Base->data_where('bank', 'id', $id);

        if (count($getData) === 0) {
            $this->session->setFlashdata('error', 'Gagal! Bank tidak ditemukan');
            return redirect()->to('/admin/bank');
        } else {
            $OldImage = "home/img/bank/".$getData[0]['icon'];

            if(unlink($OldImage)) {
                $this->M_Base->data_delete("bank", $id);
                $this->session->setFlashdata('success', 'Horee! Bank berhasil dihapus');
                return redirect()->to('/admin/bank');
            }
            
        }
    }

    public function DepositIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getAllData = [];
            foreach (array_reverse($this->M_Base->data_join('deposit', 'users', 'deposit.id, deposit.id_bank, deposit.total, deposit.uniq, deposit.bukti_pembayaran AS proof, deposit.note, deposit.status, deposit.created_at, deposit.updated_at, users.name, users.email, users.phone', 'deposit.id_user = users.id', 'created_at')) as $data_loop) {
                $getBanks = $this->M_Base->data_where('bank', 'id', $data_loop['id_bank']);
                if(count($getBanks) === 0) {
                    $BankName = "-";
                    $Number   = "-";
                    $Behalf   = "-";
                } else {
                    $BankName = $getBanks[0]['name'];
                    $Number   = $getBanks[0]['number'];
                    $Behalf   = $getBanks[0]['behalf'];
                }
                $getAllData[] = [
                    'id'     => $data_loop['id'],
                    'total' => $data_loop['total'],
                    'proof'   => $data_loop['proof'],
                    'note' => $data_loop['note'],
                    'status'  => $data_loop['status'],
                    'price' => $data_loop['total'],
                    'uniq' => $data_loop['uniq'],
                    'created_at'  => $data_loop['created_at'],
                    'updated_at' => $data_loop['updated_at'],
                    'fullname' => $data_loop['name'],
                    'email' => $data_loop['email'],
                    'phone' => $data_loop['phone'],
                    'bank'  => $BankName,
                    'number'  => $Number,
                    'behalf'  => $Behalf
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Deposit',
                'uri_segment' => 'deposit',
                'users' => $data_email[0],
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'allDeposits' => $getAllData
            ]);
    
            return view('Admin/deposit', $data);
        }
    }

    public function EditDeposit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $data_post = [
                'id'   => $this->request->getPost('id'),
                'status' => $this->request->getPost('status'),
                'note' => $this->request->getPost('note')
            ];

            $Deposits = $this->M_Base->data_where('deposit', 'id', $data_post['id']);

            if($Deposits[0]['status'] == "approved") {
                $this->session->setFlashdata('success', 'Horee! Deposit berhasil diupdate');
                return redirect()->to('/admin/deposit');
            } else {
                if (count($Deposits) === 0) {
                    $this->session->setFlashdata('error', 'Gagal! Invoice tidak ditemukan');
                    return redirect()->to('/admin/deposit');
                } else {
                    $dataUpdate = [
                        'status' => $data_post['status'],
                        'note'   => $data_post['note']
                    ];
        
                    if($data_post['status'] == "approved") {
                        
                        if($Deposits[0]['bonus'] == null || $Deposits[0]['bonus'] == 0) {
                            $Bonus = 0;
                        } else {
                            $Bonus = $Deposits[0]['bonus'];
                        }
                        
                        $GetUsers = $this->M_Base->data_where('users', 'id', $Deposits[0]['id_user']);
    
                        $NewSaldo = $GetUsers[0]['balance'] + $Deposits[0]['total'] + $Bonus;
    
                        $UsersUpdated = ['balance' => $NewSaldo];
                        $this->M_Base->data_update('users', $UsersUpdated, $Deposits[0]['id_user']);
                    }
        
                    if($this->M_Base->data_update('deposit', $dataUpdate, $data_post['id'])) {
                        $this->session->setFlashdata('success', 'Horee! Deposit berhasil diupdate');
                        return redirect()->to('/admin/deposit');
                    }
                }
            }
        }
    }

    public function TransactionIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getAllData = [];
            foreach (array_reverse($this->M_Base->data_join('transaction', 'users', 'transaction.id, transaction.name, transaction.phone AS target, transaction.product, transaction.price, transaction.fee, transaction.total, transaction.metode, transaction.status, transaction.created_at, users.id AS id_user, users.email, users.phone', 'transaction.user_id = users.id', 'transaction.created_at')) as $data_loop) {
                $getAllData[] = [
                    'id'     => $data_loop['id'],
                    'name' => $data_loop['name'],
                    'target'   => $data_loop['target'],
                    'product' => $data_loop['product'],
                    'price' => $data_loop['price'],
                    'fee'  => $data_loop['fee'],
                    'total'  => $data_loop['total'],
                    'metode' => $data_loop['metode'],
                    'status' => $data_loop['status'],
                    'email' => $data_loop['email'],
                    'phone' => $data_loop['phone'],
                    'date' => $data_loop['created_at']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Transaksi',
                'uri_segment' => 'transaction',
                'users' => $data_email[0],
'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'Transactions' => $getAllData
            ]);
    
            return view('Admin/transaction', $data);
        }
    }
    
    public function TransactionUpdate() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $data_post = [
                'id'   => $this->request->getPost('id'),
                'status' => $this->request->getPost('status')
            ];

            $Transaction = $this->M_Base->data_where('transaction', 'id', $data_post['id']);

            if($Transaction[0]['status'] == "Completed") {
                $this->session->setFlashdata('success', 'Horee! Deposit berhasil diupdate');
                return redirect()->to('/admin/transaction');
            } else {
                if (count($Transaction) === 0) {
                    $this->session->setFlashdata('error', 'Gagal! Invoice tidak ditemukan');
                    return redirect()->to('/admin/transaction');
                } else {
                    $dataUpdate = [
                        'status' => $data_post['status']
                    ];
        
                    if($data_post['status'] == "Completed") {
                        
                        $GetUsers = $this->M_Base->data_where('users', 'id', $Transaction[0]['user_id']); 
                        $GetProduct = $this->M_Base->data_where('product', 'id', $Transaction[0]['product_id']); 
                        
                        $UpdateBalance = [
                            'balance' => $GetUsers[0]['balance'] - $Transaction[0]['total']
                        ];

                        $UpdateStock = [
                            'stock' => $GetProduct[0]['stock'] - 1
                        ];
    
                        $this->M_Base->data_update('users', $UpdateBalance, $GetUsers[0]['id']);
                        $this->M_Base->data_update('product', $UpdateStock, $GetProduct[0]['id']);
                    }
        
                    if($this->M_Base->data_update('transaction', $dataUpdate, $data_post['id'])) {
                        $this->session->setFlashdata('success', 'Horee! Transaksi berhasil diupdate');
                        return redirect()->to('/admin/transaction');
                    }
                }
            }
        }
    }
    
    public function NotificationIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getAllData = [];
            foreach (array_reverse($this->M_Base->all_data('notification', 'id')) as $data_loop) {
                $getAllData[] = [
                    'id'   => $data_loop['id'],
                    'notify' => $data_loop['notify']
                ];
            }

            $data = array_merge($this->base_data, [
                'title' => 'List Notifikasi',
                'uri_segment' => 'notification',
                'users' => $data_email[0],
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'Notify' => $getAllData
            ]);
    
            return view('Admin/notification', $data);
        }
    }

    public function SettingsIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            // Cek apakah pengaturan fee-withdrawal sudah ada
            $query = $this->db->table('utility')->where('u_key', 'fee-withdrawal')->get();
            
            if ($query->getNumRows() === 0) {
                // Jika belum ada, tambahkan dengan nilai default 2.5%
                $data = [
                    'u_key' => 'fee-withdrawal',
                    'u_value' => '2.5'
                ];
                
                $this->db->table('utility')->insert($data);
            }

            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);
            
            $GetBanner = explode(",", $this->M_Base->u_get('slide'));
            $GetBanner2 = explode(",", $this->M_Base->u_get('slide2'));

            $data = array_merge($this->base_data, [
                'title' => 'Pengaturan',
                'uri_segment' => 'settings',
                'users' => $data_email[0],
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'web_title' => $this->M_Base->u_get('web-title'),
                'web_description' => $this->M_Base->u_get('web-description'),
                'web_keywords' => $this->M_Base->u_get('web-keywords'),
                'web_author' => $this->M_Base->u_get('web-author'),
                'web_logo' => $this->M_Base->u_get('web-logo'),
                'web_icon' => $this->M_Base->u_get('web-icon'),
                    'email' => $this->M_Base->u_get('email'),
                    'phone' => $this->M_Base->u_get('phone'),
                'pay_saldo' => $this->M_Base->u_get('pay-saldo'),
                'fee' => $this->M_Base->u_get('fee'),
                    'currency' => $this->M_Base->u_get('currency'),
                'bonus_deposit' => $this->M_Base->u_get('bonus-deposit'),
                'fee_withdrawal' => $this->M_Base->u_get('fee-withdrawal'),
                'slide' => $GetBanner,
                'slide2' => $GetBanner2,
                    'chat_id' => $this->M_Base->u_get('chat_id'),
                    'bot_token' => $this->M_Base->u_get('bot_token')
            ]);
    
            return view('Admin/settings', $data);
        }
    }

    public function SettingsUpdate() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] === 'Admin') {
                // Ambil section yang sedang diupdate
                $section = $this->request->getPost('section');
                
                // Inisialisasi array data yang akan diupdate
                $data_post = [];
                
                // Proses berdasarkan section
                if ($section === 'umum') {
                $data_post = [
                        'web-title' => $this->request->getPost('web-title'),
                        'web-description' => $this->request->getPost('web-description'),
                        'web-keywords' => $this->request->getPost('web-keywords'),
                        'web-author' => $this->request->getPost('web-author'),
                    ];
                    
                    // Proses upload logo jika ada
                    $logo = $this->request->getFile('web-logo');
                    if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                        $newName = $logo->getRandomName();
                        $logo->move(ROOTPATH . 'public/home/img/', $newName);
                        $data_post['web-logo'] = $newName;
                    }
                    
                    // Proses upload icon jika ada
                    $icon = $this->request->getFile('web-icon');
                    if ($icon && $icon->isValid() && !$icon->hasMoved()) {
                        $newName = $icon->getRandomName();
                        $icon->move(ROOTPATH . 'public/home/img/', $newName);
                        $data_post['web-icon'] = $newName;
                    }
                } elseif ($section === 'banner') {
                    // Proses upload banner jika ada
                    $banners = $this->request->getFiles('banner');
                    if ($banners) {
                        $banner_names = [];
                        foreach ($banners['banner'] as $banner) {
                            if ($banner->isValid() && !$banner->hasMoved()) {
                                $newName = $banner->getRandomName();
                                $banner->move(ROOTPATH . 'public/home/img/banner/', $newName);
                                $banner_names[] = $newName;
                            }
                        }
                        
                        if (!empty($banner_names)) {
                            $data_post['slide'] = implode(',', $banner_names);
                        }
                    }
                } elseif ($section === 'banner2') {
                    // Proses upload banner2 jika ada
                    $banners2 = $this->request->getFiles('banner2');
                    if ($banners2) {
                        $banner_names2 = [];
                        foreach ($banners2['banner2'] as $banner2) {
                            if ($banner2->isValid() && !$banner2->hasMoved()) {
                                $newName = $banner2->getRandomName();
                                $banner2->move(ROOTPATH . 'public/home/img/banner/', $newName);
                                $banner_names2[] = $newName;
                            }
                        }
                        
                        if (!empty($banner_names2)) {
                            $data_post['slide2'] = implode(',', $banner_names2);
                        }
                    }
                } elseif ($section === 'other') {
                $data_post = [
                        'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                        'bonus-deposit' => $this->request->getPost('bonus-deposit'),
                    'fee' => $this->request->getPost('fee'),
                    'currency' => $this->request->getPost('currency'),
                        'fee-withdrawal' => $this->request->getPost('fee-withdrawal'),
                    'chat_id' => $this->request->getPost('chat_id'),
                        'bot_token' => $this->request->getPost('bot_token'),
                    ];
                }

                // Update data ke database
                foreach ($data_post as $key => $value) {
                    if ($value !== null) {
                        $this->M_Base->u_update($key, $value);
                    }
                }

                $this->session->setFlashdata('success', 'Pengaturan berhasil disimpan');
                    return redirect()->to('/admin/settings');
                            } else {
                $this->session->setFlashdata('error', 'Hak akses tidak mencukupi');
                    return redirect()->to('/admin/settings');
                }
        }
    }
    
    public function changePassword() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            if(empty($this->request->getVar('csrf_test_name'))) {
                $this->session->setFlashdata('errors', 'Error, hubungi customer service');
                return redirect()->to('/admin/settings');
            } else {
                $data_post = [
                    'old_password' => $this->request->getPost('old_password'),
                    'new_password' => $this->request->getPost('new_password'),
                    'confirm_password' => $this->request->getPost('confirm_password')
                ];

                $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

                if (count($data_email) === 1) {
                    if (password_verify($data_post['old_password'], $data_email[0]['password'])) {
                        if ($data_post['new_password'] === $data_post['confirm_password']) {
                            $dataUpdate = [
                                'password' => password_hash($data_post['new_password'], PASSWORD_BCRYPT)
                            ];
                            $this->M_Base->data_update('users', $dataUpdate, $data_email[0]['id']);
                            $this->session->setFlashdata('success', 'Password berhasil diubah');
                        } else {
                            $this->session->setFlashdata('errors', 'Password baru dan konfirmasi tidak cocok');
                        }
                    } else {
                        $this->session->setFlashdata('errors', 'Password lama salah');
                    }
                } else {
                    $this->session->setFlashdata('errors', 'Akun tidak ditemukan');
                }
                return redirect()->to('/admin/settings');
            }
        }
    }

    public function AdminLogout() {
        session_destroy();
        return redirect()->to('/admin');
    }

    public function DepositAmountIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $getAllDepositAmount = [];
            foreach (array_reverse($this->M_Base->all_data('deposit_amount')) as $data_loop) {
                $getAllDepositAmount[] = [
                    'id'     => $data_loop['id'],
                    'amount' => $data_loop['amount'],
                    'status' => $data_loop['status'],
                ];
            }
            
            $data = array_merge($this->base_data, [
                'title' => 'Nominal Deposit',
                'uri_segment' => 'deposit_amount',
                'users' => $data_email[0],
                'curr' => $this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'deposit_amount' => $getAllDepositAmount,
            ]);

            return view('Admin/deposit_amount', $data);
        }
    }

    public function DepositAmountAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] === 'Admin') {
                $amount = $this->request->getPost('amount');
                $status = $this->request->getPost('status');
                
                if (empty($amount) || $amount <= 0) {
                    $this->session->setFlashdata('errors', 'Nominal tidak valid');
                    return redirect()->to('/admin/deposit/amount');
                }
                
                $data = [
                    'amount' => $amount,
                    'status' => $status
                ];
                
                if ($this->M_Base->data_insert('deposit_amount', $data)) {
                    $this->session->setFlashdata('success', 'Nominal deposit berhasil ditambahkan');
                } else {
                    $this->session->setFlashdata('errors', 'Gagal menambahkan nominal deposit');
                }
                
                    return redirect()->to('/admin/deposit/amount');
                } else {
                $this->session->setFlashdata('errors', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/deposit/amount');
            }
        }
    }

    public function DepositAmountEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        }

        $id = $this->request->getPost('id');
        $amount = $this->request->getPost('amount');
        $status = $this->request->getPost('status');

        if(empty($amount) || $amount <= 0) {
            $this->session->setFlashdata('errors', 'Nominal tidak valid');
                    return redirect()->to('/admin/deposit/amount');
                }

        $update = $this->M_Base->data_update('deposit_amount', [
            'amount' => $amount,
            'status' => $status,
        ], $id);

        if($update) {
            $this->session->setFlashdata('success', 'Nominal deposit berhasil diubah');
            } else {
            $this->session->setFlashdata('errors', 'Nominal deposit gagal diubah');
        }

                return redirect()->to('/admin/deposit/amount');
            }

    public function DepositAmountDelete($id) {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] !== 'Admin') {
                $this->session->setFlashdata('errors', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/deposit/amount');
            }

            if ($this->M_Base->data_delete('deposit_amount', $id)) {
                $this->session->setFlashdata('success', 'Nominal deposit berhasil dihapus');
                return redirect()->to('/admin/deposit/amount');
            } else {
                $this->session->setFlashdata('errors', 'Nominal deposit gagal dihapus');
                return redirect()->to('/admin/deposit/amount');
            }
        }
    }

    public function WithdrawalIndex() {
        // Cek apakah user sudah login
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        }
        
        // Ambil data user
        $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);
        
        // Ambil semua data withdrawal
        $all_withdrawals = $this->M_Base->all_data('withdrawal');
        
        // Siapkan array untuk menyimpan data withdrawal yang sudah diproses
        $processed_withdrawals = [];
        
        // Hitung jumlah penarikan pending
        $pending_count = 0;
        
        // Proses setiap data withdrawal
        foreach (array_reverse($all_withdrawals) as $w) {
            // Ambil data user dan bank
            $user = $this->M_Base->data_where('users', 'id', $w['id_user']);
            $bank = $this->M_Base->data_where('bank_withdrawal', 'id', $w['id_bank']);
            
            // Set nilai default jika data tidak ditemukan
            $user_name = count($user) > 0 ? $user[0]['name'] : '-';
            $user_phone = count($user) > 0 ? $user[0]['phone'] : '-';
            $bank_name = count($bank) > 0 ? $bank[0]['name'] : '-';
            
            // Buat array data withdrawal
            $withdrawal_data = [
                'id' => $w['id'],
                'user_name' => $user_name,
                'user_phone' => $user_phone,
                'bank_name' => $bank_name,
                'bank_account' => $w['bank_account'],
                'account_name' => $w['account_name'],
                'total' => $w['total'],
                'fee' => $w['fee'],
                'status' => $w['status'],
                'note' => $w['note'],
                'date' => $w['created_at']
            ];
            
            // Tambahkan ke array processed_withdrawals
            $processed_withdrawals[] = $withdrawal_data;
            
            // Hitung jumlah penarikan pending
            if ($w['status'] == 'pending') {
                $pending_count++;
            }
        }
        
        // Siapkan data untuk view
        $data = [
            'title' => 'Penarikan Saldo',
            'uri_segment' => 'withdrawal',
            'users' => $data_email[0],
            'curr' => $this->M_Base->u_get('currency'),
            'web_name' => $this->M_Base->u_get('web-title'),
            'logo' => $this->M_Base->u_get('web-logo'),
            'icon' => $this->M_Base->u_get('web-icon'),
            'allWithdrawals' => $processed_withdrawals,
            'pending_withdrawals' => $pending_count,
            'debug_withdrawal' => $all_withdrawals
        ];
        
        // Gabungkan dengan base_data
        $data = array_merge($this->base_data, $data);
        
        // Tampilkan view
        return view('Admin/withdrawal', $data);
    }

    public function EditWithdrawal() {
        // Cek apakah user sudah login
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        }
        
        // Ambil data user
        $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);
        
        // Cek apakah user adalah admin
        if ($data_email[0]['level'] !== 'Admin') {
            $this->session->setFlashdata('errors', 'Hak akses tidak mencukupi');
            return redirect()->to('/admin/withdrawal');
        }
        
        // Ambil data dari form
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $note = $this->request->getPost('note');
        
        // Cek apakah withdrawal ada
        $withdrawal = $this->M_Base->data_where('withdrawal', 'id', $id);
        if (count($withdrawal) === 0) {
            $this->session->setFlashdata('errors', 'Gagal! Penarikan tidak ditemukan');
            return redirect()->to('/admin/withdrawal');
        }
        
        // Jika status berubah dari pending ke declined, kembalikan saldo
        if ($withdrawal[0]['status'] === 'pending' && $status === 'declined') {
            $user = $this->M_Base->data_where('users', 'id', $withdrawal[0]['id_user']);
            if (count($user) > 0) {
                $total_refund = $withdrawal[0]['total'] + $withdrawal[0]['fee'];
                $new_balance = $user[0]['balance'] + $total_refund;
                $this->M_Base->data_update('users', ['balance' => $new_balance], $user[0]['id']);
            }
        }
        
        // Update status withdrawal
        $this->M_Base->data_update('withdrawal', [
            'status' => $status,
            'note' => $note
        ], $id);
        
        // Kirim notifikasi ke admin via Telegram
        $user = $this->M_Base->data_where('users', 'id', $withdrawal[0]['id_user']);
        $bank = $this->M_Base->data_where('bank_withdrawal', 'id', $withdrawal[0]['id_bank']);
        $bank_name = count($bank) > 0 ? $bank[0]['name'] : '-';
        $user_name = count($user) > 0 ? $user[0]['name'] : '-';
        $user_phone = count($user) > 0 ? $user[0]['phone'] : '-';
        
        $nominal = $withdrawal[0]['total'] + $withdrawal[0]['fee'];
        $fee = $withdrawal[0]['fee'];
        $total = $withdrawal[0]['total'];
        $currency = $this->M_Base->u_get('currency');
        
        $message = '--[ Update Status Penarikan Saldo ]--' . PHP_EOL . PHP_EOL;
        $message .= '- Invoice: #' . $id . PHP_EOL;
        $message .= '- Nama: ' . $user_name . PHP_EOL;
        $message .= '- No.HP/WA: ' . $user_phone . PHP_EOL;
        $message .= '- Bank: ' . $bank_name . PHP_EOL;
        $message .= '- No. Rekening: ' . $withdrawal[0]['bank_account'] . PHP_EOL;
        $message .= '- Nama Pemilik: ' . $withdrawal[0]['account_name'] . PHP_EOL;
        $message .= '- Nominal: ' . $currency . ' ' . number_format($nominal, 0, ',', '.') . PHP_EOL;
        $message .= '- Biaya Admin: ' . $currency . ' ' . number_format($fee, 0, ',', '.') . PHP_EOL;
        $message .= '- Total Diterima: ' . $currency . ' ' . number_format($total, 0, ',', '.') . PHP_EOL;
        $message .= '- Tanggal: ' . $this->M_Base->tanggal_indo(date('Y-m-d')) . PHP_EOL;
        $message .= '- Status: ' . ucfirst($status) . PHP_EOL;
        if (!empty($note)) {
            $message .= '- Catatan: ' . $note . PHP_EOL;
        }
        $message .= PHP_EOL . 'By ' . $this->M_Base->u_get('web-title');
        
        $this->TelegramMsg($message);
        
        // Set flashdata dan redirect
        $this->session->setFlashdata('success', 'Horee! Penarikan berhasil diupdate');
        return redirect()->to('/admin/withdrawal');
    }
    
    public function WithdrawalAmountIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $data = array_merge($this->base_data, [
                'title' => 'Nominal Penarikan',
                'uri_segment' => 'withdrawal_amount',
                'users' => $data_email[0],
                'curr' => $this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'withdrawal_amount' => $this->M_Base->all_data('withdrawal_amount')
            ]);
    
            return view('Admin/withdrawal_amount', $data);
        }
    }
    
    public function WithdrawalAmountAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] === 'Admin') {
                $amount = $this->request->getPost('amount');
                $status = $this->request->getPost('status');
                
                if (empty($amount) || $amount <= 0) {
                    $this->session->setFlashdata('errors', 'Nominal tidak valid');
                    return redirect()->to('/admin/withdrawal/amount');
                }
                
                $data = [
                    'amount' => $amount,
                    'status' => $status
                ];
                
                if ($this->M_Base->data_insert('withdrawal_amount', $data)) {
                    $this->session->setFlashdata('success', 'Nominal penarikan berhasil ditambahkan');
                } else {
                    $this->session->setFlashdata('errors', 'Gagal menambahkan nominal penarikan');
                }
                
                return redirect()->to('/admin/withdrawal/amount');
            } else {
                $this->session->setFlashdata('errors', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/withdrawal/amount');
            }
        }
    }
    
    public function WithdrawalAmountEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        }

        $id = $this->request->getPost('id');
        $amount = $this->request->getPost('amount');
        $status = $this->request->getPost('status');

        if(empty($amount) || $amount <= 0) {
            $this->session->setFlashdata('errors', 'Nominal tidak valid');
            return redirect()->to('/admin/withdrawal/amount');
        }

        $update = $this->M_Base->data_update('withdrawal_amount', [
            'amount' => $amount,
            'status' => $status,
        ], $id);

        if($update) {
            $this->session->setFlashdata('success', 'Nominal penarikan berhasil diubah');
            } else {
            $this->session->setFlashdata('errors', 'Nominal penarikan gagal diubah');
        }

        return redirect()->to('/admin/withdrawal/amount');
    }
    
    public function WithdrawalAmountDelete($id) {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] !== 'Admin') {
                $this->session->setFlashdata('errors', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/withdrawal/amount');
            }

            if ($this->M_Base->data_delete('withdrawal_amount', $id)) {
                $this->session->setFlashdata('success', 'Nominal penarikan berhasil dihapus');
                return redirect()->to('/admin/withdrawal/amount');
            } else {
                $this->session->setFlashdata('errors', 'Nominal penarikan gagal dihapus');
                return redirect()->to('/admin/withdrawal/amount');
            }
        }
    }

    public function AddFeeWithdrawal() {
        // Cek apakah pengaturan fee-withdrawal sudah ada
        $query = $this->db->table('utility')->where('u_key', 'fee-withdrawal')->get();
        
        if ($query->getNumRows() === 0) {
            // Jika belum ada, tambahkan dengan nilai default 2.5%
            $data = [
                'u_key' => 'fee-withdrawal',
                'u_value' => '2.5'
            ];
            
            $this->db->table('utility')->insert($data);
            echo "Nilai fee-withdrawal berhasil ditambahkan";
        } else {
            echo "Nilai fee-withdrawal sudah ada";
        }
    }

    public function BankWithdrawalIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            $data = array_merge($this->base_data, [
                'title' => 'Bank Penarikan',
                'uri_segment' => 'bank_withdrawal',
                'users' => $data_email[0],
                'curr' => $this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'bank' => $this->M_Base->all_data('bank_withdrawal'),
            ]);
    
            return view('Admin/bank_withdrawal', $data);
        }
    }
    
    function BankWithdrawalAdd() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] !== 'Admin') {
                $this->session->setFlashdata('error', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/bank/withdrawal');
            }

            $name = $this->request->getPost('name');
            $code = $this->request->getPost('code');
            $status = $this->request->getPost('status');

            $icon = $this->request->getFile('icon');

            if ($icon->isValid() && !$icon->hasMoved()) {
                $newName = $icon->getRandomName();
                $icon->move('./home/img/bank/', $newName);
                $iconName = $newName;
            } else {
                $iconName = 'bank.jpg';
            }

            $data = [
                'name' => $name,
                'code' => $code,
                'icon' => $iconName,
                'status' => $status,
            ];

            if ($this->M_Base->data_insert('bank_withdrawal', $data)) {
                $this->session->setFlashdata('success', 'Bank penarikan berhasil ditambahkan');
                return redirect()->to('/admin/bank/withdrawal');
            } else {
                $this->session->setFlashdata('error', 'Bank penarikan gagal ditambahkan');
                return redirect()->to('/admin/bank/withdrawal');
            }
        }
    }
    
    function BankWithdrawalEdit() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] !== 'Admin') {
                $this->session->setFlashdata('error', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/bank/withdrawal');
            }

            $id = $this->request->getPost('id');
            $name = $this->request->getPost('name');
            $code = $this->request->getPost('code');
            $status = $this->request->getPost('status');

            $icon = $this->request->getFile('icon');

            if ($icon->isValid() && !$icon->hasMoved()) {
                $newName = $icon->getRandomName();
                $icon->move('./home/img/bank/', $newName);
                $iconName = $newName;

                $data = [
                    'name' => $name,
                    'code' => $code,
                    'icon' => $iconName,
                    'status' => $status,
                ];
            } else {
                $data = [
                    'name' => $name,
                    'code' => $code,
                    'status' => $status,
                ];
            }

            if ($this->M_Base->data_update('bank_withdrawal', $data, $id)) {
                $this->session->setFlashdata('success', 'Bank penarikan berhasil diperbarui');
                return redirect()->to('/admin/bank/withdrawal');
            } else {
                $this->session->setFlashdata('error', 'Bank penarikan gagal diperbarui');
                return redirect()->to('/admin/bank/withdrawal');
            }
        }
    }
    
    public function BankWithdrawalDelete($id) {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);

            if ($data_email[0]['level'] !== 'Admin') {
                $this->session->setFlashdata('error', 'Hak akses tidak mencukupi');
                return redirect()->to('/admin/bank/withdrawal');
            }

            if ($this->M_Base->data_delete('bank_withdrawal', $id)) {
                $this->session->setFlashdata('success', 'Bank penarikan berhasil dihapus');
                return redirect()->to('/admin/bank/withdrawal');
            } else {
                $this->session->setFlashdata('error', 'Bank penarikan gagal dihapus');
                return redirect()->to('/admin/bank/withdrawal');
            }
        }
    }
}