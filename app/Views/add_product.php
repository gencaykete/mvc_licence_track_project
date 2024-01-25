<style type="text/css">
.swal2-icon.swal2-question::before {
    display: none;
}
</style>
<link href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php echo lang("Menu.add_product"); ?></h6>
                </div>
                <div class="card-body dataTable-container">
                    <div class="container-fluid p-0">
                        <form class="ajaxForm" data-redirect="<?php echo base_url("products"); ?>"
                            action="<?php echo base_url("ajax/addProduct"); ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><?php echo lang("Panel.product_name"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-archive"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control bg-light border-0 small"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <span><?php echo lang("Panel.product_prefix"); ?>:</span>
                                    <div class="input-group my-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-primary text-light"><i
                                                    class="fas fa-file-word"></i></span>
                                        </div>
                                        <input type="text" name="prefix" maxlength="5"
                                            class="form-control bg-light border-0 small" required>
                                    </div>
                                </div>
                            </div>
                            <small><?php echo lang("Panel.prefix_info"); ?></small>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-primary"><?php echo lang("Menu.add_product"); ?></button>
                            </div>
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