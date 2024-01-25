<?php namespace App\Controllers;

class Panel extends BaseController
{
	public function __construct() {
		$this->session = session();
		$this->user = [];
		if($this->session->has("user")) {
			$this->userModel = model("UserModel");
			$this->licenseModel = model("LicenseModel");
			$this->productModel = model("ProductModel");
			$this->licenseCheckModel = model("LicenseCheckModel");
			$this->user = $this->userModel->get_user($this->session->get("user"));
		}
		else {
			header("Location: ".base_url("login"));
			exit();
		}
	}
	public function dashboard()
	{
		$data["session"] = $this->session;
		$data["page"] = "dashboard";
		$data["user"] = $this->user;
		$data["user_count"] = $this->userModel->get_total_user_count();
		$data["products_count"] = $this->productModel->get_total_products_count();
		$data["valid_licenses_count"] = $this->licenseModel->get_valid_licenses_count();
		$data["warnings_count"] = $this->licenseCheckModel->get_warnings_count();
		$data["last_ten_days_checks"] = $this->licenseCheckModel->get_last_ten_day();
		$data["products"] = $this->productModel->orderBy("name","asc")->findAll();
		$data["title"] = lang("Menu.dashboard")." - ".lang("General.app_title");
		return view("header", $data).view("dashboard").view("footer");
	}
	public function products()
	{
		$data["session"] = $this->session;
		$data["page"] = "products";
		$data["user"] = $this->user;
		$data["products"] = $this->productModel->orderBy("id","desc")->findAll();
		$data["title"] = lang("Menu.products")." - ".lang("General.app_title");
		return view("header", $data).view("products").view("footer");
	}
	public function add_product()
	{
		$data["session"] = $this->session;
		$data["page"] = "add_product";
		$data["user"] = $this->user;
		$data["title"] = lang("Menu.add_product")." - ".lang("General.app_title");
		return view("header", $data).view("add_product").view("footer");
	}
	public function edit_product($id)
	{
		$data["session"] = $this->session;
		$data["page"] = "edit_product";
		$data["user"] = $this->user;
		$data["product"] = $this->productModel->get_product_by_id($id);
		if(isset($data["product"]["id"])) {
			$data["title"] = lang("Menu.edit_product")." - ".lang("General.app_title");
			return view("header", $data).view("edit_product").view("footer");
		}
		else {
			header("Location: ".base_url("products"));
			exit();
		}
	}
	public function licenses()
	{
		$data["session"] = $this->session;
		$data["page"] = "licenses";
		$data["user"] = $this->user;
		$data["licenses"] = $this->licenseModel->db->table("licenses")->select("licenses.*, products.name as product_name")->join("products", "products.id = licenses.product")->orderBy("id","desc")->get()->getResultArray();
		$data["title"] = lang("Menu.licenses")." - ".lang("General.app_title");
		return view("header", $data).view("licenses").view("footer");
	}
	public function add_license()
	{
		$data["session"] = $this->session;
		$data["page"] = "add_license";
		$data["user"] = $this->user;
		$data["products"] = $this->productModel->orderBy("name","asc")->findAll();
		$data["title"] = lang("Menu.add_license")." - ".lang("General.app_title");
		return view("header", $data).view("add_license").view("footer");
	}
	public function edit_license($id)
	{
		$data["session"] = $this->session;
		$data["page"] = "edit_product";
		$data["user"] = $this->user;
		$data["products"] = $this->productModel->orderBy("name","asc")->findAll();
		$data["license"] = $this->licenseModel->get_license_by_id($id);
		if(isset($data["license"]["id"])) {
			$data["title"] = lang("Menu.edit_license")." - ".lang("General.app_title");
			return view("header", $data).view("edit_license").view("footer");
		}
		else {
			header("Location: ".base_url("licenses"));
			exit();
		}
	}
	public function license_checks()
	{
		$data["session"] = $this->session;
		$data["page"] = "license_checks";
		$data["user"] = $this->user;
		$license_checks_array = [];
		$license_checks = $this->licenseCheckModel->asArray()->orderBy("id","desc")->findAll();
		foreach($license_checks as $check) {
		$n = array_filter($license_checks_array, function($val) use ($check){
            return ($val["url"]==$check["url"] and $val["status"]==$check["status"] and $val["license_key"]==$check["license_key"]);
        });
		if(count($n) > 0) {
			$license_checks_array[array_keys($n)[0]]["times"] += $check["times"]; 
		}
		else {
			array_push($license_checks_array, $check);
		}
		}
		$data["license_checks"] = $license_checks_array;
		$data["title"] = lang("Menu.license_checks")." - ".lang("General.app_title");
		return view("header", $data).view("license_checks").view("footer");
	}
	public function unauthorized_uses()
	{
		$data["session"] = $this->session;
		$data["page"] = "unauthorized_uses";
		$data["user"] = $this->user;
		$data["unauthorized_uses"] = $this->licenseCheckModel->db->table($this->licenseCheckModel->table)->where("status", -1)->orderBy("id","desc")->get()->getResultArray();
		$data["title"] = lang("Menu.unauthorized_uses")." - ".lang("General.app_title");
		return view("header", $data).view("unauthorized_uses").view("footer");
	}
	public function add_admin()
	{
		$data["session"] = $this->session;
		$data["page"] = "add_admin";
		$data["user"] = $this->user;
		$data["title"] = lang("Menu.add_admin")." - ".lang("General.app_title");
		return view("header", $data).view("add_admin").view("footer");
	}
	public function general_settings()
	{
		$data["session"] = $this->session;
		$data["page"] = "general_settings";
		$data["user"] = $this->user;
		$data["title"] = lang("Menu.general_settings")." - ".lang("General.app_title");
		return view("header", $data).view("general_settings").view("footer");
	}
	public function admins()
	{
		$data["session"] = $this->session;
		$data["page"] = "admins";
		$data["user"] = $this->user;
		$data["admins"] = $this->userModel->orderBy("id","desc")->findAll();
		$data["title"] = lang("Menu.admins")." - ".lang("General.app_title");
		return view("header", $data).view("admins").view("footer");
	}
	public function integration()
	{
		$data["session"] = $this->session;
		$data["page"] = "integration";
		$data["user"] = $this->user;
		$data["title"] = lang("Menu.integration")." - ".lang("General.app_title");
		return view("header", $data).view("integration").view("footer");
	}
	public function php_encoder()
	{
		$data["session"] = $this->session;
		$data["page"] = "encoder";
		$data["user"] = $this->user;
		$data["title"] = lang("Menu.php_encoder")." - ".lang("General.app_title");
		return view("header", $data).view("php_encoder").view("footer");
	}
	public function php_encoder_post()
	{
		$data["session"] = $this->session;
		$data["page"] = "encoder";
		$data["user"] = $this->user;
		$data["code"] = $this->request->getVar("code");
		$data["title"] = lang("Menu.php_encoder")." - ".lang("General.app_title");
		return view("header", $data).view("php_encoder").view("footer");
	}
	public function edit_admin($id)
	{
		$data["session"] = $this->session;
		$data["page"] = "edit_admin";
		$data["user"] = $this->user;
		$data["admin"] = $this->userModel->get_user($id);
		if(isset($data["admin"]["id"])) {
			$data["title"] = lang("Menu.edit_admin")." - ".lang("General.app_title");
			return view("header", $data).view("edit_admin").view("footer");
		}
		else {
			header("Location: ".base_url("admins"));
			exit();
		}
	}
	public function logout() {
		$this->session->destroy();
		header("Refresh: 0; URL=".base_url("login"));
	}
}