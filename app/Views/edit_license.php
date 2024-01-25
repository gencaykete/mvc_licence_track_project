<style type="text/css">
.swal2-icon.swal2-question::before {
    display: none;
}
</style>
<link href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/css/bootstrap-datetimepicker.min.css"); ?>" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php echo lang("Menu.edit_license").": ".$license["license_key"]; ?></h6>
                </div>
                <div class="card-body dataTable-container">
                    <div class="container-fluid p-0">
                        <form class="ajaxForm" data-redirect="<?php echo current_url(); ?>"
                            action="<?php echo base_url("licenses/update"); ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $license["id"]; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><?php echo lang("Panel.product_name"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-archive"></i></span>
                                        </div>
                                        <select disabled class="form-control bg-light border-0 small">
                                            <?php foreach($products as $product): ?>
                                            <option value="<?php echo $product["id"]; ?>"
                                                <?php echo $product["id"] == $license["product"] ? "selected" : ""; ?>>
                                                <?php echo $product["name"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <span><?php echo lang("Panel.domain_name"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-server"></i></span>
                                        </div>
                                        <input placeholder="example.com" value="<?php echo $license["domain"]; ?>"
                                            type="text" name="domain" class="form-control bg-light border-0 small"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <span><?php echo lang("Panel.license_type"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-border-style"></i></span>
                                        </div>
                                        <select id="licenseType" name="type"
                                            class="form-control bg-light border-0 small" required>
                                            <option value="0" <?php echo $license["type"] == 0 ? "selected" : ""; ?>>
                                                <?php echo lang("Panel.license_endless"); ?></option>
                                            <option value="1" <?php echo $license["type"] == 1 ? "selected" : ""; ?>>
                                                <?php echo lang("Panel.license_limited"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="licenseUntil">
                                <div class="col-md-6 mt-2">
                                    <span><?php echo lang("Panel.valid_until"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="date" name="until"
                                            class="form_datetime form-control bg-light border-0 small"
                                            value="<?php echo date("Y-m-d", $license["until"]); ?>">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3"
                                type="submit"><?php echo lang("Menu.edit_license"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/ajaxForm.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/bootstrap-datetimepicker.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/lang/bootstrap-datetimepicker.".config("App")->defaultLocale.".js"); ?>">
</script>
<script>
$(function() {
    $(".form_datetime").datetimepicker({
        language: '<?php echo config("App")->defaultLocale; ?>',
        pickTime: false,
        minView: 2,
        format: 'yyyy-mm-dd'
    });
    $("#licenseType").change(function() {
        if ($("#licenseType").val() == "1") {
            $("#licenseUntil").show();
        } else {
            $("#licenseUntil").hide();
        }
    });
    $("#licenseType").change();
});
</script>