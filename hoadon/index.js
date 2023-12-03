$(".btn-delete").click(function (e) {
    const So_hoa_don = this.getAttribute('data-bs-So_hoa_don')
    console.log(So_hoa_don);
    $("#Delete input[name='So_hoa_don']").val(So_hoa_don);
    $('#Delete').modal('show');
});
$(document).ready(function () {
    $('#tab-prod').DataTable();
});


$(document).ready(function () {
        // Handle click event for the button with class btn-Save
    $(".btn-Submit").click(function () {
            // Submit the form using the POST method
        $("#frmEdit").submit();
    });
});


$(document).ready(function () {
    // Handle click event for the button with class btn-Save
$(".btn-Save").click(function () {
        // Submit the form using the POST method
    $("#frmCreate").submit();
});
});

$(document).ready(function () {
    // Handle click event for the button with class btn-Save
$(".btn-Buy").click(function () {
        // Submit the form using the POST method
    $("#frmBuy").submit();
});
});


$(document).ready(function () {
    $(".sortable").click(function () {
        var column = $(this).data("column");
        var order = $(this).hasClass("asc") ? "desc" : "asc";

        // Loại bỏ lớp sắp xếp từ tất cả các tiêu đề cột
        $(".sortable").removeClass("asc desc");

        // Thêm lớp sắp xếp cho cột được nhấp và xác định thứ tự
        $(this).addClass(order);

        // Thêm/làm mới biểu tượng sắp xếp
        $(".fa-sort").removeClass("asc desc");
        $(".fa-sort", this).addClass(order);

        // Sắp xếp dữ liệu
        sortTable(column, order);
    });
});


function sortTable(column, order) {
    var tbody = $("#tab-prod tbody");
    var rows = tbody.find("tr").get();

    rows.sort(function (a, b) {
        var aValue = $(a).find("td:eq(" + getColumnIndex(column) + ")").text();
        var bValue = $(b).find("td:eq(" + getColumnIndex(column) + ")").text();

        // Sắp xếp dữ liệu theo thứ tự từ nhỏ đến lớn hoặc lớn đến nhỏ
        if (order === "asc") {
            return $.isNumeric(aValue) && $.isNumeric(bValue) ? aValue - bValue : aValue.localeCompare(bValue);
        } else {
            return $.isNumeric(aValue) && $.isNumeric(bValue) ? bValue - aValue : bValue.localeCompare(aValue);
        }
    });

    // Đặt lại các hàng đã sắp xếp vào tbody
    tbody.empty();
    $.each(rows, function (index, row) {
        tbody.append(row);
    });
}

$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        var searchText = $(this).val().toLowerCase();
        var searchColumn = $("#searchColumn").val();

        $("#tab-prod tbody tr").filter(function () {
            var textToSearch = $(this).find("td:eq(" + getColumnIndex(searchColumn) + ")").text().toLowerCase();
            $(this).toggle(textToSearch.indexOf(searchText) > -1);
        });
    });
});

function NFname(columnName) {
    return columnName.toLowerCase().replace(/đ/g, "d").normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/\s+/g, "_");
}


function getColumnIndex(columnName) {
    var columnIndex = -1;
    $("#tab-prod thead th").each(function (index) {
        var normalizedText = NFname($(this).text().trim().toLowerCase());
        console.log("normalized text:", normalizedText);
        console.log("col name:", columnName.toLowerCase());
        if (normalizedText === columnName.toLowerCase()) {
            columnIndex = index;
            return false; // Dừng vòng lặp khi tìm thấy chỉ số cột
        }
    });
    console.log("Column Index:", columnIndex);
    return columnIndex;
}


        


        
        

