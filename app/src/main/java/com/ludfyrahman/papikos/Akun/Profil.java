package com.ludfyrahman.papikos.Akun;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Config.SliderUtils;
import com.ludfyrahman.papikos.Config.slider.ViewPagerAdapter;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Ulasan.Model.Ulasan_Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class Profil extends AppCompatActivity {
    TextView nama, email, jenis_kelamin, telepon, tanggal_lahir, alamat;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profil);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        nama = findViewById(R.id.nama);
        email = findViewById(R.id.email);
        jenis_kelamin = findViewById(R.id.jenis_kelamin);
        telepon = findViewById(R.id.telepon);
        tanggal_lahir = findViewById(R.id.tanggal_lahir);
        alamat = findViewById(R.id.alamat);
        loadJson();
    }
    private void loadJson()
    {
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.auth+"info", new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    nama.setText(data.getString("nama"));
                    email.setText(data.getString("email"));
                    jenis_kelamin.setText(ServerAccess.jenis(data.getInt("jenis_kelamin")));
                    telepon.setText(data.getString("no_hp"));
                    tanggal_lahir.setText(data.getString("tanggal_lahir"));
                    alamat.setText(data.getString("alamat"));


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
                }){
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<String, String>();
                headers.put("Authorization", AuthData.getInstance(getBaseContext()).getToken());
                return headers;
            }
        };
        AppController.getInstance().addToRequestQueue(senddata);
    }
}
