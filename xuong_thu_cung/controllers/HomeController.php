<?php 

class HomeController
{
    public $modelSanPham;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
    }
    public function home(){
        echo "Đây là home";
    }
    public function trangChu(){
        echo "Đây là trang chủ của tôi";
    }
    public function danhSachSanPham(){
        // echo "Đây là danh sách sản phẩm";
        $listProduct = $this->modelSanPham->getAllProduct();
        var_dump($listProduct);
        require_once './views/listProduct.php';
    }

}