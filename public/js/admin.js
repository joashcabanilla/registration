let userTable = $("#userTable")
    .on("init.dt", function () {
        $(".dataTables_wrapper").prepend(
            "<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>"
        );
    })
    .DataTable({
        ordering: false,
        serverSide: true,
        dom: "rtip",
        columnDefs: [
            {
                targets: 0,
                width: "1%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 1,
                width: "10%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 2,
                width: "20%",
                className: "text-left align-middle font-weight-bold p-2",
            },
            {
                targets: 3,
                width: "10%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 4,
                width: "10%",
                className: "text-left align-middle font-weight-bold p-2",
            },
            {
                targets: 5,
                width: "10%",
                className: "text-left align-middle font-weight-bold p-2",
            },
            {
                targets: 6,
                width: "5%",
                className: "text-center align-middle font-weight-bold p-2",
            },
        ],
        ajax: {
            url: "/admin/userTable",
            type: "POST",
            data: function (d) {
                d.filterSearch = $("#filterSearch").val();
                d.filterUserType = $("#filterUserType").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            },
        },
    });

$("#filterSearch").keyup((e) => {
    userTable.draw();
});

$("#filterUserType").change((e) => {
    userTable.draw();
});

$("#addBtn").click((e) => {
    $("#userModal").modal("show");
});

$("#showPassword").change((e) => {
    if ($(e.currentTarget).is(":checked")) {
        $("#addPassword").attr("type", "text");
    } else {
        $("#addPassword").attr("type", "password");
    }
});

$("#defaultPassword").change((e) => {
    if ($(e.currentTarget).is(":checked")) {
        $("#addPassword").val($("#defaultPassword").val());
        $("#addPassword").removeClass("is-invalid");
    } else {
        $("#addPassword").val("");
    }
});

$("#addPassword").keyup((e) => {
    $("#defaultPassword").prop("checked", false);
});

$("#userModal").on("hidden.bs.modal", function (e) {
    $("#addUserType").val("");
    $("#addName").val("");
    $("#addUsername").val("");
    $("#addPassword").val("");
    $("#userForm").find("input[type='checkbox']").prop("checked", false);
    $("#userForm").find("input[type='hidden']").val("");
    $("#userModal").find("input[name='password']").prop("required", true);
    $("#userModalLabel").text("Create New User");
});

$("#userForm").submit((e) => {
    e.preventDefault();
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "/admin/createUpdateUser",
        data: $(e.currentTarget).serializeArray(),
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                for (let errorKey in res.error) {
                    $("#userForm")
                        .find("input[name='" + errorKey + "']")
                        .addClass("is-invalid")
                        .focus()
                        .next()
                        .text(res.error[errorKey]);
                }
            } else {
                $("#userModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    userTable.ajax.reload(null, false);
                });
            }
        },
    });
});

$("#userForm")
    .find("input")
    .keyup((e) => {
        $(e.currentTarget).removeClass("is-invalid");
    });

$("#userTable").on("click", ".editBtn", (e) => {
    let userId = $(e.currentTarget).data("id");
    $("#userModalLabel").text("Update User Info");
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "/admin/getUser",
        data: { id: userId },
        success: (res) => {
            $.LoadingOverlay("hide");
            $("#userModal").find("input[name='id']").val(res.id);
            $("#userModal").find("select[name='userType']").val(res.user_type);
            $("#userModal").find("input[name='name']").val(res.name);
            $("#userModal").find("input[name='username']").val(res.username);
            $("#userModal")
                .find("input[name='password']")
                .prop("required", false);
            $("#userModal").modal("show");
        },
    });
});

$("#userTable").on("click", ".deactivateBtn", (e) => {
    let userId = $(e.currentTarget).data("id");
    $.ajax({
        type: "POST",
        url: "/admin/getUser",
        data: { id: userId },
        success: (res) => {
            $.LoadingOverlay("hide");
            Swal.fire({
                title: "Deactivate Account",
                text:
                    "Are you sure you want to deactivate " +
                    res.name +
                    " account?",
                icon: "question",
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: "Deactivate",
                iconColor: "#ea5455",
                willOpen: (e) => {
                    $(".swal2-actions")
                        .addClass("w-100")
                        .css("justify-content", "flex-end");
                },
            }).then((result) => {
                if (result.isDenied) {
                    $.ajax({
                        type: "POST",
                        url: "/admin/deactivateUser",
                        data: { id: userId },
                        success: (res) => {
                            userTable.ajax.reload(null, false);
                        },
                    });
                }
            });
        },
    });
});

