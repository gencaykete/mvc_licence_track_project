<?php namespace App\Controllers;

class PanelAjax extends BaseController
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
	public function add_product() {
		if(!empty($this->request->getVar("name")) && !empty($this->request->getVar("prefix"))) {
			$this->productModel->insert([
				"name" => strip_tags($this->request->getVar("name")),
				"prefix" => strtoupper(strip_tags($this->request->getVar("prefix")))
			]);
			$data = [
				"success" => true,
				"title" => lang("Ajax.add_product_successful"),
				"message" => lang("Ajax.add_product_successful_text")
			];
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	public function update_product() {
		if(!empty($this->request->getVar("id")) && !empty($this->request->getVar("name")) && !empty($this->request->getVar("prefix"))) {
			$this->productModel->update($this->request->getVar("id"), [
				"name" => strip_tags($this->request->getVar("name")),
				"prefix" => strtoupper(strip_tags($this->request->getVar("prefix")))
			]);
			$data = [
				"success" => true,
				"title" => lang("Ajax.update_product_successful"),
				"message" => lang("Ajax.update_product_successful_text")
			];
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	public function update_admin() {
		if(!empty($this->request->getVar("name")) && !empty($this->request->getVar("email"))) {
			$user = $this->userModel->get_user($this->request->getVar("id"));
			if($user["email"] == $this->request->getVar("email") || $this->userModel->db->table($this->userModel->table)->where("email", $this->request->getVar("email"))->countAllResults() == 0) {
			$this->userModel->update($this->request->getVar("id"), [
				"name" => strip_tags($this->request->getVar("name")),
				"email" => strip_tags($this->request->getVar("email"))
			]);
			if(!empty($this->request->getVar("password"))) {
				$this->userModel->update($this->request->getVar("id"), [
					"password" => md5($this->request->getVar("password"))
				]);	
			}
			$data = [
				"success" => true,
				"title" => lang("Ajax.update_admin_successful"),
				"message" => lang("Ajax.update_admin_successful_text")
			];
			}
			else {
				$data = [
					"success" => false,
					"title" => lang("Ajax.email_already_found"),
					"message" => lang("Ajax.email_already_found_text")
				];
			}
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	function createLicenseKey($prefix) {
		$key = $prefix."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5)."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5)."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
		while($this->licenseModel->db->table($this->licenseModel->table)->where("license_key", $key)->countAllResults() > 0) {
			$key = $prefix."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5)."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5)."-".substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
		}
		return strtoupper($key);
	}
	public function add_license() {
		if(!empty($this->request->getVar("product")) && !empty($this->request->getVar("domain")) && is_numeric($this->request->getVar("type"))) {
			$product = $this->productModel->get_product_by_id($this->request->getVar("product"));
			$license_key = $this->createLicenseKey($product["prefix"]);
			$this->licenseModel->insert([
				"product" => $this->request->getVar("product"),
				"license_key" => $license_key,
				"domain" => strip_tags($this->request->getVar("domain")),
				"until" => $this->request->getVar("type") == 1 && !empty($this->request->getVar("until")) ? strtotime($this->request->getVar("until")) : 0,
				"type" => $this->request->getVar("type") == 1 ? 1 : 0
			]);	
			$data = [
				"success" => true,
				"title" => lang("Ajax.add_license_successful"),
				"message" => lang("Ajax.add_license_successful_text")
			];
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	public function update_license() {
		if(!empty($this->request->getVar("id")) && !empty($this->request->getVar("domain")) && is_numeric($this->request->getVar("type"))) {
			$this->licenseModel->update($this->request->getVar("id"), [
				"domain" => strip_tags($this->request->getVar("domain")),
				"until" => $this->request->getVar("type") == 1 && !empty($this->request->getVar("until")) ? strtotime($this->request->getVar("until")) : 0,
				"type" => $this->request->getVar("type") == 1 ? 1 : 0
			]);
			$data = [
				"success" => true,
				"title" => lang("Ajax.update_license_successful"),
				"message" => lang("Ajax.update_license_successful_text")
			];
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	public function add_admin() {
		if(!empty($this->request->getVar("name")) && !empty($this->request->getVar("email")) && !empty($this->request->getVar("password"))) {
			if(!$this->userModel->db->table($this->userModel->table)->where("email", $this->request->getVar("email"))->countAllResults() > 0) {
				$this->userModel->insert([
					"name" => strip_tags($this->request->getVar("name")),
					"email" => strip_tags($this->request->getVar("email")),
					"password" => md5($this->request->getVar("password"))
				]);	
				$data = [
					"success" => true,
					"title" => lang("Ajax.add_admin_successful"),
					"message" => lang("Ajax.add_admin_successful_text")
				];	
			}
			else {
				$data = [
					"success" => false,
					"title" => lang("Ajax.email_already_found"),
					"message" => lang("Ajax.email_already_found_text")
				];
			}
		}
		else {
			$data = [
				"success" => false,
				"title" => lang("Ajax.empty_fields"),
				"message" => lang("Ajax.empty_fields_text")
			];
		}
		return $this->response->setJSON($data);
	}
	public function delete_product() {
		if(!empty($this->request->getVar("id"))) {
			$this->licenseModel->where("product", $this->request->getVar("id"))->delete();
			$this->productModel->where("id", $this->request->getVar("id"))->delete();
		}
	}
	public function delete_license() {
		if(!empty($this->request->getVar("id"))) {
			$this->licenseModel->where("id", $this->request->getVar("id"))->delete();
		}
	}
	public function delete_license_check() {
		if(!empty($this->request->getVar("id"))) {
			$this->licenseCheckModel->where("id", $this->request->getVar("id"))->delete();
		}
	}
	public function delete_admin() {
		if(!empty($this->request->getVar("id")) && $this->request->getVar("id") != $this->user["id"]) {
			$this->userModel->where("id", $this->request->getVar("id"))->delete();
		}
	}
	public function update_settings() {
		for($i = 0; $i < count($_POST); $i++) {
			if($_POST[array_keys($_POST)[$i]] != constant(array_keys($_POST)[$i])) {
				$this->licenseModel->db->table("configs")->update([
					"value" => $_POST[array_keys($_POST)[$i]]
				], [
					"name" => array_keys($_POST)[$i]
				]);
			}
		}
		return $this->response->setJSON([
			"success" => true,
			"title" => lang("Ajax.update_settings_successful"),
			"message" => lang("Ajax.update_settings_successful_text")
		]);
	}
}