package com.ludfyrahman.papikos.Akun;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Dashboard.Dashboard;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Sign_Up extends AppCompatActivity {
    TextView nama, email, password, password_konfirmasi, masuk;
    Button daftar;
    ProgressDialog pd;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        pd = new ProgressDialog(Sign_Up.this);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        masuk = findViewById(R.id.masuk);
        masuk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Sign_In.class));
            }
        });
        daftar = findViewById(R.id.daftar);
        daftar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                simpan();
            }
        });
        nama = findViewById(R.id.nama);
        email = findViewById(R.id.email);
        password = findViewById(R.id.password);
        password_konfirmasi = findViewById(R.id.password_konfirmasi);
    }
    private void simpan(){
        pd.setMessage("Proses...");
        pd.setCancelable(false);
        pd.show();
        if (nama.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Nama Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            nama.setFocusable(true);
            pd.dismiss();
        }else if (email.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Email Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            email.setFocusable(true);
            pd.dismiss();
        }else if (!android.util.Patterns.EMAIL_ADDRESS.matcher(email.getText().toString()).matches()) {
            Toast.makeText(getBaseContext(), "Email Tidak Valid", Toast.LENGTH_LONG).show();
            email.setFocusable(true);
            pd.dismiss();
        }else if (password.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Password Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            password.setFocusable(true);
            pd.dismiss();
        }else if (!password.getText().toString().equals(password_konfirmasi.getText().toString())) {
            Toast.makeText(getBaseContext(), "Password Tidak Dengan Password Konfirmasi", Toast.LENGTH_LONG).show();
            password.setFocusable(true);
            pd.dismiss();
        }else{
            StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.SIGN_UP, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    pd.cancel();
                    try {
                        JSONObject res = new JSONObject(response);
                        Log.d("pesan", res.toString());
                        if(res.getBoolean("status") == true){
                            JSONObject r = res.getJSONObject("data");
//                            Log.d("pesan", )
                            Toast.makeText(Sign_Up.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(getBaseContext(), Sign_In.class);
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
                    params.put("nama", nama.getText().toString());
                    params.put("email", email.getText().toString());
                    params.put("password", password.getText().toString());
                    params.put("password_konfirmasi", password_konfirmasi.getText().toString());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(senddata);
        }
    }
}
