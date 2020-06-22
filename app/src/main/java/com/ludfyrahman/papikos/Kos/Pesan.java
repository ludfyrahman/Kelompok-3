package com.ludfyrahman.papikos.Kos;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Transaksi;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

public class Pesan  extends BottomSheetDialogFragment {
    TextView nama, harga, alamat, jumlah_pembayaran, no_hp, rekening;
    ImageView cover;
    Button pesan;
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.activity_pesan, container, false);
        nama = v.findViewById(R.id.nama);
        harga = v.findViewById(R.id.harga);
        alamat = v.findViewById(R.id.alamat);
        cover = v.findViewById(R.id.cover);
        jumlah_pembayaran = v.findViewById(R.id.jumlah_pembayaran);
        no_hp = v.findViewById(R.id.no_hp);
        rekening = v.findViewById(R.id.rekening);
        pesan = v.findViewById(R.id.pesan);
        pesan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                pesan(getArguments().getString("kode"), getArguments().getString("type"));
            }
        });
        loadJson();
        return v;
    }
    private void loadJson()
    {
//        final Intent data = getIntent();
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.KOS+"detail/"+getArguments().getString("kode")+"/"+getArguments().getString("type"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    nama.setText(data.getString("nama_kos"));
                    no_hp.setText(data.getString("no_hp"));
                    rekening.setText(data.getString("nama_bank")+" "+data.getString("no_rekening") + " ("+data.getString("nama")+")");
                    harga.setText(ServerAccess.numberConvert(data.getString("harga")));
                    double tagihan = data.getDouble("harga") * 0.25;
                    jumlah_pembayaran.setText(ServerAccess.numberConvert(Double.toString(tagihan)));
                    JSONArray arr = data.getJSONArray("media");
                    JSONObject d = arr.getJSONObject(0);
                    Glide.with(getActivity())
                            .load(ServerAccess.COVER+"kos/"+d.getString("link_media"))
                            .into(cover);
                    Geocoder geocoder = new Geocoder(getContext(), Locale.getDefault());
                    List<Address> addresses = geocoder.getFromLocation(data.getDouble("latitude"), data.getDouble("longitude"), 1);
                    String cityName = addresses.get(0).getAddressLine(0);
                    alamat.setText(cityName);
                } catch (JSONException | IOException e) {
                    e.printStackTrace();
                }
            }
        },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("volley", "errornya : " + error.getMessage());
                    }
                });
        AppController.getInstance().addToRequestQueue(senddata);
    }
    private void pesan(String kode, String type)
    {
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.PESAN+"detail/"+kode+"/"+type+"/"+ AuthData.getInstance(getContext()).getId_user(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    if(res.getBoolean("status")){
                        Toast.makeText(getContext(), res.getString("message"), Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(getContext(), Transaksi.class));
                    }else{
                        Toast.makeText(getContext(), res.getString("message"), Toast.LENGTH_SHORT).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("volley", "errornya : " + error.getMessage());
                    }
                });
        AppController.getInstance().addToRequestQueue(senddata);
    }
}
