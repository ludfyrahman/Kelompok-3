


<!DOCTYPE html>
<html lang="id">

<head>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- new change -->
    <style>
        @media print {
            #action-area {
                display: none;
            }
        }

        @media screen and (max-width: 1024px) {
            .content-area > div {
                width: auto !important; 
            }
        }

        @media screen and (max-width: 720px) {
            .content-area {
                transform: scale(0.5) translate(-46%, -51%);
            }
            .content-area > div {
                width: auto !important; 
            }
        }

        @media screen and (max-width: 420px) {
            .content-area > div {
                width: 790px !important; 
            }
        }
        @media screen and (max-width: 380px) {
            .content-area {
                transform: scale(0.45) translate(-59%, -63%);
            }
            .content-area > div {
                width: 790px !important;
            }
        }
        @media screen and (max-width: 320px) {
            .content-area > div {
                width: 700px !important;
            }
        }
    </style>
    <!-- end new change -->

</head>

<body style="font-family: open sans, tahoma, sans-serif; margin: 0; -webkit-print-color-adjust: exact">
    
    <div id="action-area">
        <div id="navbar-wrapper"
            style="text-align: right; padding: 12px 16px;border-bottom: 1px solid #E0E0E0;margin-bottom: 16px;font-size: 12px;line-height: 1.4;">
            <a href="javascript:window.print()" style="height: 100%; display: inline-block;">
                <button id="print-button"
                    style="border: none; height: 100%; cursor: pointer;padding: 8px 40px;border-color: #03AC0E;border-radius: 8px;background-color: #03AC0E;margin-left: 16px;color: #fff;font-size: 12px;line-height: 1.333;font-weight: 700;">Cetak</button>
            </a>
        </div>
    </div>
    
    
    <div class="content-area">
        <!-- <div style="background: url(https://ecs7.tokopedia.net/img/invoice/paid-stamp.png) center no-repeat; background-size: contain; margin: auto; width: 790px;"> -->
        <div style=" margin: auto; width: 790px;">
        
            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding: 25px 32px; color: #343030;">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" style="padding-bottom: 20px; border-bottom: thin dashed #cccccc;">
                            <tr>
                                <td style="width: 57%; vertical-align: top;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td colspan="2">
                                                <img src="<?= BASEASSET."images/logo.png" ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 14px;">
                                                <span style="font-weight: 600">Nomor Invoice</span> : <span style="color: #42b549; font-weight: 600;"><?= invoice_code."".$data['id'] ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 12px; padding: 8px 0;">
                                                Diterbitkan atas nama:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-weight: 600; padding-bottom: 6px; width: 80px;">
                                                Pemilik Kos
                                            </td>
                                            <td style="font-size: 12px; padding-bottom: 6px;">
                                                <b><?= $data['nama_pemilik'] ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-weight: 600; padding-bottom: 6px; width: 80px;">Tanggal</td>
                                            <td style="font-size: 12px; padding-bottom: 6px;"><?= $data['tanggal_pemesanan'] ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 43%; vertical-align: top; padding-left: 30px;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-weight: 600; font-size: 14px;padding-bottom: 8px;">Pemesan Kos:</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; padding-bottom: 20px;">
                                                <span style="margin-bottom: 3px; font-weight: 600; display: block;"><?= $data['nama'] ?></span>
                                                <div>
                                                    <?= $data['alamat'] ?><br>                                                
                                                    <?= $data['no_hp'] ?>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" style="border: thin dashed rgba(0, 0, 0, 0.34); border-radius: 4px; color: #343030; margin-top: 20px;">
                            <tr style="background-color: rgba(242, 242, 242, 0.74); font-size: 14px; font-weight: 600;">
                                <td style="padding: 10px 15px;">Nama Kos</td>
                                <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">Harga</td>
                                <td style="padding: 10px 15px; text-align: right;">Subtotal</td>
                            </tr>
                            <tr style="font-size: 14px;">
                                <td width="330" style="padding: 15px; font-weight: 600; word-break: break-word;">
                                    <a href="<?= BASEURL."kos/detail/".$data['id_kos'] ?>"><?= $data['nama_kos'] ?></a>
                                </td>
                                <td valign="top" style="padding: 15px; white-space: nowrap; text-align: center;">
                                    <?= Response_Helper::price($data['harga']) ?>
                                </td>
                                <td valign="top" style="padding: 15px; white-space: nowrap;text-align:right">
                                    <?= Response_Helper::price($data['harga']) ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="padding: 0 15px;">
                                    <div style="border-bottom: thin solid #e0e0e0"></div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="4">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="padding-right: 15px; font-size: 14px; font-weight: 600;">
                                        <tr>
                                            <td colspan="2">
                                                <div style="border-bottom: thin solid #e0e0e0"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 15px;">Subtotal Harga</td>
                                            <td style="padding: 15px 0 15px 15px; text-align: right;"><?= Response_Helper::price($data['harga']) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- refactor div float left and right in case order is kelontong -->
                <tr>
                    <td>
                        <div id="container_invoice_qr"  style="float:left; font-weight: bold;
                                    margin-top:20px;">
                            
                        </div>
                        <?php 
                        
                        $dp = 20 / 100 * $data['harga'];
                        ?>
                        <div style="float:right;">
                            <table>
                                <!-- subtotal ongkir -->
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 50%;"></td>
                                                <td style="width: 50%;">
                                                    <table width="100%" style="width: 430px; margin-top: 15px; padding: 15px; border-radius: 4px; border: thin dashed #cccccc; font-size: 14px; font-weight: 600;">
                                                        <tr style="font-weight: normal; font-size: 12px;">
                                                            <td style="padding-bottom: 10px;">Dp Kos</td>
                                                            <td style="padding-bottom: 10px;text-align: right; white-space: nowrap; vertical-align: top;"><?= Response_Helper::price($dp) ?></td>
                                                        </tr>
                                                        <!-- show this in invoice section subtotal ongkos kirim -->
                                                        
                                                        <tr>
                                                            <td style="border-top: thin solid #e0e0e0; padding-top: 10px;">Subtotal Dp</td>
                                                            <td style="border-top: thin solid #e0e0e0; padding-top: 10px; text-align: right; white-space: nowrap;"><?= Response_Helper::price($dp) ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- subtotal biaya lain -->
                                
            
                                <!-- total belanja -->
                                
            
                                <!-- subtotal nilai tukar tambah -->
                                
                    
            
                                <!-- subtotal nilai promo -->
                                
            
                                <!-- total invoice -->
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 50%;"></td>
                                                <td  style="width: 50%;">
                                                    <table width="100%" style="width: 430px; margin-top: 15px; padding: 15px; border-radius: 4px; border: thin solid rgba(0, 0, 0, 0.54); font-size: 14px; font-weight: 600;">
                                                        <tr>
                                                            <td>Sisa Pembayaran</td>
                                                            <td style="text-align: right;"><?= Response_Helper::price($data['harga'] - $dp) ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    
                                <!-- Keterangan -->
                                
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<script type="text/javascript" >var _cf = _cf || []; _cf.push(['_setFsp', true]); _cf.push(['_setBm', true]); _cf.push(['_setAu', '/assets/f841b9a915534e653eec9a7dc4f1']);</script><script type="text/javascript"  src="/assets/f841b9a915534e653eec9a7dc4f1"></script></body>

<script type="text/javascript">
    jQuery(document).ready(function(event) {

        var qrcode = new QRCode("invoice_qr", {
            text: "",
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        $('#invoice_qr').on('contextmenu', 'img', function(e){ 
            return false; 
        });     
    });
 </script>
</html>