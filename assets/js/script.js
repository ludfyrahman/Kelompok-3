$("[id='verifikasi_no_hp'").click(function(){
    $.ajax({
        type: "GET",
        url: BASEURL+"verifikasi_no_hp/+6282331759738",
        cache: false,
        success: function(data){
        //    $("#resultarea").text(data);
        console.log("success");
            $('#no_hp').modal('hide');
            $('#code_no_hp').modal('show');
        },
        error(res){
            console.log("errrror")
        }
      });
});

$("[id='rate'").click(function(){
    var val = $(this).attr("val");
    $("#rating").val(val);
    $( "[id='rate'" ).each(function( i ) {
        if(i < val){
            $(this).css("color","rgb(228, 173, 34)"); //Change color of the div
        }else{
            $(this).css("color","#777");
        }
        // console.log("works");
    });
})
$("[id='favorit']").click(function(){
    var id = $(this).attr("kosid");
    $(this).toggleClass("color-primary");
    $.ajax({
        type: "GET",
        url: BASEURL+"kos/favorit/"+id,
        cache: false,
        success: function(data){
            console.log("success ");
            console.log(data);
        },
        error(res){
            console.log("errrror")
            console.log("res");
        }
      });
});

$('.rating').on('change', function () {
   alert("Changed: " + $(this).val())
});
$(".pesan").click(function(){
   return confirm("apakah anda ingin memesan kos ini ???")
})
$(".bayar").click(function(){
   return confirm("apakah anda ingin Membayar kos ini ???")
});
$("#open_ulasan_model").click(function(){
    var id_kos = $(this).attr("id_kos");
    $('#ulasan').modal('show');
    $("#id_kos").val(id_kos);
    
    var saveData = $.ajax({
        type: 'GET',
        url: BASEURL+"/ulasan/"+id_kos,
        success: function(resultData) { 
            console.log(resultData);
            console.log(resultData);
            var obj = JSON.parse(resultData);
            var appendElement = "";
            // console.log(obj[1][0]['tanggal_ditambahkan']);
            if(obj[0] > 0){
                // hide form and show result data from review
                $('.form_ulasan').hide();
                $('.result_ulasan').show();
            }else{
                // show the form
                $('.form_ulasan').show();
                $('.result_ulasan').hide();
            }
            for (let index = 0; index < obj[1].length; index++) {
                var rat = "";
                for (let rate = 1; rate <= obj[1][index]['rating']; rate++) {
                    rat+="<i class='fa fa-star'></i>";
                }
                appendElement = "<div class='single-blog wow fadeIn res-margin' data-wow-duration='2s'>"+
                    "<div class='blog-content p-4'>"+
                        
                        "<ul class='meta-info d-flex justify-content-between'>"+
                            "<li><b>"+obj[1][index]['nama']+"</b>  "+
                            
                            rat+
                                
                        "</li>"+
                            "<li>"+obj[1][index]['tanggal_ditambahkan']+"</li>"+
                        "</ul>"+
                        "<div class='container'>"+
                            "<p>"+obj[1][index]['ulasan']+"</p>"+
                        "</div>"+
                    "</div>"+
                "</div>";                
            }
            $(".result_ulasan").append(appendElement);
        },
        error:function(res){console.log(res)}
    });
})
$("#simpan_ulasan").click(function(){
    var ulasan = $("textarea[name='ulasan']").val();
    var id_kos = $("#id_kos").val();
    var rating = $("#rating").val();
    var saveData = $.ajax({
        type: 'POST',
        url: BASEURL+"kos/ulasan",
        data: {ulasan: ulasan, id_kos:id_kos, rating:rating},
        dataType: "text",
        success: function(resultData) { 
            // console.log(resultData);
            // alert("berhasil menambahkan ulasan");
            $('#ulasan').modal('hide');
            window.location.reload();
        },
        error:function(res){console.log(res)}
  });
})
$("#btn_simpan_data_diri").click(function(){
    // alert();
    // console.log($("#data_diri").serialize(),)
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/;
    var nama = $('input[name="nama"').val();
    var email = $('input[name="email"').val();
    var no_hp = $('input[name="no_hp"').val();
    var tanggal_lahir = $('input[name="tanggal_lahir"').val();
    var alamat = $('textarea[name="alamat"').val();
    var jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val();
    var saveData = $.ajax({
        type: 'POST',
        url: BASEURL+"pengguna/simpanProfil",
        data: {nama: nama, email:email, no_hp:no_hp, tanggal_lahir:tanggal_lahir, alamat:alamat, jenis_kelamin:jenis_kelamin},
        dataType: "text",
        success: function(resultData) { 
            console.log(resultData);
            // alert("berhasil mengubah profil");
            // $('#akun').modal('hide');
        },
        error:function(res){console.log(res)}
  });
})
$("#btn_simpan_data_rekening").click(function(){
    var userinput = $(this).val();
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    var nama_bank = $('input[name="nama_bank"').val();
    var nama_rekening = $('input[name="nama_rekening"').val();
    var no_rekening = $('input[name="no_rekening"').val();
    var saveData = $.ajax({
        type: 'POST',
        url: BASEURL+"pengguna/simpanRekening",
        data: {nama_bank: nama_bank, nama_rekening:nama_rekening, no_rekening:no_rekening},
        dataType: "text",
        success: function(resultData) { 
            alert("berhasil mengubah data rekening");
            $('#akun').modal('hide');
        },
        error:function(res){console.log(res)}
  });
})
$("#btn-proses-verifikasi-email").click(function(){
     var kode = $("#verification_email_code").val();
     var saveData = $.ajax({
        type: 'POST',
        url: BASEURL+"pengguna/proses_verifikasi/email",
        data: {verification_code: kode},
        dataType: "text",
        success: function(resultData) {
            console.log(resultData);
            var obj = JSON.parse(resultData);
            console.log(obj['status']);
            if(obj['status']){
                alert("berhasil Verifikasi Email");
                $('#code_email').modal('hide');
                window.location.reload();
            }else{
                alert("Verifikasi Email Gagal. masukkan kode yang benar");
            }
        },
        error:function(res){console.log(res)}
    });
})
$("#btn-proses-verifikasi-nohp").click(function(){
    var kode = $("#verification_nohp_code").val();
    var saveData = $.ajax({
       type: 'POST',
       url: BASEURL+"pengguna/proses_verifikasi/nohp",
       data: {verification_code: kode},
       dataType: "text",
       success: function(resultData) {
           console.log(resultData);
           var obj = JSON.parse(resultData);
           console.log(obj['status']);
           if(obj['status']){
               alert("berhasil Verifikasi NoHp");
               $('#code_no_hp').modal('hide');
               window.location.reload();
           }else{
               alert("Verifikasi No Hp Gagal. masukkan kode yang benar");
           }
       },
       error:function(res){console.log(res)}
   });
})
function thisFileUpload() {
    document.getElementById("foto").click();
};
function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
            // console.log(e.target.result);
            $('#profile').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      upload(input.files[0]);
    }
}
function upload(foto){
    var myFormData = new FormData();
    myFormData.append('foto', foto);
      var saveData = $.ajax({
            type: 'POST',
            url: BASEURL+"pengguna/uploadFotoProfil",
            processData: false, // important
            contentType: false, // important
            dataType : 'json',
            data: myFormData,
            success: function(resultData) { 
                alert("berhasil mengubah Foto Profil");
            },
            error:function(res){console.log(res)}
    });
}
$("#foto").change(function(){
    readURL(this);
})
$("#verifikasi_email").click(function(){
    // alert();
    $.ajax({
        type: "GET",
        url: BASEURL+"verifikasi_email/primaitech17@gmail.com/"+"ludfyr@gmail.com",
        cache: false,
        success: function(data){
        //    $("#resultarea").text(data);
        console.log("success");
            $('#email').modal('hide');
            $('#code_email').modal('show');
        },
        error(res){
            console.log("errrror")
        }
      });
});