$("#userTable").on("click", ".activateBtn", (e) => {
    let userId = $(e.currentTarget).data("id");
    $.ajax({
        type: "POST",
        url: "/admin/getUser",
        data: { id: userId },
        success: (res) => {
            $.LoadingOverlay("hide");
            Swal.fire({
                title: "Activate Account",
                text:
                    "Are you sure you want to Activate " +
                    res.name +
                    " account?",
                icon: "question",
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "Activate",
                iconColor: "#2b7d62",
                willOpen: (e) => {
                    $(".swal2-actions")
                        .addClass("w-100")
                        .css("justify-content", "flex-end");
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/admin/deactivateUser",
                        data: {
                            id: userId,
                            status: "activate",
                        },
                        success: (res) => {
                            userTable.ajax.reload(null, false);
                        },
                    });
                }
            });
        },
    });
});

let memberTable = $("#memberTable")
    .on("init.dt", function () {
        $(".dataTables_wrapper").prepend(
            "<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>"
        );
    })
    .DataTable({
        ordering: false,
        serverSide: true,
        dom: "rtip",
        columnDefs: [
            {
                targets: 0,
                width: "1%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 1,
                width: "5%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 2,
                width: "5%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 3,
                width: "20%",
                className: "text-left align-middle font-weight-bold p-2",
            },
            {
                targets: 4,
                width: "7%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 5,
                width: "10%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 6,
                width: "10%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 7,
                width: "5%",
                className: "text-center align-middle font-weight-bold p-2",
            },
        ],
        ajax: {
            url: "/admin/memberTable",
            type: "POST",
            data: function (d) {
                d.filterSearch = $("#memberfilterSearch").val();
                d.filterBranch = $("#branchFilter").val();
                d.filterStatus = $("#statusFilter").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            },
        },
    });

$("#branchFilter,#statusFilter").change((e) => {
    memberTable.draw();
});

$("#memberfilterSearch").keyup((e) => {
    memberTable.draw();
});

$("#memberSearchBtn").click((e) => {
    memberTable.draw();
});

$("#memberClearFilter").click((e) => {
    $("#branchFilter,#statusFilter,#memberfilterSearch").val("");
    memberTable.draw();
});

$("#memberAddBtn").click((e) => {
    $("#memberForm").find("input").val("");
    $("#memberForm").find("select").val("");
    $("#memberModalLabel").text("Add Member");
    $("#memberModal").modal("show");
});

$("#memberModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#memberSubmitBtn").trigger("click");
    });

$("#memberForm").submit((e) => {
    e.preventDefault();
    $.LoadingOverlay("show");
    let data = $(e.currentTarget).serializeArray();

    $.ajax({
        type: "POST",
        url: "/admin/createUpdateMember",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                $("#memberModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }
        },
    });
});

