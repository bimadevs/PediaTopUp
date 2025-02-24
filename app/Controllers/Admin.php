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
                    'order'   => $this->M_Base->data_count('transaction')
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
                    if ($data_email[0]['status'] === 'On') {
                        if ($data_email[0]['level'] === "Admin") {
                            if (password_verify($data_post['password'], $data_email[0]['password'])) {
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
                        $this->session->setFlashdata('auth_error', 'Akun kamu tidak aktif, hubungi Customer Service');
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
            foreach (array_reverse($this->M_Base->data_where('users', 'level', 'Member')) as $data_loop) {
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
            foreach (array_reverse($this->M_Base->data_join('product', 'category', 'category.id AS idcat, category.slug, category.name AS catname, product.id, product.name, product.price, product.stock, product.status', 'category.id = product.id_category', 'product.price')) as $data_loop) {
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
'curr' =>$this->M_Base->u_get('currency'),
'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
'icon'  => $this->M_Base->u_get('web-icon'),
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
                    'icon' => $this->request->getPost('icon'),
                    'status' => $this->request->getPost('status')
                ];

                if($getTamp = $this->request->getFile('icon')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 
                    }
                }

                $newDir = "home/img/bank/";

                if($getTamp->move($newDir, $newName)){
                    $dataInsert = [
                        'name' => $data_post['name'],
                        'number' => $data_post['number'],
                        'behalf' => $data_post['behalf'],
                        'icon' => $newName,
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

                if($getTamp = $this->request->getFile('icon')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 

                        $GetCategory = $this->M_Base->data_where('bank', 'id', $data_post['id']);
                        $OldImage = "home/img/bank/".$GetCategory[0]['icon'];

                        if(unlink($OldImage)) {
                            $newDir = "home/img/bank/";
                            if($getTamp->move($newDir, $newName)){
                                $dataUpdate = [
                                    'name' => $data_post['name'],
                                    'number' => $data_post['number'],
                                    'behalf' => $data_post['behalf'],
                                    'icon' => $newName,
                                    'minimum' => $data_post['min'],
                                    'status' => $data_post['status']
                                ];
                            }
                        }
                    } else {
                        $dataUpdate = [
                            'name' => $data_post['name'],
                            'number' => $data_post['number'],
                            'behalf' => $data_post['behalf'],
                            'minimum' => $data_post['min'],
                            'status' => $data_post['status']
                        ];
                    }
                }

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
            foreach (array_reverse($this->M_Base->data_join('users', 'deposit', 'deposit.id, deposit.id_bank, deposit.total, deposit.uniq, deposit.bukti_pembayaran AS proof, deposit.note, deposit.status, deposit.created_at, deposit.updated_at, users.name, users.email, users.phone', 'users.id = deposit.id_user')) as $data_loop) {
                $getBanks = $this->M_Base->data_where('bank', 'id', $data_loop['id_bank']);
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
                    'bank'  => $getBanks[0]['name'],
                    'number'  => $getBanks[0]['number'],
                    'behalf'  => $getBanks[0]['behalf'],
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
                        $GetUsers = $this->M_Base->data_where('users', 'id', $Deposits[0]['id_user']);
    
                        $NewSaldo = $GetUsers[0]['balance'] + $Deposits[0]['total'];
    
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
            foreach (array_reverse($this->M_Base->data_join('users', 'transaction', 'transaction.id, transaction.name, transaction.phone AS target, transaction.product, transaction.price, transaction.fee, transaction.total, transaction.metode, transaction.status, transaction.created_at, users.id AS id_user, users.email, users.phone', 'users.id = transaction.user_id')) as $data_loop) {
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

    public function SettingsIndex() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {

            $data_email = $this->M_Base->data_where('users', 'email', $_SESSION['email']);
            
            $GetBanner = explode(",", $this->M_Base->u_get('slide'));

            $data = array_merge($this->base_data, [
                'title' => 'Settings',
                'uri_segment' => 'settings',
                'users' => $data_email[0],
                'curr' =>$this->M_Base->u_get('currency'),
                'web_name'  => $this->M_Base->u_get('web-title'),
                'logo'  => $this->M_Base->u_get('web-logo'),
                'icon'  => $this->M_Base->u_get('web-icon'),
                'seo' => [
                    'title' => $this->M_Base->u_get('web-title'),
                    'icon' => $this->M_Base->u_get('web-icon'),
                    'logo' => $this->M_Base->u_get('web-logo'),
                    'desc' => $this->M_Base->u_get('web-description'),
                    'author' => $this->M_Base->u_get('web-author'),
                    'keyword' => $this->M_Base->u_get('web-keywords')
                ],
                'other' => [
                    'email' => $this->M_Base->u_get('email'),
                    'phone' => $this->M_Base->u_get('phone'),
                    'fee'   => $this->M_Base->u_get('fee'),
                    'currency' => $this->M_Base->u_get('currency'),
                    'bonus' => $this->M_Base->u_get('bonus-deposit')
                ],
                'slide' => $GetBanner,
            ]);
    
            return view('Admin/settings', $data);
        }
    }

    public function SettingsUpdate() {
        if(!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            return redirect()->to('/admin/auth');
        } else {
            $Section = $this->request->getPost('section');
            if($Section == "umum") {
                $data_post = [
                    'title'   => $this->request->getPost('web-title'),
                    'author' => $this->request->getPost('web-author'),
                    'desc' => $this->request->getPost('web-description'),
                    'keyword' => $this->request->getPost('web-keyword')
                ];

                if($getTamp = $this->request->getFile('web-logo')) {
                    if ($getTamp->isValid() && ! $getTamp->hasMoved()) {
                        $newName = $getTamp->getRandomName(); 
                        $OldImage = "home/img/".$this->M_Base->u_get('web-logo');

                        if(unlink($OldImage)) {
                            $newDir = "home/img/";
                            if($getTamp->move($newDir, $newName)){
                                $this->M_Base->u_update('web-logo', $newName);
                            }
                        }
                    }
                }

                if($getTamp2 = $this->request->getFile('web-icon')) {
                    if ($getTamp2->isValid() && ! $getTamp2->hasMoved()) {
                        $newName2 = $getTamp2->getRandomName(); 
                        $OldImage2 = "home/img/".$this->M_Base->u_get('web-icon');

                        if(unlink($OldImage2)) {
                            $newDir2 = "home/img/";
                            if($getTamp2->move($newDir2, $newName2)){
                                $this->M_Base->u_update('web-icon', $newName2);
                            }
                        }
                    }
                }

                $this->M_Base->u_update('web-title', $data_post['title']);
                $this->M_Base->u_update('web-author', $data_post['author']);
                $this->M_Base->u_update('web-keywords', $data_post['keyword']);
                $this->M_Base->u_update('web-description', $data_post['desc']);

                $this->session->setFlashdata('success', 'Horee! Pengaturan website berhasil diupdate');
                return redirect()->to('/admin/settings');
            } elseif($Section == "other") {
                $data_post = [
                    'email'   => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'fee' => $this->request->getPost('fee'),
                    'currency' => $this->request->getPost('currency'),
                    'bonus' => $this->request->getPost('bonus')
                ];

                $this->M_Base->u_update('email', $data_post['email']);
                $this->M_Base->u_update('phone', $data_post['phone']);
                $this->M_Base->u_update('fee', $data_post['fee']);
                $this->M_Base->u_update('currency', $data_post['currency']);
                $this->M_Base->u_update('bonus-deposit', $data_post['bonus']);

                $this->session->setFlashdata('success', 'Horee! Pengaturan website berhasil diupdate');
                return redirect()->to('/admin/settings');
            } elseif($Section == "banner") {
                if($this->request->getFileMultiple('banner')) {
                    $files = $this->request->getFileMultiple('banner');
                    $last_key = count($files);

                    $OldBanner = explode(",", $this->M_Base->u_get('slide'));

                    foreach ($OldBanner as $ob) {
                        unlink("home/img/banner/".$ob);
                    }

                    $imageFiles = "";

                    foreach ($files as $key => $file) {
                        if ($file->isValid() && ! $file->hasMoved())
                        {
                            if (++$key === $last_key) { 
                                $Comma = "";
                            } else {
                                $Comma = ",";
                            }

                            $newNames = $file->getRandomName();
                            $imageFiles .= $newNames . $Comma;

                            $file->move('home/img/banner/', $newNames);
                        }
                    }

                    $this->M_Base->u_update('slide', $imageFiles);
                    $this->session->setFlashdata('success', 'Horee! Pengaturan website berhasil diupdate');
                    return redirect()->to('/admin/settings');
                }
            }

            
        }
    }

    public function AdminLogout() {
        session_destroy();
        return redirect()->to('/admin');
    }
}