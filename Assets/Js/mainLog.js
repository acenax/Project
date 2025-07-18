$('#register').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var datavalid = JSON.parse(getFormData($(this)));

    if (datavalid.username.length == 0 || datavalid.password.length == 0 || datavalid.Cpassword.length == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณากรอกให้ครบทุกช่อง',
        });
        return false;
    }

    // Add a validation check for the password field
    if (datavalid.password.length < 8) {
        Swal.fire({
            icon: 'error',
            title: 'รหัสผ่านต้องมี 8 ตัวอักษรขึ้นไป !'
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: 'Action/logReg.php',
        data: data,
        beforeSend: (e) => {
            wait();
        },
        success: (Response) => {
            let res = JSON.parse(Response);
            if (res.status == "success") {
                Toast.fire({
                    icon: 'success',
                    title: 'สมัครมาชิกเรียบร้อย !'
                })
                setTimeout((e) => {
                    window.location = './?login'
                }, 1500);
            } else {
                if (res.status == "worngPass") {
                    Swal.fire({
                        icon: 'error',
                        title: 'รหัสผ่านไม่ตรงกัน !'
                    })
                } else if (res.status == "taken") {
                    Swal.fire({
                        icon: 'error',
                        title: 'มีผู้ใช้นี้แล้ว !'
                    })
                } else if (res.status == "empty") {
                    Swal.fire({
                        icon: 'error',
                        title: 'ห้ามปล่อยข้อมูลว่าง !'
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })
                }
                setTimeout((e) => {
                    window.location = './?register'
                }, 1500);
            }
        }
    });
});


$('#login').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var datavalid = JSON.parse(getFormData($(this)));

    if (datavalid.username.length == 0 || datavalid.password.length == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณากรอกให้ครบทุกช่อง',
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: 'Action/logReg.php',
        data: data,
        beforeSend: (e) => {
            wait();
        },
        success: (Response) => {
            let res = JSON.parse(Response);
            if (res.status == "success") {
                Toast.fire({
                    icon: 'success',
                    title: 'เข้าสู่ระบบแล้ว !'
                })
                setTimeout((e) => {
                    window.location = './?Profile'
                }, 1500);
            } else if (res.status == "success_admin" || res.status == 'success_user') {
                Toast.fire({
                    icon: 'success',
                    title: 'เข้าสู่ระบบแล้ว !'
                })
                setTimeout((e) => {
                    window.location = 'admin/e-commerce'
                }, 1500);

            } else {
                if (res.status == "worngPass") {
                    Swal.fire({
                        icon: 'error',
                        title: 'รหัสเข้าใช้งานหรือรหัสผ่านไม่ถูกต้อง !'
                    })
                } else
                if (res.status == "empty") {
                    Swal.fire({
                        icon: 'error',
                        title: 'ห้ามปล่อยข้อมูลว่าง !'
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดกรุณาลองใหม่ !'
                    })
                }
                setTimeout((e) => {
                    window.location = './?login'
                }, 1500);
            }
        }
    })
})