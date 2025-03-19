<?php
class AdminDanhMucController{
    public $modelDanhMuc;
    public function __construct()
    {
        $this->modelDanhMuc= new AdminDanhMuc();
    }
    public function danhSachDanhMuc(){
        $listDanhMuc = $this-> modelDanhMuc ->getAllDanhMuc();
        require_once './views/danhmuc/listDanhMuc.php';
    }
    public function formAddDanhMuc(){
        //hàm này dùng để hiện thị form nhập
        require_once './views/danhmuc/addDanhMuc.php';
        
    }
    public function postAddDanhMuc(){
        //hàm này dùng để xử lý thêm dữ liệu
        
        //Kiểm tra xem dữ liệu có phải đc submit lên k
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            //Tạo 1 mảng trống để chữa
            $errors = [];
            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'Tên danh mục không được để trống';
            }
            //nếu k có lỗi thì tiến hành hànhtheem danh mục
            if (empty($errors)) {
                //nếu k có lỗi thì tiến hành hànhtheem danh mục
                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();

            }else{
                //Trả về form và lỗi
                require_once './views/danhmuc/addDanhMuc.php';
            }
        }
    }

    public function formEditAddDanhMuc(){
        //hàm này dùng để hiện thị form nhập
        //Lấy ra thông tin danh mục cần sửa
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            require_once './views/danhmuc/editDanhMuc.php';
        }else{
            header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
        }
        
    }
    public function postEditDanhMuc(){
        //hàm này dùng để xử lý thêm dữ liệu
        
        //Kiểm tra xem dữ liệu có phải đc submit lên k
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];
            //Tạo 1 mảng trống để chữa
            $errors = [];
            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'Tên danh mục không được để trống';
            }
            //nếu k có lỗi thì tiến hành hành sửa danh mục
            if (empty($errors)) {
                //nếu k có lỗi thì tiến hành hành sửa danh mục
                $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
                exit();

            }else{
                //Trả về form và lỗi
                $danhMuc = ['id' => $id, 'ten_danh_muc'=> $ten_danh_muc, 'mo_ta'=> $mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }

    public function deleteDanhMuc(){
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            $this->modelDanhMuc->destroyDanhMuc($id);
        }
        header("location: " . BASE_URL_ADMIN . '?act=danh-muc');
        exit();
    }

    
}

?>