$("#memberTable").on("click", ".editBtn", (e) => {
    let memberId = $(e.currentTarget).data("id");
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "/admin/getMember",
        data: { id: memberId },
        success: (res) => {
            $.LoadingOverlay("hide");
            for (let key in res) {
                switch (key) {
                    case "member":
                        for (let member in res[key]) {
                            $("#giveawayForm")
                                .find("[name='" + member + "']")
                                .val(res[key][member]);

                            switch (member) {
                                // case "status":
                                //     if (res[key][member] == "MIGS") {
                                //         $("#giveawayModal")
                                //             .find(".modal-footer")
                                //             .find("button[type='submit']")
                                //             .attr("disabled", false);
                                //     } else {
                                //         $("#giveawayModal")
                                //             .find(".modal-footer")
                                //             .find("button[type='submit']")
                                //             .attr("disabled", true);
                                //     }
                                //     break;

                                case "shareCapitalLabel":
                                    $(".shareCapitalLabel").text(
                                        res[key][member]
                                    );
                                    break;

                                case "giftCheckLabel":
                                    $(".giftCheckLabel").text(res[key][member]);
                                    if (res[key][member] == "₱0") {
                                        $(".shareCapitalContainer")
                                            .find(".giftCheckLabel")
                                            .parent()
                                            .parent()
                                            .addClass("d-none");
                                    } else {
                                        $(".shareCapitalContainer")
                                            .find(".giftCheckLabel")
                                            .parent()
                                            .parent()
                                            .removeClass("d-none");
                                    }
                                    break;

                                case "riceLabel":
                                    $(".riceLabel").text(res[key][member]);
                                    if (res[key][member] == "0 KLS") {
                                        $(".shareCapitalContainer")
                                            .find(".riceLabel")
                                            .parent()
                                            .parent()
                                            .addClass("d-none");
                                    } else {
                                        $(".shareCapitalContainer")
                                            .find(".riceLabel")
                                            .parent()
                                            .parent()
                                            .removeClass("d-none");
                                    }
                                    break;
                            }
                        }
                        break;

                    // case "giftCheckSetup":
                    //     $(".giftCheckBreakdown").empty();
                    //     if(res.member.status == "MIGS" && res.member.giftCheck > 0){
                    //         let giftCheckList = res.giftCheckSetup;
                    //         giftCheckList.forEach(giftCheck => {
                    //             let elementName = giftCheck.description + giftCheck.amount;
                    //             let giftCheckElement = $("<div class='col-6'><label class='mb-0' for='"+elementName+"'>₱"+giftCheck.amount+"</label><div class='form-group mb-0 pb-0'><input type='number' class='form-control font-weight-bold giftCheckAmount' placeholder='0' name='"+giftCheck.description+"-"+giftCheck.amount+"' id='"+elementName+"' autocomplete='false' data-amount='"+giftCheck.amount+"'></div></div>");
                    //             $(".giftCheckBreakdown").append(giftCheckElement);
                    //         });

                    //         let totalGiftCheck = $("<div class='col-12'><label class='mb-0' for='totalGiftCheck'>Total</label><div class='form-group pb-0 mb-0'><input type='text' class='form-control font-weight-bold text-danger' placeholder='0' name='totalGiftCheck' id='totalGiftCheck' autocomplete='false' readonly></div></div>");
                    //         $(".giftCheckBreakdown").append(totalGiftCheck);

                    //         $(".giftCheckBreakdown").find(".giftCheckAmount").keyup((element) => {
                    //             let totalGiftCheck = 0;
                    //             $(".giftCheckBreakdown").find(".giftCheckAmount").each((index, childElement) => {
                    //                 let quantity = $(childElement).val();
                    //                 let amount = $(childElement).data("amount");
                    //                 let totalAmount = quantity * amount;
                    //                 totalGiftCheck = totalGiftCheck + totalAmount;
                    //             });

                    //             $("#totalGiftCheck").val("₱"+totalGiftCheck);
                    //         });
                    //     }
                    // break;
                }
            }
            // $("#calendarGiveaway").prop("checked", true);
            // if (
            //     $("#giveawayForm").find("input[name='giftcheck']").val() == 0 &&
            //     $("#giveawayForm").find("input[name='rice']").val() == 0
            // ) {
            //     $("#giveawayModal")
            //         .find(".modal-footer")
            //         .find("button[type='submit']")
            //         .attr("disabled", true);
            // }
            $("#giveawayModal").modal("show");
        },
    });
});

$("#updateShareCapitalModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#sharecapitalSubmitBtn").trigger("click");
    });

$("#memberTable").on("click", ".editShareCapital", (e) => {
    let memberId = $(e.currentTarget).data("id");
    $("#sharecapitalForm").find("input[name='id']").val(memberId);
    $("#updateShareCapitalModal").modal("show");
});

$("#updateShareCapitalModal").on("hidden.bs.modal", function (e) {
    $("#sharecapitalForm").find("input").val("");
});

$("#sharecapitalForm").submit((e) => {
    e.preventDefault();
    $.LoadingOverlay("show");
    let data = $(e.currentTarget).serializeArray();

    $.ajax({
        type: "POST",
        url: "/admin/updateShareCapital",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }

            $("#updateShareCapitalModal").modal("hide");
        },
    });
});

$("#calendarGiveaway").click((e) => {
    $("#calendarGiveaway").prop("checked", true);
});

$("#giveawayModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#giveawaySubmitBtn").trigger("click");
    });

$("#giveawayForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    data.push({
        name: "category",
        value: "sharecapital",
    });
    $.ajax({
        type: "POST",
        url: "/admin/receivedGiveaway",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: res.message,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                $("#giveawayModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    memberTable.ajax.reload(null, false);
                });
            }
        },
    });
});

