<?php namespace App\Controllers;
use Twilio\Rest\Client;
class LicenseCheck extends BaseController
{
	public function __construct() {
		$this->licenseModel = model("LicenseModel");
		$this->licenseCheckModel = model("LicenseCheckModel");
	}
	public function licenseInvalidNotifications($url) {
		$notification_text = sprintf(lang("Panel.unauthorized_use_message"), $this->request->getVar("url"), base_url("warnings"));
		if(mail_notifications == "1") {
			$email = \Config\Services::email();
			$email->initialize([
				"protocol" => "smtp",
				"SMTPHost" => smtp_host,
				"SMTPUser" => smtp_user,
				"SMTPPass" => smtp_password,
				"SMTPPort" => smtp_port
			]);
			$email->setFrom(smtp_user, lang("General.app_title"));
			$email->setTo(notification_mail);
			$email->setSubject(lang("Panel.unauthorized_use_warning"));
			$email->setMessage($notification_text);
			$email->send();	
		}
		if(telegram_notifications == "1") {
			file_get_contents("https://api.telegram.org/bot".telegram_bot_token."/sendMessage?".http_build_query(["text" => $notification_text, "chat_id" => telegram_chat_id]));
		}
		if(sms_notifications == "1") {
			$safe_message = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç'], ['i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c'], $notification_text);
			if(sms_company == "netgsm") {
				file_get_contents("https://api.netgsm.com.tr/sms/send/get/?usercode=".urlencode(netgsm_username)."&password=".urlencode(netgsm_password)."&gsmno=".notification_phone."&message=".urlencode($safe_message)."&msgheader=".urlencode(netgsm_header));
			}
			if(sms_company == "iletimerkezi") {
				file_get_contents("https://api.iletimerkezi.com/v1/send-sms/get/?username=".urlencode(iletimerkezi_username)."&password=".urlencode(iletimerkezi_password)."&text=".urlencode($safe_message)."&receipents=".notification_phone."&sender=".urlencode(iletimerkezi_sender));
			}
			if(sms_company == "mutlucell") {
				$xml_data ='<?xml version="1.0" encoding="UTF-8"?><smspack ka="'.mutlucell_username.'" pwd="'.mutlucell_password.'" org="'.mutlucell_header.'"><mesaj><metin>'.$safe_message.'</metin><nums>'.notification_phone.'</nums></mesaj></smspack>';
				$URL = "https://smsgw.mutlucell.com/smsgw-ws/sndblkex";
                $ch = curl_init($URL);
                curl_setopt($ch, CURLOPT_MUTE, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
			}
			if(sms_company == "vatansms") {
				$postUrl='http://www.oztekbayi.com/panel/smsgonder1Npost.php';
				$xmlString='data=<sms>
				<kno>'.vatansms_user_number.'</kno> 
				<kulad>'.vatansms_username.'</kulad> 
				<sifre>'.vatansms_password.'</sifre>    
				<gonderen>'.vatansms_sender.'</gonderen> 
				<mesaj>'. $safe_message .'</mesaj> 
				<numaralar>'.notification_phone.'</numaralar>
				<tur>Normal</tur> 
				</sms>';  
				$Veriler =  $xmlString;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $postUrl);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $Veriler);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				$response = curl_exec($ch);
				curl_close($ch);
			}
			if(sms_company == "twilio") {
				require APPPATH."/Libraries/Twilio/autoload.php";
				$client = new Client(twilio_account_sid, twilio_auth_token);
				$message = $client->messages->create(
					notification_phone,
					array(
						'from' => twilio_phone_number,
						'body' => $safe_message
					)
				);
			}
		}
	}
	public function check_license()
	{
		if(!empty($this->request->getVar("license_key")) && !empty($this->request->getVar("url")) && !empty($this->request->getVar("server_ip")) && !empty($this->request->getVar("user_ip"))) {
			$domain = parse_url($this->request->getVar("url"))["host"];
			$domain = str_replace('www.','',$domain);
			$domain = str_replace('cpcontacts.','',$domain);
			$domain = str_replace('cpcalendars.','',$domain);
			$domain = str_replace('mail.','',$domain);
			$domain = str_replace('webmail.','',$domain);
			$valid = $this->licenseModel->check_license_by_key($domain, $this->request->getVar("license_key"));
			if($valid) {
				$licenseChecks = $this->licenseCheckModel->table($this->licenseCheckModel->table)->where("time > ".strtotime(date("d-m-Y")))->where(["license_key" => $this->request->getVar("license_key"),"url" => $domain])->get()->getResultArray();
				if(count($licenseChecks) == 0) {
						$this->licenseCheckModel->insert([
							"license_key" => $this->request->getVar("license_key"),
							"url" => $domain,
							"server_ip" => $this->request->getVar("server_ip"),
							"user_ip" => $this->request->getVar("user_ip"),
							"times" => 1,
							"status" => 1,
							"time" => time()
						]);
				}
				else {
					$this->licenseCheckModel->update($licenseChecks[0]["id"], [
						"server_ip" => $this->request->getVar("server_ip"),
						"user_ip" => $this->request->getVar("user_ip"),
						"times" => $licenseChecks[0]["times"]+1,
						"time" => time(),
						"status" => 1
					]);
				}
				$data = [
					"valid" => true,
					"message" => lang("Ajax.license_is_valid")
				];
			}
			else {
				$licenseChecks = $this->licenseCheckModel->table($this->licenseCheckModel->table)->where("time > ".strtotime(date("d-m-Y")))->where(["license_key" => $this->request->getVar("license_key"),"url" => $this->request->getVar("url")])->get()->getResultArray();
				if(count($licenseChecks) == 0) {
					$this->licenseCheckModel->insert([
						"license_key" => $this->request->getVar("license_key"),
						"url" => $this->request->getVar("url"),
						"server_ip" => $this->request->getVar("server_ip"),
						"user_ip" => $this->request->getVar("user_ip"),
						"times" => 1,
						"status" => -1,
						"time" => time()
					]);
					$this->licenseInvalidNotifications($this->request->getVar("url"));
				}
				else {
					$this->licenseCheckModel->update($licenseChecks[0]["id"], [
						"server_ip" => $this->request->getVar("server_ip"),
						"user_ip" => $this->request->getVar("user_ip"),
						"times" => $licenseChecks[0]["times"]+1,
						"time" => time(),
						"status" => -1
					]);
				}
				$data = [
					"valid" => false,
					"message" => lang("Ajax.license_not_valid")
				];
			}
		}
		else {
			$data = [
				"valid" => false,
				"message" => lang("Ajax.enter_valid_domain_key")
			];
		}
		return $this->response->setJSON($data);
	}
	public function check_license_product()
	{
		if(!empty($this->request->getVar("product")) && !empty($this->request->getVar("domain")) && filter_var($this->request->getVar("domain"), FILTER_VALIDATE_DOMAIN)) {
			$valid = $this->licenseModel->check_license($this->request->getVar("domain"), $this->request->getVar("product"));
			if($valid) {
				$data = [
					"valid" => true,
					"message" => lang("Ajax.license_is_valid")
				];
			}
			else {
				$data = [
					"valid" => false,
					"message" => lang("Ajax.license_not_valid")
				];
			}
		}
		else {
			$data = [
				"valid" => false,
				"message" => lang("Ajax.enter_valid_domain_key")
			];
		}
		return $this->response->setJSON($data);
	}
}