$(".btn-edit").click(function (e) {
    const Ma_so = this.getAttribute('data-bs-Ma_so')
    console.log(Ma_so);
    $("#Edit input[name='Ma_so']").val(Ma_so);
    const Dia_chi = this.getAttribute('data-bs-Dia_chi')
    $("#Edit input[name='Dia_chi']").val(Dia_chi);
    const Ngay_sinh = this.getAttribute('data-bs-Ngay_sinh')
    $("#Edit input[name='Ngay_sinh']").val(Ngay_sinh);
    const Ma_chi_nhanh = this.getAttribute('data-bs-Ma_chi_nhanh')
    $("#Edit input[name='Ma_chi_nhanh']").val(Ma_chi_nhanh);
    const SDT = this.getAttribute('data-bs-SDT')
    $("#Edit input[name='SDT']").val(SDT);
    const Email = this.getAttribute('data-bs-Email')
    $("#Edit input[name='Email']").val(Email);
    $('#Edit').modal('show');
});


$(".btn-delete").click(function (e) {
    const Ma_so = this.getAttribute('data-bs-Ma_so')
    //console.log(username);
    $("#Delete input[name='Ma_so']").val(Ma_so);
    $('#Delete').modal('show');
});
$(document).ready(function () {
    $('#tab-user').DataTable();
});