let TDtable = $("#TDtable")
    .on("init.dt", function () {
        $(".dataTables_wrapper").prepend(
            "<div class='dataTables_processing card font-weight-bold d-none' role='status'>Loading Please Wait...<i class='fa fa-spinner fa-spin text-warning'></i></div>"
        );
    })
    .DataTable({
        ordering: false,
        serverSide: true,
        dom: "rtip",
        columnDefs: [
            {
                targets: 0,
                width: "1%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 1,
                width: "30%",
                className: "text-left align-middle font-weight-bold p-2",
            },
            {
                targets: 2,
                width: "15%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 3,
                width: "15%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 4,
                width: "15%",
                className: "text-center align-middle font-weight-bold p-2",
            },
            {
                targets: 5,
                width: "10%",
                className: "text-center align-middle font-weight-bold p-2",
            },
        ],
        ajax: {
            url: "/admin/timedepositTable",
            type: "POST",
            data: function (d) {
                d.filterSearch = $("#TDfilterSearch").val();
                d.filterBranch = $("#TDbranchFilter").val();
                d.filterStatus = $("#TDstatusFilter").val();
            },
            beforeSend: () => {
                $(".dataTables_processing").removeClass("d-none");
            },
            complete: () => {
                $(".dataTables_processing").addClass("d-none");
            },
        },
    });

$("#TDbranchFilter,#TDstatusFilter").change((e) => {
    TDtable.draw();
});

$("#TDfilterSearch").keyup((e) => {
    TDtable.draw();
});

$("#TDmemberSearchBtn").click((e) => {
    TDtable.draw();
});

$("#TDmemberClearFilter").click((e) => {
    $("#TDbranchFilter,#TDstatusFilter,#TDfilterSearch").val("");
    TDtable.draw();
});

$("#TDAddBtn").click((e) => {
    $("#tdMemberForm").find("input").val("");
    $("#tdMemberForm").find("select").val("");
    $("#tdMemberModalLabel").text("Add Member");
    $("#tdMemberModal").modal("show");
});

$("#tdMemberModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#tdMemberSubmitBtn").trigger("click");
    });

$("#tdMemberForm").submit((e) => {
    e.preventDefault();
    $.LoadingOverlay("show");
    let data = $(e.currentTarget).serializeArray();
    $.ajax({
        type: "POST",
        url: "/admin/addTimedepositMember",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                $("#tdMemberModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    TDtable.ajax.reload(null, false);
                });
            }
        },
    });
});