var formData = new FormData();
var id_pemesanan = $("#id_pemesanan").val();
var bayar = $("#bayar").val();
var status = $("#status").val();
// alert(dp);
Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone", {
  addRemoveLinks: true,
  url: BASEURL+"/bayar/uploadBukti/"+id_pemesanan,
  maxFiles:1,
  method :"POST",
  paramName: 'file',
  params: {
        bayar: bayar,
        status: status
    },
  clickable: true,
  uploadMultiple: false,
  autoProcessQueue: false,
  dictDefaultMessage: 'Unggah file anda disini',
  success: function(file, response)
    {
        var obj = JSON.parse(response);
        console.log(file);
        console.log(response);
        if(obj['status']){
            alert('berhasil membayar kos');
            window.location.href = BASEURL+"transaksi";
        }else{
            alert('Gagal membayar kos');
            window.location.reload();
        }
        
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
  accept: function(file, done) {
        if (file.type != "image/jpeg" && file.type != "image/png" && file.type != "image/jpg") {
            
            if(file.type != "video/mp4"){
                done("Error! video yang anda unggah tidak diijinkan");
            }else if(file.type == "video/mp4"){
                done();
            }else{
                done("Error! gambar yang anda unggah tidak diijinkan");
            }
        }
        
        done();
    },
  init: function() {
   //  this.on("addedfile", function(file) {
   //      console.log(file);
   //      formData.append("file", file); 
   //  });
   this.on("error", function(file, response) {
        // do stuff here.
        alert(response);

    });
   this.on("maxfilesexceeded", function(file){
         alert("No more files please!");
   });
    this.on("removedfile", function(file) { 
        formData.delete('file');
      });
  }   
});
$(".konfirmasi").click(function(){
    //    return confirm("apakah anda yakin ingin Membayar Dp kos ini ???")
    //    console.log("kode "+BASEURL+"/bayar/uploadBukti/"+id_pemesanan);
        myDropzone.processQueue();
    })