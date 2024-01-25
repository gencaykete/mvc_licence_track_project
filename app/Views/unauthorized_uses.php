<link rel="stylesheet" href="<?php echo base_url("assets/css/dataTables.bootstrap4.min.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/css/responsive.dataTables.min.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/css/buttons.dataTables.min.css"); ?>">
<style type="text/css">
div.dt-buttons:before {
    content: '<?php echo lang("Panel.download_report"); ?>:';
    display: flex;
    align-items: center;
	margin-right: .5rem;
}
.swal2-icon.swal2-question::before {
    display: none;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <?php echo lang("Menu.unauthorized_uses"); ?></h6>
                </div>
                <div class="card-body">
                    <table data-language="<?php echo base_url("assets/lang/".config("App")->defaultLocale.".json"); ?>"
                        id="licenseChecksTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo lang("Panel.id"); ?></th>
                                <th><?php echo lang("Panel.url"); ?></th>
                                <th><?php echo lang("Panel.server_ip"); ?></th>
                                <th><?php echo lang("Panel.user_ip"); ?></th>
                                <th><?php echo lang("Panel.date"); ?></th>
                                <th><?php echo lang("Panel.action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($unauthorized_uses as $unauthorized_use): ?>
                            <tr>
                                <td class="align-middle"><?php echo $unauthorized_use["id"]; ?></td>
                                <td class="align-middle"><?php echo $unauthorized_use["url"]; ?></td>
                                <td class="align-middle"><?php echo $unauthorized_use["server_ip"]; ?></td>
                                <td class="align-middle"><?php echo $unauthorized_use["user_ip"]; ?></td>
                                <td class="align-middle"><?php echo date("d/m/Y H:i", $unauthorized_use["time"]); ?></td>
								<td class="align-middle">
								<a class="btn btn-danger btn-icon-split btn-sm deleteLicenseCheck" data-id="<?php echo $unauthorized_use["id"]; ?>" href="javascript:;"><i class="fas fa-times icon text-white-50 d-flex align-items-center"></i><span class="text"><?php echo lang("Panel.delete"); ?></span></a>
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
<script src="<?php echo base_url("assets/js/dataTables.buttons.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/buttons.print.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jszip.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/pdfmake.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/vfs_fonts.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/buttons.html5.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/buttons.bootstrap4.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>"></script>
<script>
$(function() {
    var table = $("#licenseChecksTable").DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'print',
				text: '<?php echo lang("Panel.print"); ?>',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                }
			},
            {
				extend: 'excelHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                }
			},
            {
				extend: 'pdfHtml5',
				exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                }
			}
        ],
        "order": [0, "desc"],
        "scroolX": true,
        responsive: true,
        "oLanguage": {
            "sUrl": $("#licenseChecksTable").data("language")
        }
    });
	table.on("responsive-display", function() {deleteLicenseCheck();});
	function deleteLicenseCheck() {
	$(".deleteLicenseCheck").click(function(e) {
         $.post('<?php echo base_url("checks/delete/"); ?>', {
                    "id": $(e.currentTarget).data("id")
                }, function() {
					window.location.href = window.location.href;
				});
		
    });
	}
	deleteLicenseCheck();
});
</script>