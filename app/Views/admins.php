<link rel="stylesheet" href="<?php echo base_url("assets/css/dataTables.bootstrap4.min.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/css/responsive.dataTables.min.css"); ?>">
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
                        <?php echo lang("Menu.admins"); ?></h6>
						<a href="<?php echo base_url("admins/add"); ?>" class="btn btn-primary"><?php echo lang("Menu.add_admin"); ?></a>
                </div>
                <div class="card-body">
                    <table data-language="<?php echo base_url("assets/lang/".config("App")->defaultLocale.".json"); ?>"
                        id="adminsTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo lang("Panel.id"); ?></th>
                                <th><?php echo lang("Panel.admin_name"); ?></th>
                                <th><?php echo lang("Panel.admin_email"); ?></th>
                                <th><?php echo lang("Panel.action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($admins as $admin): ?>
                            <tr>
                                <td class="align-middle"><?php echo $admin["id"]; ?></td>
                                <td class="align-middle"><?php echo $admin["name"]; ?></td>
                                <td class="align-middle"><?php echo $admin["email"]; ?></td>
                                <td class="align-middle">
                                    <a class="btn btn-primary btn-icon-split btn-sm"
                                        href="<?php echo base_url("admins/edit")."/".$admin["id"]; ?>"><i
                                            class="fas fa-pencil-alt icon text-white-50 d-flex align-items-center"></i><span
                                            class="text"><?php echo lang("Panel.edit"); ?></span></a>
                                    <a class="btn btn-danger btn-icon-split btn-sm deleteAdmin"
                                        data-id="<?php echo $admin["id"]; ?>" href="javascript:;"><i
                                            class="fas fa-times icon text-white-50 d-flex align-items-center"></i><span
                                            class="text"><?php echo lang("Panel.delete"); ?></span></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/dataTables.bootstrap4.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/dataTables.responsive.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>"></script>
<script>
$(function() {
    var table = $("#adminsTable").DataTable({
        "order": [0, "desc"],
        "scroolX": true,
        responsive: true,
        "oLanguage": {
            "sUrl": $("#adminsTable").data("language")
        }
    });
	table.on("responsive-display", function() {deleteAdmin();});
	function deleteAdmin() {
    $(".deleteAdmin").click(function(e) {
        Swal.fire({
            title: "<?php echo lang("Ajax.admin_delete"); ?>",
            text: "<?php echo lang("Ajax.admin_delete_text");?>",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?php echo lang("Panel.yes"); ?>",
            cancelButtonText: "<?php echo lang("Panel.no"); ?>"
        }).then((result) => {
            if (result.value) {
                $.post('<?php echo base_url("admins/delete/"); ?>', {
                    "id": $(e.currentTarget).data("id")
                }, function() {});
                Swal.fire(
                    '<?php echo lang("Ajax.admin_deleted"); ?>',
                    '<?php echo lang("Ajax.admin_deleted_text"); ?>',
                    'success'
                ).then(function() {
                    window.location.href = window.location.href;
                });
            }
        });
    });
	}
	deleteAdmin();
});
</script>