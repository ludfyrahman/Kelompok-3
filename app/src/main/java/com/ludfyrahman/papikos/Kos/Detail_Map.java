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
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Config.SliderUtils;
import com.ludfyrahman.papikos.Config.slider.ViewPagerAdapter;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Ulasan.Model.Ulasan_Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.List;
import java.util.Locale;

public class Detail_Map extends BottomSheetDialogFragment {
    TextView nama, harga, alamat;
    ImageView cover;
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.detail_map, container, false);
        nama = v.findViewById(R.id.nama);
        harga = v.findViewById(R.id.harga);
        alamat = v.findViewById(R.id.alamat);
        cover = v.findViewById(R.id.cover);
        loadJson();
        return v;
    }
    private void loadJson()
    {
//        final Intent data = getIntent();
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.KOS+"detail/"+getArguments().getString("id"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    nama.setText(data.getString("nama_kos"));
                    harga.setText(ServerAccess.numberConvert(data.getString("harga")));
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
}
