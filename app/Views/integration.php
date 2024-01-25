<link rel="stylesheet" href="<?php echo base_url("assets/css/prism.css"); ?>">
<div class="container-fluid">
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php echo lang("Menu.integration"); ?></h6>
                </div>
                <div class="card-body">
					<?php echo lang("Panel.integration_text_1"); ?>
					<pre style="height:250px;"><code class="language-php">function lisansimo_check($license_key, $lisansimo_server, $time) {
$stime = time();
if(!isset($_COOKIE["lisansimo"]) || $stime-(int)$_COOKIE["lisansimo"] > $time) {
	unset($_COOKIE["lisansimo"]);
	setcookie("lisansimo", $stime);
}
if($time == 0 || !isset($_COOKIE["lisansimo"]) || $_COOKIE["lisansimo"]-$stime == 0) {
$lisansimo_ch = curl_init();
curl_setopt($lisansimo_ch, CURLOPT_URL, $lisansimo_server."check");
curl_setopt($lisansimo_ch, CURLOPT_POST, 1);
curl_setopt($lisansimo_ch, CURLOPT_POSTFIELDS, http_build_query([
	"license_key" => $license_key,
	"url" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
	"server_ip" => $_SERVER['SERVER_ADDR'],
	"user_ip" => $_SERVER['REMOTE_ADDR']
]));
curl_setopt($lisansimo_ch, CURLOPT_RETURNTRANSFER, true);
$lisansimo_result = json_decode(curl_exec($lisansimo_ch));
curl_close($lisansimo_ch);
if(!$lisansimo_result->valid) {
	unset($_COOKIE["lisansimo"]);
	setcookie("lisansimo", 0);
	echo file_get_contents($lisansimo_server."page/warning");
	exit;
}
}
}
lisansimo_check($license_key, "<?php echo base_url(); ?>/", 10);</code></pre>
					<?php echo lang("Panel.integration_text_2"); ?>
					<pre><code class="language-php">$license_key = "USER-LICENSE-KEY-HERE";</code></pre>
				</div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/prism.js"); ?>"></script>