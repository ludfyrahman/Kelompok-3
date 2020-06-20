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
import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Akun.Sign_Up;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Form_Rekening extends AppCompatActivity {
    EditText nama_bank, nama_rekening, no_rekening;
    Button simpan;
    ProgressDialog pd;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_rekening);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        pd = new ProgressDialog(Form_Rekening.this);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        nama_bank = findViewById(R.id.nama_bank);
        nama_rekening = findViewById(R.id.nama_rekening);
        no_rekening = findViewById(R.id.no_rekening);
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
                    nama_bank.setText(data.getString("nama_bank"));
                    nama_rekening.setText(data.getString("nama_rekening"));
                    no_rekening.setText(data.getString("no_rekening"));
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
        if (nama_rekening.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Nama Rekening Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            nama_rekening.setFocusable(true);
            pd.dismiss();
        }else if (nama_bank.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Nama Bank Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            nama_bank.setFocusable(true);
            pd.dismiss();
        }else if (no_rekening.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "No Rekening Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            no_rekening.setFocusable(true);
            pd.dismiss();
        }else{
            StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.auth+"update_rekening", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    pd.cancel();
                    try {
                        JSONObject res = new JSONObject(response);
                        Log.d("pesan", res.toString());
                        if(res.getBoolean("status") == true){
                            JSONObject r = res.getJSONObject("data");
//                            Log.d("pesan", )
                            Toast.makeText(Form_Rekening.this, res.getString("message"), Toast.LENGTH_SHORT).show();
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
                    params.put("nama_bank", nama_bank.getText().toString());
                    params.put("nama_rekening", nama_rekening.getText().toString());
                    params.put("no_rekening", no_rekening.getText().toString());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(senddata);
        }
    }
}
