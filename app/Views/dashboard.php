                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <?php echo lang("Panel.admins"); ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $user_count." ".lang("Panel.pieces"); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <?php echo lang("Panel.products"); ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $products_count." ".lang("Panel.pieces"); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <?php echo lang("Panel.valid_licenses"); ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $valid_licenses_count." ".lang("Panel.pieces"); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                <?php echo lang("Panel.warnings"); ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $warnings_count." ".lang("Panel.pieces"); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <?php echo lang("Panel.license_checks"); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="licenseChecksChart">
                                            <?php 
                                            $days = [];
                                            $valid_licenses = [];
                                            $warnings = [];
                                            setlocale(LC_TIME, config("App")->defaultLocale.".UTF-8");
                                            for ($i = 7; $i >= 0; $i--) {
                                                $time = strtotime($i." days ago");
                                                $v = 0;
                                                $w = 0;
                                                array_push($days, strftime("%d %B", $time));
                                                foreach ($last_ten_days_checks as $check) {
                                                    if(date("d-m-Y", $time) == date("d-m-Y", $check["time"])) {
                                                        if($check["status"] == 1) {
                                                            $v++;
                                                        }
                                                        else {
                                                            $w++;
                                                        }
                                                    }
                                                }
                                                array_push($valid_licenses, $v);
                                                array_push($warnings, $w);
                                            }
                                            echo json_encode([
                                                "tags" => [
                                                    "valid_license" => lang("Panel.valid_licenses_label"),
                                                    "warnings" => lang("Panel.warnings")
                                                ],
                                                "labels" => $days,
                                                "data" => [
                                                    "valid_licenses" => $valid_licenses,
                                                    "warnings" => $warnings
                                                ]
                                            ]);
                                            ?>
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <?php echo lang("Panel.check_license"); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2"><?php echo lang("Panel.product_name"); ?>:</div>
                                    <div class="input-group mb-2">
                                        <select id="productId" class="form-control bg-light border-0 small">
                                            <?php foreach($products as $product): ?>
                                            <option value="<?php echo $product["id"]; ?>">
                                                <?php echo $product["name"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mt-2"><?php echo lang("Panel.domain_name"); ?>:</div>
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            id="domainInput">
                                        <div class="input-group-append">
                                            <button data-url="<?php echo base_url("checkAdmin"); ?>"
                                                class="btn btn-primary" type="button" id="checkLicense">
                                                <i class="fas fa-chevron-right fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="checkResult"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                </div>
                <script src="<?php echo base_url("assets/js/chart.min.js"); ?>"></script>
                <script>
$(function() {
    var ctx = $("#licenseChecksChart");
    var ctx_data = JSON.parse(ctx.html());
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ctx_data.labels,
            datasets: [{
                label: ctx_data.tags.valid_license,
                data: ctx_data.data.valid_licenses,
                borderColor: 'rgb(39, 174, 96)',
                backgroundColor: 'rgba(39, 174, 96, 0.4)'
            }, {
                label: ctx_data.tags.warnings,
                data: ctx_data.data.warnings,
                borderColor: 'rgb(231, 76, 60)',
                backgroundColor: 'rgba(231, 76, 60, 0.4)'
            }]
        }
    });
    $("#checkLicense").click(function() {
        $("#checkResult").html("");
        $.post($("#checkLicense").data("url"), {
            "domain": $("#domainInput").val(),
            "product": $("#productId").val()
        }, function(d) {
            if (d.valid) {
                $("#checkResult").html(
                    "<div class='mt-3 text-success p-3 bg-light rounded'><i class='fas fa-check-circle fa-2x'></i><div>" +
                    d
                    .message +
                    "</div></div>");
            } else {
                $("#checkResult").html(
                    "<div class='mt-3 text-danger p-3 bg-light rounded'><i class='fas fa-times-circle fa-2x'></i><div>" +
                    d
                    .message +
                    "</div></div>");
            }
        });
    });
});
                </script>