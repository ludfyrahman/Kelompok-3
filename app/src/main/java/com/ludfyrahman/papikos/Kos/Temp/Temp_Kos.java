package com.ludfyrahman.papikos.Kos.Temp;

import android.content.Context;
import android.content.SharedPreferences;

public class Temp_Kos {
    private static Temp_Kos mInstance;
    private static Context mCtx;
    private static final String SHARED_PREF_NAME = "prefKos";
    private static final String kategori = "kategori";
    private static final String cari = "cari";
    private static final String tipe = "tipe";
    private static final String urut = "urut";
    private static final String harga = "harga";
    private static final String harga_tertinggi = "harga_tertinggi";
    private Temp_Kos(Context context){
        mCtx = context;
    }
    public static synchronized Temp_Kos getInstance(Context context){
        if (mInstance == null){
            mInstance = new Temp_Kos(context);
        }
        return mInstance;
    }
    public boolean isExist() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        if (sharedPreferences.getString(kategori, null) != null) {
            return true;
        }
        return false;
    }
    public boolean setKategori(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(kategori, val);
        editor.apply();

        return true;
    }
    public static String getKategori() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(kategori, "");
    }
    public static String getCari() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(cari, "");
    }
    public boolean setCari(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(cari, val);
        editor.apply();

        return true;
    }
    public static String getTipe() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(tipe, "");
    }
    public boolean setTipe(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(tipe, val);
        editor.apply();

        return true;
    }
    public static String getUrut() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(urut, "");
    }
    public boolean setUrut(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(urut, val);
        editor.apply();

        return true;
    }
    public static String getHarga() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(harga, "");
    }
    public boolean setHarga(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(harga, val);
        editor.apply();

        return true;
    }
    public static String getHarga_tertinggi() {
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);

        return sharedPreferences.getString(harga_tertinggi, "");
    }
    public boolean setHarga_tertinggi(String val){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();

        editor.putString(harga_tertinggi, val);
        editor.apply();

        return true;
    }
    public boolean clear(){
        SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.clear();
        editor.apply();
        return true;
    }
}
