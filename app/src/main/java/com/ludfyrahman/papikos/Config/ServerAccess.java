package com.ludfyrahman.papikos.Config;

import java.text.DecimalFormat;

public class ServerAccess {
    public static final String BASE_URL = "http://192.168.1.11/papikos-2/";
    public static final String ROOT_API = BASE_URL+"api/";
    public static final String auth = ROOT_API+"Auth/";
    public static final String REGISTER = auth+"register";
    public static final String SIGN_IN = auth+"sign_in";
    public static final String PRODUK =ROOT_API+"produk/";
    public static final String BARANG =ROOT_API+"barang/";
    public static final String USAHA =ROOT_API+"usaha/";
    public static final String HEWAN =ROOT_API+"hewan/";
    public static final String KATEGORI_BARANG =ROOT_API+"barang/kategori";
    public static final String KATEGORI_USAHA =ROOT_API+"usaha/kategori";
    public static final String KATEGORI_HEWAN =ROOT_API+"hewan/kategori";
    public static final String EVENT =ROOT_API+"event/";
    public static final String COVER =BASE_URL+"public/assets/img/";
    public static String numberConvert(String val){
        double v = Double.parseDouble(val);
        DecimalFormat formatter = new DecimalFormat("#,###,###");
        String format = formatter.format(v);
        return "Rp "+format;
    }
    public static String coverDirectory(String foto, String id, String type){
        if (type.equals("barang")){
            return COVER+"/"+type+"/"+id +"/"+foto;
        }else{
            return COVER+"/"+type+"/"+foto;
        }

    }

}
