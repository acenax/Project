$("#save_profile").submit(function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  var datavalid = JSON.parse(getFormData($(this)));

  if (
    datavalid.fname.length == 0 ||
    datavalid.lname.length == 0 ||
    datavalid.phone.length == 0 ||
    datavalid.email.length == 0
  ) {
    Swal.fire({
      icon: "warning",
      title: "กรุณากรอกให้ครบทุกช่อง",
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "Action/user.php",
    data: data,
    beforeSend: (e) => {
      wait();
    },
    success: (Response) => {
      let res = JSON.parse(Response);
      if (res.status == "success") {
        Toast.fire({
          icon: "success",
          title: "บันทึกข้อมูลสำเร็จ !",
        });
        setTimeout((e) => {
          window.location = "./?Profile";
        }, 1500);
      } else {
        if (res.status == "worngPass") {
          Swal.fire({
            icon: "error",
            title: "รหัสเข้าใช้งานหรือรหัสผ่านไม่ถูกต้อง !",
          });
        } else if (res.status == "empty") {
          Swal.fire({
            icon: "error",
            title: "ห้ามปล่อยข้อมูลว่าง !",
          });
        } else if (res.status == "password_mismatch") {
          Swal.fire({
            icon: "error",
            title: "รหัสผ่านไม่ตรงกัน !",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาดกรุณาลองใหม่ !",
          });
        }
        setTimeout((e) => {
          window.location = "./?Profile";
        }, 1500);
      }
    },
  });
});

$("#save_address").submit(function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  var datavalid = JSON.parse(getFormData($(this)));

  if (
    datavalid.userAddress_number.length == 0 ||
    datavalid.userAddress_group.length == 0 ||
    datavalid.userAddress_alley.length == 0 ||
    datavalid.userAddress_separate.length == 0 ||
    datavalid.userAddress_district.length == 0 ||
    datavalid.userAddress_canton.length == 0 ||
    datavalid.userAddress_province.length == 0 ||
    datavalid.userAddress_post.length == 0
  ) {
    Swal.fire({
      icon: "warning",
      title: "กรุณากรอกให้ครบทุกช่อง",
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "Action/user.php",
    data: data,
    beforeSend: (e) => {
      wait();
    },
    success: (Response) => {
      let res = JSON.parse(Response);
      if (res.status == "success") {
        Toast.fire({
          icon: "success",
          title: "บันทึกข้อมูลสำเร็จ !",
        });
        setTimeout((e) => {
          window.location = "./?Address";
        }, 1500);
      } else {
        if (res.status == "worngPass") {
          Swal.fire({
            icon: "error",
            title: "รหัสเข้าใช้งานหรือรหัสผ่านไม่ถูกต้อง !",
          });
        } else if (res.status == "empty") {
          Swal.fire({
            icon: "error",
            title: "ห้ามปล่อยข้อมูลว่าง !",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาดกรุณาลองใหม่ !",
          });
        }
        setTimeout((e) => {
          window.location = "./?Address";
        }, 1500);
      }
    },
  });
});

function getAddress(id) {
  $.ajax({
    type: "POST",
    url: "Action/user.php",
    data: {
      action: "getAddr",
      id: id,
    },
    success: function (response) {
      let res = JSON.parse(response);
      $("#edituserAddress_number").val(res.msg.userAddress_number);
      $("#edituserAddress_group").val(res.msg.userAddress_group);
      $("#edituserAddress_alley").val(res.msg.userAddress_alley);
      $("#edituserAddress_separate").val(res.msg.userAddress_separate);
      $("#district").val(res.msg.userAddress_district);
      $("#amphoe").val(res.msg.userAddress_canton);
      $("#province").val(res.msg.userAddress_province);
      $("#zipcode").val(res.msg.userAddress_post);
      $("#addrid").val(res.msg.userAddress_id);

      $("#editAddrModal").modal("show");
    },
  });
}

$("#edit_address").submit(function (e) {
  e.preventDefault();
  var data = $(this).serialize();
  var datavalid = JSON.parse(getFormData($(this)));

  if (
    datavalid.userAddress_number.length == 0 ||
    datavalid.userAddress_group.length == 0 ||
    datavalid.userAddress_alley.length == 0 ||
    datavalid.userAddress_separate.length == 0 ||
    datavalid.userAddress_district.length == 0 ||
    datavalid.userAddress_canton.length == 0 ||
    datavalid.userAddress_province.length == 0 ||
    datavalid.userAddress_post.length == 0
  ) {
    Swal.fire({
      icon: "warning",
      title: "กรุณากรอกให้ครบทุกช่อง",
    });
    return false;
  }

  $.ajax({
    type: "POST",
    url: "Action/user.php",
    data: data,
    beforeSend: (e) => {
      wait();
    },
    success: (Response) => {
      let res = JSON.parse(Response);
      if (res.status == "success") {
        Toast.fire({
          icon: "success",
          title: "บันทึกข้อมูลสำเร็จ !",
        });
        setTimeout((e) => {
          window.location = "./?Address";
        }, 1500);
      } else {
        if (res.status == "worngPass") {
          Swal.fire({
            icon: "error",
            title: "รหัสเข้าใช้งานหรือรหัสผ่านไม่ถูกต้อง !",
          });
        } else if (res.status == "empty") {
          Swal.fire({
            icon: "error",
            title: "ห้ามปล่อยข้อมูลว่าง !",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาดกรุณาลองใหม่ !",
          });
        }
        setTimeout((e) => {
          window.location = "./?Address";
        }, 1500);
      }
    },
  });
});
