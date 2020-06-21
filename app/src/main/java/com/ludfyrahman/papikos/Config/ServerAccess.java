package com.ludfyrahman.papikos.Config;

import java.text.DateFormat;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class ServerAccess {
    public static final String BASE_URL = "http://192.168.1.10/papikos-2/";
    public static final String ROOT_API = BASE_URL+"api/";
    public static final String auth = ROOT_API+"auth/";
    public static final String DASHBOARD = ROOT_API+"dashboard/data";
    public static final String SIGN_UP = auth+"sign_up";
    public static final String EMAIL = auth+"email";
    public static final String LUPA_PASSWORD = auth+"proses_forgot_password";
    public static final String PHONE = auth+"phone";
    public static final String SIGN_IN = auth+"sign_in";
    public static final String TRANSAKSI = ROOT_API+"transaksi/";
    public static final String KOS = ROOT_API+"kos/";
    public static final String COVER =BASE_URL+"assets/images/upload/";
    public static final String INV = "INV000";
    public static String numberConvert(String val){
        double v = Double.parseDouble(val);
        DecimalFormat formatter = new DecimalFormat("#,###,###");
        String format = formatter.format(v);
        return "Rp "+format;
    }
    public static String dateFormat(String date){
//        String date ="29/07/13";
        SimpleDateFormat input = new SimpleDateFormat("dd-MM-yyyy");
        SimpleDateFormat output = new SimpleDateFormat("yyyy-MM-dd");
        String str = null;
        try {
            Date oneWayTripDate = input.parse(date);                 // parse input
            str = output.format(oneWayTripDate);

        } catch (ParseException e) {
            e.printStackTrace();
        }
        return str;
    }
    public static String jenis(int index){
        String[] jenis = {"", "Laki Laki", "Perempuan"};
        return jenis[index];
    }
    public static String transaksi(int index){
        String[] status = {"Dibatalkan", "Dp", "Lunas", "Selesai"};
        return status[index];
    }

}
