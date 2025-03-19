<?php
    class AdminTaiKhoanController{
        public $modelTaiKhoan;
        public $modelDonHang;
        public $modelSanPham;
        public function __construct()
        {
            $this->modelTaiKhoan = new AdminTaiKhoan();
            $this->modelDonHang = new AdminDonHang();
            $this->modelSanPham = new AdminSanPham();
        }

        public function danhSachQuanTri(){
            $listQuanTri = $this -> modelTaiKhoan->getAllTaiKhoan(1);
            require_once './views/taikhoan/quantri/listQuanTri.php';
        }

        public function formAddQuanTri(){
            require_once './views/taikhoan/quantri/addQuanTri.php';
            deleteSessionError();
        }

        public function postAddQuanTri(){
            //hàm này dùng để xử lý thêm dữ liệu
            
            //Kiểm tra xem dữ liệu có phải đc submit lên k
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ho_ten = $_POST['ho_ten'];
                $email = $_POST['email'];
                //Tạo 1 mảng trống để chữa
                $errors = [];
                if (empty($ho_ten)) {
                    $errors['ho_ten'] = 'Họ tên không được để trống';
                }
                if (empty($email)) {
                    $errors['email'] = 'Email không được để trống';
                }

                $_SESSION['error'] = $errors;
                //nếu k có lỗi thì tiến hành hành thêm tài khoản
                if (empty($errors)) {
                    //nếu k có lỗi thì tiến hành hành thêm tài khoản
                    //Đặt password mặt định
                    $password = password_hash('123@123ab', PASSWORD_BCRYPT); //password_hash dùng để mã hóa
                    //khai báo chức vụ
                    
                    $chuc_vu_id =1;
                    $this -> modelTaiKhoan-> insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
                    // var_dump($password);die;
                    header("location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                    exit();
    
                }else{
                    //Trả về form và lỗi
                    $_SESSION['flash'] = true;
                    header("location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                    exit();
                }
            }
        }

        public function formEditQuanTri(){
            $id_quan_tri = $_GET['id_quan_tri'];
            $quanTri = $this ->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
            require_once './views/taikhoan/quantri/editQuanTri.php';
            deleteSessionError();
        }

        public function postEditQuanTri(){
        //hàm này dùng để xử lý thêm dữ liệu

        //Kiểm tra xem dữ liệu có phải đc submit lên k
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Lấy ra dữ liệu


            $quan_tri_id = $_POST['quan_tri_id'] ?? '';


            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';


            //Tạo 1 mảng trống để chữa
            $errors = [];

            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên người dùng không được để trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thai  không được để trống';
            }
            
            $_SESSION['error'] = $errors;
            
            if (empty($errors)) {

                
                $this->modelTaiKhoan->updateTaikhoan($quan_tri_id, $ho_ten, $email, $so_dien_thoai, $trang_thai);

                // var_dump($abc); die;
                header("location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                //Trả về form và lỗi
                // Đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                header("location:" . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri=' . $quan_tri_id);
                exit();
            }
        }
    }
    
    public function resetPassword(){
        $tai_khoan_id = $_GET['id_quan_tri'];
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        //Đặt password mặt định
        $password = password_hash('123@123ab', PASSWORD_BCRYPT); //password_hash dùng để mã hóa
        $status = $this->modelTaiKhoan->resetPassword($tai_khoan_id, $password);
        if ($status && $tai_khoan['chuc_vu_id'] == 1) {
            header("location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }elseif ($status && $tai_khoan['chuc_vu_id'] == 1) {
            header("location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();
        }else{
            var_dump('lỗi khi reset tài khoản'); die;
        }
    }
    public function danhSachKhachhang(){
        $listKhachHang = $this -> modelTaiKhoan->getAllTaiKhoan(2);
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }

    public function formEditKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this ->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        require_once './views/taikhoan/khachhang/editKhachHang.php';
        deleteSessionError();
    }

    public function postEditKhachHang(){
        //hàm này dùng để xử lý thêm dữ liệu

        //Kiểm tra xem dữ liệu có phải đc submit lên k
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Lấy ra dữ liệu


            $khach_hang_id = $_POST['khach_hang_id'] ?? '';


            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $ngay_sinh = $_POST['ngay_sinh'] ?? '';
            $gioi_tinh = $_POST['gioi_tinh'] ?? '';
            $dia_chi = $_POST['ngay_sinh'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';


            //Tạo 1 mảng trống để chữa
            $errors = [];

            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên người dùng không được để trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống';
            }
            if (empty($ngay_sinh)) {
                $errors['ngay_sinh'] = 'Ngày sinh không được để trống';
            }
            if (empty($gioi_tinh)) {
                $errors['gioi_tinh'] = 'Giới tính không được để trống';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thai  không được để trống';
            }
            
            $_SESSION['error'] = $errors;
            
            if (empty($errors)) {

                
                $this->modelTaiKhoan->updateKhachHang($khach_hang_id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai);

                // var_dump($abc); die;
                header("location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            } else {
                //Trả về form và lỗi
                // Đặt chỉ thị xóa session sau khi hiển thị form
                $_SESSION['flash'] = true;
                header("location:" . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang=' . $khach_hang_id);
                exit();
            }
        }
    }

    public function deltailKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this -> modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        $listDonHang = $this->modelDonHang->getDonHangFromKhachHang($id_khach_hang);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromKhachHang($id_khach_hang);
        require_once './views/taikhoan/khachhang/detailKhachHang.php';
    }

    public function formLogin(){
        require_once './views/auth/formlogin.php';
        deleteSessionError();
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Lấy email và pass gửi lên từ form
            $email = $_POST['email'];
            $password = $_POST['password'];
            // var_dump($password);die;
            //Xử lý kiểm tra thông tin đăng nhập
            $user = $this ->modelTaiKhoan->checkLogin($email, $password);

            if ($user == $email) { // Trường hợp đăng nhập thành công
                // Lưu thông tin vào session
                $_SESSION['user_admin'] = $user;
                header("location: " . BASE_URL_ADMIN);
                exit();
            }else{
                // Lỗi thi lưu vào session
                $_SESSION['error'] = $user;
                // var_dump($_SESSION['error']);die;
                $_SESSION['flash'] = true;
                header("location:" . BASE_URL_ADMIN . '?act=login-admin');
            }
        }
    }
    public function logout(){
        if (isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
            header("location:" . BASE_URL_ADMIN . '?act=login-admin');        }
    }

    public function formEditCaNhanQuanTri(){
        $email = $_SESSION['user_admin'];
        $thongTin = $this -> modelTaiKhoan -> getTaiKhoanformEmail($email);
        // var_dump($thongTin);die;
        require_once './views/taikhoan/canhan/editCaNhan.php';
        deleteSessionError();
    }

    }

?>