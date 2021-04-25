$(document).ready(function () {
    function a() {
        $("#HoursPickupModal").modal("toggle"),
            $(".clockpicker").clockpicker(),
            $(".clockpickerall").clockpicker({
                afterDone: function () {
                    $(".clockpicker input").val($(".clockpickerall input").val());
                },
            });
    }
    $(".SaveFinalDate").on('click',function () {
        var a = "";
        $(".hourselected").each(function (b) {
            void 0 != $(this).data("date") && (a += $(this).data("date") + "*" + $(this).val() + ";");
        }),
            $("#datefinal").val(a),
            $("#HoursPickupModal").modal("toggle");
    }),
        $(".btn-TimeSelection").on('click',function () {
            a();
        });
    var b = [],
        c = {
            onElementValidate: function (a, c, d, e) {
                a || b.push({ el: c, error: e });
            },
        },
        d = {};
    $(".AjoutFinalise").on('click',function () {
        if (((b = []), $("#AjoutForm").isValid(d, c, !0))) {
            var a = $("#datefinal").val().slice(0, -1).split(";");
            a.sort();
            for (var e = "", f = 0; f < a.length; f++) {
                var g = a[f].split("*");
                return (e += '<li class="list-group-item">Le kk' + g[0] + " à " + g[1] + "</li>"), !1;
            }
        }
    }),
        $(".input-group.date")
            .datepicker({ clearBtn: !0, language: "fr", multidate: !0, multidateSeparator: ",", startDate: "today", todayHighlight: !0,format: "dd-mm-yyyy" })
            .on("hide", function (b) {
                var c = $("#datetimepicker1").val().split(",");
                if (c.length >= 1 && "" != c[0]) {
                    $("#themodal").html(""), c.sort();
                    for (var d = 0; d < c.length; d++)
                        null != c[d] &&
                            $("#themodal").append(
                                '<div class="form-group"><label for="username" class="col-sm-4 control-label" >Le ' +
                                    c[d] +
                                    ' à </label><div class="col-sm-3 input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">    <input type="text" class="form-control hourselected " value="09:30" data-date="' +
                                    c[d] +
                                    '">    <span class="input-group-addon">        <span class="glyphicon glyphicon-time"></span>    </span></div>'
                            );
                    $(".btn-TimeSelection").removeClass("hide"), a();
                }
            }),
        $("#date").on('click',function () {
            $(this).datepickup();
        });
        //Date picker for event filter
        $('#dates_id,#filter_date_max_id').datepicker({
            todayBtn: true,
            clearBtn: true,
            language: "fr",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });
});