$("#TDtable").on("click", ".editBtn", (e) => {
    let id = $(e.currentTarget).data("id");
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "/admin/getTimedepositMember",
        data: { id: id },
        success: (res) => {
            $.LoadingOverlay("hide");

            let member = res.member;
            let gifts = res.member.tdGifts;

            for (const key in member) {
                $("#tdGiftsForm")
                    .find("[name='" + key + "']")
                    .val(member[key]);
            }

            for (const key in gifts) {
                $("#tdGiftsForm")
                    .find("[name='" + key + "']")
                    .val(gifts[key]);
                if (gifts.rice == 0) {
                    $("#tdGiftsForm")
                        .find(".riceLabel")
                        .parent()
                        .parent()
                        .addClass("d-none");
                } else {
                    $("#tdGiftsForm")
                        .find(".riceLabel")
                        .text(gifts.riceLabel)
                        .parent()
                        .parent()
                        .removeClass("d-none");
                }

                if (gifts.giftcheck == 0) {
                    $("#tdGiftsForm")
                        .find(".giftCheckLabel")
                        .parent()
                        .parent()
                        .addClass("d-none");
                } else {
                    $("#tdGiftsForm")
                        .find(".giftCheckLabel")
                        .text(gifts.giftcheckLabel)
                        .parent()
                        .parent()
                        .removeClass("d-none");
                }

                if (gifts.tshirt == 0) {
                    $("#tdGiftsForm")
                        .find(".tshirtLabel")
                        .parent()
                        .parent()
                        .addClass("d-none");
                } else {
                    $("#tdGiftsForm")
                        .find(".tshirtLabel")
                        .parent()
                        .parent()
                        .removeClass("d-none");
                }
            }

            $("#tdGiftsForm")
                .find("[name='timedeposit']")
                .val(member.timeDepositLabel);

            if (gifts.rice == 0 && gifts.giftcheck == 0) {
                $("#tdGiftsForm").find(".TdGiftsContainer").addClass("d-none");
                $("#tdGiftModal")
                    .find(".modal-footer")
                    .find("button[type='submit']")
                    .attr("disabled", true);
            } else {
                $("#tdGiftsForm")
                    .find(".TdGiftsContainer")
                    .removeClass("d-none");
                $("#tdGiftModal")
                    .find(".modal-footer")
                    .find("button[type='submit']")
                    .attr("disabled", false);
            }

            $("#tdGiftModal").modal("show");

            // $("#tdGiftsForm").find("input[name='id']").val(res.member.id);
            // $("#tdGiftsName").val(res.member.name);
            // $("#tdGiftsBranch").val(res.member.branch);
            // $("#tdGiftsTimedeposit").val(res.member.timeDepositLabel);

            // $("#tdGiftModal")
            //     .find(".modal-footer")
            //     .find("button[type='submit']")
            //     .attr("disabled", false)
            //     .removeClass("btn-secondary")
            //     .addClass("btn-primary");
            // $(".TdGiftsContainer").removeClass("d-none");

            // $("#tdGiftModal")
            //     .find(".TdGiftCheckBreakdownContainer")
            //     .addClass("d-none");
            // $("#tdGiftModal").find(".TdGiftCheckBreakdown").empty();

            // if (res.member.tdGifts.rice == 0) {
            //     $(".TdGiftsContainer").addClass("d-none");
            //     $("#tdGiftModal")
            //         .find(".modal-footer")
            //         .find("button[type='submit']")
            //         .attr("disabled", true)
            //         .removeClass("btn-primary")
            //         .addClass("btn-secondary");
            // } else {
            //     $(".TdGiftsBreakdown").empty();
            //     for (let tdGifts in res.member.tdGifts) {
            //         let giftValue = res.member.tdGifts[tdGifts];
            //         let label = "";
            //         switch (tdGifts) {
            //             case "rice":
            //                 label =
            //                     giftValue > 1
            //                         ? giftValue + "Kls Rice"
            //                         : giftValue + "Kl Rice";
            //                 break;

            //             case "tShirt":
            //                 label = giftValue;
            //                 break;

            //             case "giftCheckLabel":
            //                 label =
            //                     res.member.tdGifts.giftCheckLabel +
            //                     " Gift Check";
            //                 break;
            //         }

            //         if (tdGifts != "giftCheck") {
            //             let inputaData =
            //                 tdGifts != "giftCheckLabel"
            //                     ? res.member.tdGifts[tdGifts]
            //                     : res.member.tdGifts.giftCheck;
            //             let giftElement = $(
            //                 "<div class='col-6'><div class='icheck-success'><input type='checkbox' id='item-" +
            //                     tdGifts +
            //                     "' name='" +
            //                     tdGifts +
            //                     "' checked data-tdGift='" +
            //                     inputaData +
            //                     "'><label class='text-danger' for='item-" +
            //                     tdGifts +
            //                     "'>" +
            //                     label +
            //                     "</label></div></div>"
            //             );

            //             $(".TdGiftsBreakdown").append(giftElement);

            //             $("#item-" + tdGifts).click((e) => {
            //                 $("#item-" + tdGifts).prop("checked", true);
            //             });
            //         } else {
            //             $("#tdGiftModal")
            //                 .find(".TdGiftCheckBreakdownContainer")
            //                 .removeClass("d-none");
            //             let giftCheckList = res.giftCheckSetup;
            //             giftCheckList.forEach((giftCheck) => {
            //                 let elementName =
            //                     giftCheck.description + giftCheck.amount;
            //                 let giftCheckElement = $(
            //                     "<div class='col-6'><label class='mb-0' for='" +
            //                         elementName +
            //                         "'>₱" +
            //                         giftCheck.amount +
            //                         "</label><div class='form-group mb-0 pb-0'><input type='number' class='form-control font-weight-bold giftCheckAmount' placeholder='0' name='" +
            //                         giftCheck.description +
            //                         "-" +
            //                         giftCheck.amount +
            //                         "' id='" +
            //                         elementName +
            //                         "' autocomplete='false' data-amount='" +
            //                         giftCheck.amount +
            //                         "'></div></div>"
            //                 );
            //                 $(".TdGiftCheckBreakdown").append(giftCheckElement);
            //             });
            //             let totalGiftCheck = $(
            //                 "<div class='col-12'><label class='mb-0' for='TDtotalGiftCheck'>Total</label><div class='form-group pb-0 mb-0'><input type='text' class='form-control font-weight-bold text-danger' placeholder='0' name='totalGiftCheck' id='TDtotalGiftCheck' autocomplete='false' readonly></div></div>"
            //             );
            //             $(".TdGiftCheckBreakdown").append(totalGiftCheck);

            //             $(".TdGiftCheckBreakdown")
            //                 .find(".giftCheckAmount")
            //                 .keyup((element) => {
            //                     let totalGiftCheck = 0;
            //                     $(".TdGiftCheckBreakdown")
            //                         .find(".giftCheckAmount")
            //                         .each((index, childElement) => {
            //                             let quantity = $(childElement).val();
            //                             let amount =
            //                                 $(childElement).data("amount");
            //                             let totalAmount = quantity * amount;
            //                             totalGiftCheck =
            //                                 totalGiftCheck + totalAmount;
            //                         });

            //                     $("#TDtotalGiftCheck").val(
            //                         "₱" + totalGiftCheck
            //                     );
            //                 });
            //         }
            //     }
            // }
        },
    });
});

