<link rel="stylesheet" href="<?php echo base_url("assets/css/prism.css"); ?>">
<div class="container-fluid">
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php echo lang("Menu.php_encoder"); ?></h6>
                </div>
                <div class="card-body">
					<?php if(empty($code)): ?>
					<form action="<?php echo current_url();?>" method="POST">
					<?php echo lang("Panel.php_encoder_text"); ?>
					<div>
						<textarea class="form-control mt-2" name="code" style="height:250px;"></textarea>
					</div>
					<button class="btn btn-primary mt-2" type="submit"><?php echo lang("Panel.encode_code"); ?></button>
					</form>
					<?php else: ?>
						<?php echo lang("Panel.php_encoded_text"); ?>
						<pre style="height:250px;"><code class="language-php">eval(base64_decode(hex2bin(str_rot13(base64_decode(str_rot13("<?php
						echo str_rot13(base64_encode(str_rot13(bin2hex(base64_encode(rtrim( ltrim( trim($code), '<?php' ), '?>' ))))));
						?>")))))); </code></pre>
						<a href="<?php echo current_url();?>"><button class="btn btn-primary mt-2" type="submit"><?php echo lang("Panel.encode_another_code"); ?></button></a>
					<?php endif; ?>
				</div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/prism.js"); ?>"></script>