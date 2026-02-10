<?php
class Controller {
    // Gọi Model
    public function model($model) {
        // Kiểm tra file Model có tồn tại không
        if (file_exists("../app/Models/" . $model . ".php")) {
            require_once "../app/Models/" . $model . ".php";
            return new $model;
        } else {
            die("Model <b>$model</b> not found!"); // Báo lỗi văn minh hơn
        }
    }

    // Gọi View
    public function view($view, $data = []) {
        // Kiểm tra file View có tồn tại không
        if (file_exists("../app/Views/" . $view . ".php")) {
            require_once "../app/Views/" . $view . ".php";
        } else {
            die("View <b>$view</b> not found!"); // Báo lỗi văn minh hơn
        }
    }
}