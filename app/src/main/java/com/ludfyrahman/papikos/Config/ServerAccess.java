package com.ludfyrahman.papikos.Config;

import java.text.DecimalFormat;

public class ServerAccess {
    public static final String BASE_URL = "http://192.168.1.2/papikos-2/";
    public static final String ROOT_API = BASE_URL+"api/";
    public static final String auth = ROOT_API+"auth/";
    public static final String SIGN_UP = auth+"register";
    public static final String SIGN_IN = auth+"sign_in";
    public static final String KOS = ROOT_API+"kos/";
    public static final String COVER =BASE_URL+"assets/images/upload/";
    public static String numberConvert(String val){
        double v = Double.parseDouble(val);
        DecimalFormat formatter = new DecimalFormat("#,###,###");
        String format = formatter.format(v);
        return "Rp "+format;
    }
    public static String jenis(int index){
        String[] jenis = {"", "Laki Laki", "Perempuan"};
        return jenis[index];
    }


}