$("#updateTimeDepositModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#timedepositSubmitBtn").trigger("click");
    });

$("#TDtable").on("click", ".editTimeDeposit", (e) => {
    let memberId = $(e.currentTarget).data("id");
    $("#timedepositForm").find("input[name='id']").val(memberId);
    $("#updateTimeDepositModal").modal("show");
});

$("#updateTimeDepositModal").on("hidden.bs.modal", function (e) {
    $("#timedepositForm").find("input").val("");
});

$("#timedepositForm").submit((e) => {
    e.preventDefault();
    $.LoadingOverlay("show");
    let data = $(e.currentTarget).serializeArray();

    $.ajax({
        type: "POST",
        url: "/admin/updateTimeDeposit",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    TDtable.ajax.reload(null, false);
                });
            }

            $("#updateTimeDepositModal").modal("hide");
        },
    });
});

$("#tdGiftModal")
    .find(".modal-footer")
    .find("button[type='submit']")
    .click((e) => {
        $("#tdGiftsSubmitBtn").trigger("click");
    });

$("#tdGiftsForm").submit((e) => {
    e.preventDefault();
    let data = $(e.currentTarget).serializeArray();
    data.push({
        name: "category",
        value: "timedeposit",
    });
    $.ajax({
        type: "POST",
        url: "/admin/receivedGiveaway",
        data: data,
        success: (res) => {
            $.LoadingOverlay("hide");
            if (res.status == "failed") {
                Swal.fire({
                    title: "Oops...",
                    text: res.message,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            } else {
                $("#tdGiftModal").modal("hide");
                Swal.fire({
                    title: "Successfully Saved.",
                    icon: res.status,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    TDtable.ajax.reload(null, false);
                });
            }
        },
    });
});

$("#giveawayForm")
    .find("#giveawayStatus")
    .change((e) => {
        $.ajax({
            type: "POST",
            url: "/admin/updateMemberStatus",
            data: {
                id: $("#giveawayForm").find("input[name='id']").val(),
                status: $("#giveawayForm").find("#giveawayStatus").val(),
            },
            success: (res) => {
                $.LoadingOverlay("hide");
                if (res.status == "failed") {
                    Swal.fire({
                        title: "Oops...",
                        text: res.message,
                        icon: "error",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                } else {
                    $("#giveawayModal").modal("hide");
                    Swal.fire({
                        title: "Successfully Saved.",
                        icon: res.status,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        memberTable.ajax.reload(null, false);
                    });
                }
            },
        });
    });

$(document).ready(() => {
    let dashboardInterval;
    clearInterval(dashboardInterval);
    if ($(".tabTitle").text() == "DASHBOARD") {
        const loadDashboardData = () => {
            $.ajax({
                type: "POST",
                url: "/admin/getDashboardData",
                async: false,
                success: (res) => {
                    for (let key in res) {
                        $("." + key).text(res[key]);
                    }
                    $("#dashboardTable tbody").empty();
                    res.summaryList.forEach((summary) => {
                        let row = `<tr>
                                        <td class="text-center align-middle font-weight-bold p-2">${summary.branch}</td>
                                        <td class="text-center align-middle font-weight-bold p-2">${summary.migsReceived}</td>
                                    </tr>`;
                        $("#dashboardTable tbody").append(row);
                    });
                    let row = `<tr class="bg-primary text-white">
                                        <td class="text-center align-middle font-weight-bolder p-2">TOTAL</td>
                                        <td class="text-center align-middle font-weight-bolder p-2">${res.totalReceived}</td>
                                    </tr>`;
                    $("#dashboardTable tbody").append(row);
                },
            });
        };

        loadDashboardData();
        dashboardInterval = setInterval(() => {
            loadDashboardData();
        }, 3000);
    }
});
