<?php namespace App\Controllers;

class Auth extends BaseController
{
	public function __construct() {
		$this->session = session();
		if(!$this->session->has("user")) {
			$this->userModel = model("UserModel");
		}
		else {
			header("Location: ".base_url());
		}
	}
	public function login() {
		return view("login");
	}
	public function login_process() {
		if(!empty($this->request->getVar("email")) && !empty($this->request->getVar("password"))) {
			$user = $this->userModel->check_user($this->request->getVar("email"), $this->request->getVar("password"));
			if(isset($user["id"])) {
				$this->session->set("user", $user["id"]);
				$data = ["success" => true, "title" => lang("Auth.login_successful"), "message" => lang("Auth.login_successful_message")];
			}
			else {
				$data = ["success" => false, "title" => lang("Auth.login_failed"), "message" => lang("Auth.login_failed_message")];
			}
		}
		else {
			$data = ["success" => false, "title" => lang("Auth.empty_fields"), "message" => lang("Auth.empty_fields_message")];
		}
		return $this->response->setJSON($data);
	}
}