package com.ludfyrahman.papikos.Akun.Pengaturan;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Ubah_Biodata extends AppCompatActivity {
    EditText nama, email, jenis_kelamin, telepon, tanggal_lahir, alamat;
    ProgressDialog pd;
    Button simpan;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ubah_biodata);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        pd = new ProgressDialog(Ubah_Biodata.this);
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
        simpan = findViewById(R.id.simpan);
        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                simpan();
            }
        });
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
//                    jenis_kelamin.setText(ServerAccess.jenis(data.getInt("jenis_kelamin")));
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
    private void simpan(){
        pd.setMessage("Proses...");
        pd.setCancelable(false);
        pd.show();
        if (nama.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Nama  Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            nama.setFocusable(true);
            pd.dismiss();
        }else if (email.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Email Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            email.setFocusable(true);
            pd.dismiss();
        }else if (telepon.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "No Hp Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            telepon.setFocusable(true);
            pd.dismiss();
        }else if (alamat.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Alamat Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            alamat.setFocusable(true);
            pd.dismiss();
        }else if (tanggal_lahir.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Tanggal Lahir Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            tanggal_lahir.setFocusable(true);
            pd.dismiss();
        }else{
            StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.auth+"update_profile", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    pd.cancel();
                    try {
                        JSONObject res = new JSONObject(response);
                        Log.d("pesan", res.toString());
                        if(res.getBoolean("status") == true){
                            Toast.makeText(Ubah_Biodata.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                            finish();
                            Intent intent = new Intent(getBaseContext(), Data_Diri.class);
                            startActivity(intent);
                        }else{
                            Toast.makeText(getBaseContext(), res.getString("message"), Toast.LENGTH_SHORT).show();
                        }
                        pd.dismiss();

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    pd.cancel();

                    Log.e("errornyaa ", "" + error);
                    Toast.makeText(getBaseContext(), "Gagal Login, "+error, Toast.LENGTH_SHORT).show();


                }
            }){
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();
                    params.put("id", AuthData.getInstance(getBaseContext()).getId_user());
                    params.put("nama", nama.getText().toString());
                    params.put("email", email.getText().toString());
                    params.put("jenis_kelamin", jenis_kelamin.getText().toString());
                    params.put("no_hp", telepon.getText().toString());
                    params.put("tanggal_lahir", tanggal_lahir.getText().toString());
                    params.put("alamat", alamat.getText().toString());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(senddata);
        }
    }
}
